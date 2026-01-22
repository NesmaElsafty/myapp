<?php

namespace App\Services;

use App\Models\Support;
use Illuminate\Validation\ValidationException;
use App\Helpers\ExportHelper;

class SupportService
{
    public function getAll($data, $language)
    {
        $query = Support::query();

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
        return Support::find($id);
    }

    public function create($data)
    {
        return Support::create([
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
        $support = Support::find($id);
        if (!$support) {
            throw ValidationException::withMessages(['support' => ['Support ticket not found']]);
        }

        $support->name = $data['name'] ?? $support->name;
        $support->email = $data['email'] ?? $support->email;
        $support->phone = $data['phone'] ?? $support->phone;
        $support->message = $data['message'] ?? $support->message;
        $support->account_type = $data['account_type'] ?? $support->account_type;
        $support->is_replied = $data['is_replied'] ?? $support->is_replied;
        $support->reply_message = $data['reply_message'] ?? $support->reply_message;

        $support->save();

        return $support;
    }

    public function reply($id, $replyMessage)
    {
        $support = Support::find($id);
        if (!$support) {
            throw ValidationException::withMessages(['support' => ['Support ticket not found']]);
        }

        $support->is_replied = true;
        $support->reply_message = $replyMessage;
        $support->save();

        return $support;
    }

    public function delete($id)
    {
        $support = Support::find($id);
        if (!$support) {
            throw ValidationException::withMessages(['support' => ['Support ticket not found']]);
        }
        $support->delete();
        return true;
    }

    public function toggleReplied($ids)
    {
        $supports = Support::whereIn('id', $ids)->get();
        foreach ($supports as $support) {
            $support->is_replied = !$support->is_replied;
            if (!$support->is_replied) {
                $support->reply_message = null;
            }
            $support->save();
        }
        return true;
    }

    public function bulkDelete($ids)
    {
        $supports = Support::whereIn('id', $ids)->get();
        foreach ($supports as $support) {
            $support->forceDelete();
        }
        return true;
    }

    public function export($ids, $language)
    {
        $supports = Support::whereIn('id', $ids)->get();
        $csvData = [];
        foreach ($supports as $support) {
            $is_replied_en = $support->is_replied == 1 ? 'Replied' : 'Not Replied';
            $is_replied_ar = $support->is_replied == 1 ? 'تم الرد' : 'لم يتم الرد';
            $csvData[] = [
                'name' => $support->name,
                'email' => $support->email,
                'phone' => $support->phone,
                'message' => $support->message,
                'account_type' => $support->account_type,
                'is_replied' => $language == 'en' ? $is_replied_en : $is_replied_ar,
                'reply_message' => $support->reply_message,
            ];
        }
        $filename = 'supports_export_' . now()->format('Ymd_His') . '.csv';
        $media = ExportHelper::exportToMedia($csvData, auth()->user(), 'exports', $filename);
        return $media->getUrl();
    }
}
