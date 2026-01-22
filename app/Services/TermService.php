<?php

namespace App\Services;

use App\Models\Term;
use Illuminate\Validation\ValidationException;
use App\Helpers\ExportHelper;

class TermService
{
    public function getAll($data, $language)
    {
        $query = Term::query();

        if (isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_ar', 'like', "%{$search}%")
                    ->orWhere('content_en', 'like', "%{$search}%")
                    ->orWhere('content_ar', 'like', "%{$search}%");
            });
        }

        if (isset($data['type'])) {
            $query->where('type', $data['type']);
        }
        if (isset($data['sorted_by']) && $data['sorted_by'] !== 'all') {
            switch ($data['sorted_by']) {
                case 'name':
                    $query->orderBy('title_' . ($language ?? 'en'), 'asc');
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
        return Term::find($id);
    }

    public function create($data)
    {
        return Term::create([
            'title_en' => $data['title_en'],
            'title_ar' => $data['title_ar'],
            'content_en' => $data['content_en'],
            'content_ar' => $data['content_ar'],
            'type' => $data['type'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function update($id, $data)
    {
        $term = Term::find($id);
        if (!$term) {
            throw ValidationException::withMessages(['term' => ['Term not found']]);
        }

        $term->title_en = $data['title_en'] ?? $term->title_en;
        $term->title_ar = $data['title_ar'] ?? $term->title_ar;
        $term->content_en = $data['content_en'] ?? $term->content_en;
        $term->content_ar = $data['content_ar'] ?? $term->content_ar;
        $term->type = $data['type'] ?? $term->type;
        $term->is_active = $data['is_active'] ?? $term->is_active;

        $term->save();

        return $term;
    }

    public function delete($id)
    {
        $term = Term::find($id);
        if (!$term) {
            throw ValidationException::withMessages(['term' => ['Term not found']]);
        }
        $term->delete();
        return true;
    }

    public function toggleActive($ids)
    {
        $terms = Term::whereIn('id', $ids)->get();
        foreach ($terms as $term) {
            $term->is_active = !$term->is_active;
            $term->save();
        }
        return true;
    }


    public function bulkDelete($ids)
    {
        $terms = Term::whereIn('id', $ids)->get();
        foreach ($terms as $term) {
            $term->forceDelete();
        }
        return true;
    }

    public function export($ids, $language)
    {
        $terms = Term::whereIn('id', $ids)->get();
        $csvData = [];
        foreach ($terms as $term) {
            $is_active_en = $term->is_active == 1 ? 'Active' : 'Inactive';
            $is_active_ar = $term->is_active == 1 ? 'مفعل' : 'غير مفعل';
            $csvData[] = [
                'title' => $language == 'en' ? $term->title_en : $term->title_ar,
                'content' => $language == 'en' ? $term->content_en : $term->content_ar,
                'type' => $term->type,
                'is_active' => $language == 'en' ? $is_active_en : $is_active_ar,
            ];
        }
        $filename = 'terms_export_' . now()->format('Ymd_His') . '.csv';
        $media = ExportHelper::exportToMedia($csvData, auth()->user(), 'exports', $filename);
        return $media->getUrl();
    }
}
