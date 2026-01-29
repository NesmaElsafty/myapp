<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Validation\ValidationException;
// helper to export plans
use App\Helpers\ExportHelper;
class PlanService
{
    /**
     * Get all plans with optional filters.
     */
    public function getAll($data = [], ?string $language = 'en')
    {
        $query = Plan::query();

        if (isset($data['search']) && $data['search'] !== '') {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_ar', 'like', "%{$search}%");
            });
        }

        if (isset($data['is_active']) && $data['is_active'] !== 'all') {
            $query->where('is_active', $data['is_active']);
        }

        $user = auth()->user();
        if($user && $user->type !== 'admin') {
            $query->where('is_active', true);
        }

        if (isset($data['target_user']) && $data['target_user'] !== 'all') {
            $query->where('target_user', $data['target_user']);
        }

        

        if (isset($data['sorted_by']) && $data['sorted_by'] !== 'all') {
            $lang = $language ?? 'en';
            switch ($data['sorted_by']) {
                case 'name':
                    $query->orderBy('name_' . $lang, 'asc');
                    break;
                case 'newest':
                    $query->orderBy('id', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
            }
        } 

        if(isset($data['official_duration']) && $data['official_duration'] !== 'all') {
            $query->where('official_duration', $data['official_duration']);
        }

        return $query;
    }

    public function create($data)
    {
        $plan = new Plan();
        $plan->name_en = $data['name_en'];
        $plan->name_ar = $data['name_ar'];
        $plan->price = $data['price'];
        $plan->official_duration = $data['official_duration'];
        $plan->free_duration = $data['free_duration'];
        $plan->posts_limit = $data['posts_limit'];
        $plan->target_user = $data['target_user'];
        $plan->is_active = $data['is_active'] ?? true;
        $plan->save();

        return $plan;
    }

    public function update($id, $data)
    {
        $plan = Plan::find($id);
        $plan->name_en = $data['name_en'] ?? $plan->name_en;
        $plan->name_ar = $data['name_ar'] ?? $plan->name_ar;
        $plan->price = $data['price'] ?? $plan->price;
        $plan->official_duration = $data['official_duration'] ?? $plan->official_duration;
        $plan->free_duration = $data['free_duration'] ?? $plan->free_duration;
        $plan->posts_limit = $data['posts_limit'] ?? $plan->posts_limit;
        $plan->target_user = $data['target_user'] ?? $plan->target_user;
        $plan->is_active = $data['is_active'] ?? $plan->is_active;
        $plan->save();

        return $plan;
    }

    public function toggleActive($ids): bool
    {
        $plans = Plan::whereIn('id', $ids)->get();
        foreach ($plans as $plan) {
            $plan->is_active = !$plan->is_active;
            $plan->save();
        }
        return true;
    }

    public function bulkDelete($ids): bool
    {
        $plans = Plan::whereIn('id', $ids)->get();
        foreach ($plans as $plan) {
            $plan->delete();
        }
        return true;
    }

    public function export($ids, $language)
    {
        $plans = Plan::whereIn('id', $ids)->get();
        $csvData = [];
        foreach ($plans as $plan) {
            $csvData[] = [
                'name' => $language == 'en' ? $plan->name_en : $plan->name_ar,
                'price' => $plan->price,
                'official_duration' => $plan->official_duration,
                'free_duration' => $plan->free_duration,
                'posts_limit' => $plan->posts_limit,
                'target_user' => $plan->target_user,
                'is_active' => $plan->is_active,
            ];
        }
        $filename = 'plans_export_' . now()->format('Ymd_His') . '.csv';
        $media = ExportHelper::exportToMedia($csvData, auth()->user(), 'exports', $filename);
        return $media->getUrl();
    }
}
