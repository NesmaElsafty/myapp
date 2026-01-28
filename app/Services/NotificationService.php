<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    public function getAll($filters, $language)
    {
        $query = Notification::query();

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_ar', 'like', "%{$search}%")
                    ->orWhere('content_en', 'like', "%{$search}%")
                    ->orWhere('content_ar', 'like', "%{$search}%");
            });
        }

        if (isset($filters['type']) && $filters['type'] !== 'all') {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['target_type']) && $filters['target_type'] !== 'all') {
            $targetType = $filters['target_type'];
            $query->whereJsonContains('target_type', $targetType);
        }

        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['sorted_by']) && $filters['sorted_by'] !== 'all') {
            switch ($filters['sorted_by']) {
                case 'title':
                    $query->orderBy('title_' . ($filters['language'] ?? 'en'), 'asc');
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
        return Notification::findOrFail($id);
    }

    public function create($data)
    {
        return Notification::create($data);
    }

    public function update($id, $data)
    {
        $notification = $this->getById($id);
        $notification->update($data);
        return $notification->fresh();
    }

    public function delete($id)
    {
        $notification = $this->getById($id);
        return $notification->delete();
    }

    public function updateStatus($id, $status)
    {
        $notification = $this->getById($id);
        $notification->update(['status' => $status]);
        return $notification;
    }

    public function bulkDelete(array $ids)
    {
        return Notification::whereIn('id', $ids)->delete();
    }

    public function export(array $ids)
    {
        return Notification::whereIn('id', $ids)->get();
    }
}
