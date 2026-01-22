<?php

namespace App\Services;

use App\Models\Faq;
use Illuminate\Validation\ValidationException;
use App\Helpers\ExportHelper;

class FaqService
{
    public function getAll($data, $language)
    {
        $query = Faq::query();

        if (isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('question_en', 'like', "%{$search}%")
                    ->orWhere('question_ar', 'like', "%{$search}%")
                    ->orWhere('answer_en', 'like', "%{$search}%")
                    ->orWhere('answer_ar', 'like', "%{$search}%");
            });
        }

        if (isset($data['segment'])) {
            $query->where('segment', $data['segment']);
        }
        if (isset($data['sorted_by']) && $data['sorted_by'] !== 'all') {
            switch ($data['sorted_by']) {
                case 'name':
                    $query->orderBy('question_' . $language ?? 'en', 'asc');
                    break;
                case 'newest':
                    $query->orderBy('id', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        if (isset($data['is_active'])) {
            $query->where('is_active', $data['is_active']);
        }
        return $query;
    }

    public function getById($id)
    {
        return Faq::find($id);
    }

    public function create($data)
    {
        return Faq::create([
            'question_en' => $data['question_en'],
            'question_ar' => $data['question_ar'],
            'answer_en' => $data['answer_en'],
            'answer_ar' => $data['answer_ar'],
            'segment' => $data['segment'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function update($id, $data)
    {
        $faq = Faq::find($id);
        if (!$faq) {
            throw ValidationException::withMessages(['faq' => ['FAQ not found']]);
        }

        $faq->question_en = $data['question_en'] ?? $faq->question_en;
        $faq->question_ar = $data['question_ar'] ?? $faq->question_ar;
        $faq->answer_en = $data['answer_en'] ?? $faq->answer_en;
        $faq->answer_ar = $data['answer_ar'] ?? $faq->answer_ar;
        $faq->segment = $data['segment'] ?? $faq->segment;
        $faq->is_active = $data['is_active'] ?? $faq->is_active;

        $faq->save();

        return $faq;
    }

    public function delete($id)
    {
        $faq = Faq::find($id);
        if (!$faq) {
            throw ValidationException::withMessages(['faq' => ['FAQ not found']]);
        }
        $faq->delete();
        return true;
    }

    public function toggleActive($ids)
    {
        $faqs = Faq::whereIn('id', $ids)->get();
        foreach ($faqs as $faq) {
            $faq->is_active = !$faq->is_active;
            $faq->save();
        }
        return true;
    }


    public function bulkDelete($ids)
    {
        $faqs = Faq::whereIn('id', $ids)->get();
        foreach ($faqs as $faq) {
            $faq->forceDelete();
        }
        return true;
    }

    public function export($ids, $language)
    {
        $faqs = Faq::whereIn('id', $ids)->get();
        $csvData = [];
        foreach ($faqs as $faq) {
            $is_active_en = $faq->is_active == 1 ? 'Active' : 'Inactive';
            $is_active_ar = $faq->is_active == 1 ? 'مفعل' : 'غير مفعل';
            $csvData[] = [
                'question' => $language == 'en' ? $faq->question_en : $faq->question_ar,
                'answer' => $language == 'en' ? $faq->answer_en : $faq->answer_ar,
                'segment' => $faq->segment,
                'is_active' => $language == 'en' ? $is_active_en : $is_active_ar,
            ];
        }
        $filename = 'faqs_export_' . now()->format('Ymd_His') . '.csv';
        $media = ExportHelper::exportToMedia($csvData, auth()->user(), 'exports', $filename);
        return $media->getUrl();
    }
}
