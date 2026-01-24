<?php

namespace App\Services;

use App\Models\Inquiry;
use Illuminate\Validation\ValidationException;
use App\Helpers\ExportHelper;

class InquiryService
{
    public function getAll($data, $language)
    {
        $query = Inquiry::query();

        if (isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if (isset($data['account_type']) && $data['account_type'] !== 'all') {
            $query->where('account_type', $data['account_type']);
        }

        if (isset($data['sorted_by']) && $data['sorted_by'] !== 'all') {
            switch ($data['sorted_by']) {
                case 'name':
                    $query->orderBy('name', 'asc');
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

        return $query;
    }

    public function getById($id)
    {
        return Inquiry::find($id);
    }

    public function create($data)
    {
        return Inquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'message' => $data['message'],
            'account_type' => $data['account_type'] ?? null,
            'is_replied' => false,
            'reply_message' => null,
        ]);
    }

    public function update($id, $data)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            throw ValidationException::withMessages(['inquiry' => ['Inquiry not found']]);
        }

        $inquiry->name = $data['name'] ?? $inquiry->name;
        $inquiry->email = $data['email'] ?? $inquiry->email;
        $inquiry->phone = $data['phone'] ?? $inquiry->phone;
        $inquiry->message = $data['message'] ?? $inquiry->message;
        $inquiry->account_type = $data['account_type'] ?? $inquiry->account_type;
        $inquiry->is_replied = $data['is_replied'] ?? $inquiry->is_replied;
        $inquiry->reply_message = $data['reply_message'] ?? $inquiry->reply_message;

        $inquiry->save();

        return $inquiry;
    }

    public function reply($id, $replyMessage)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            throw ValidationException::withMessages(['inquiry' => ['Inquiry not found']]);
        }

        $inquiry->is_replied = true;
        $inquiry->reply_message = $replyMessage;
        $inquiry->save();

        return $inquiry;
    }

    public function delete($id)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            throw ValidationException::withMessages(['inquiry' => ['Inquiry not found']]);
        }
        $inquiry->delete();
        return true;
    }

    public function toggleReplied($ids)
    {
        $inquiries = Inquiry::whereIn('id', $ids)->get();
        foreach ($inquiries as $inquiry) {
            $inquiry->is_replied = !$inquiry->is_replied;
            if (!$inquiry->is_replied) {
                $inquiry->reply_message = null;
            }
            $inquiry->save();
        }
        return true;
    }

    public function bulkDelete($ids)
    {
        $inquiries = Inquiry::whereIn('id', $ids)->get();
        foreach ($inquiries as $inquiry) {
            $inquiry->forceDelete();
        }
        return true;
    }

    public function export($ids, $language)
    {
        $inquiries = Inquiry::whereIn('id', $ids)->get();
        $csvData = [];
        foreach ($inquiries as $inquiry) {
            $is_replied_en = $inquiry->is_replied == 1 ? 'Replied' : 'Not Replied';
            $is_replied_ar = $inquiry->is_replied == 1 ? 'تم الرد' : 'لم يتم الرد';
            $csvData[] = [
                'name' => $inquiry->name,
                'email' => $inquiry->email,
                'phone' => $inquiry->phone,
                'message' => $inquiry->message,
                'account_type' => $inquiry->account_type,
                'is_replied' => $language == 'en' ? $is_replied_en : $is_replied_ar,
                'reply_message' => $inquiry->reply_message,
            ];
        }
        $filename = 'inquiries_export_' . now()->format('Ymd_His') . '.csv';
        $media = ExportHelper::exportToMedia($csvData, auth()->user(), 'exports', $filename);
        return $media->getUrl();
    }
}
