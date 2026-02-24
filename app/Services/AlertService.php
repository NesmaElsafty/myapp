<?php

namespace App\Services;

use App\Models\Alert;
use App\Models\Notification;
use App\Models\User;
class AlertService
{

    public function getForUser(int $userId, array $filters = [])
    {
        $filters['user_id'] = $userId;
        return $this->getAll($filters);
    }

    public function getById(int $id): Alert
    {
        return Alert::findOrFail($id);
    }

    public function create(array $data = [], int $notification_id = null)
    {
        if($notification_id) {
            $notification = Notification::find($notification_id);
                $target_type = $notification->target_type;
                $users = User::whereIn('type', $target_type)->where('is_active', true)->pluck('id');
                foreach($users as $user) {
                    Alert::create([
                        'user_id' => $user,
                        'title_en' => $notification->title_en,
                        'title_ar' => $notification->title_ar,
                        'content_en' => $notification->content_en,
                        'content_ar' => $notification->content_ar,
                    ]);
                }
        }else{
            $userId = $data['user_id'] ?? null;
            Alert::create([
                'user_id' => $userId,
                'title_en' => $data['title_en'] ?? null,
                'title_ar' => $data['title_ar'] ?? null,
                'content_en' => $data['content_en'] ?? null,
                'content_ar' => $data['content_ar'] ?? null,
            ]);
        }
        return true;
    }

    public function markAsRead(int $id): Alert
    {
        $alert = $this->getById($id);
        $alert->update(['is_read' => true]);

        return $alert->fresh();
    }

    public function markAllAsReadForUser(int $userId): int
    {
        return Alert::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function delete(int $id): bool
    {
        $alert = $this->getById($id);
        return (bool) $alert->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return Alert::whereIn('id', $ids)->delete();
    }

    public function export(array $ids)
    {
        return Alert::whereIn('id', $ids)->get();
    }
}

