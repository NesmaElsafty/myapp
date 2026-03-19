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
            $query->whereJsonContains('target_user', $data['target_user']);
        }

        if (isset($data['duration']) && $data['duration'] !== 'all') {
            $query->where('duration', $data['duration']);
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

        return $query;
    }

    public function create($data)
    {
        $plan = new Plan();
        $plan->name_en = $data['name_en'];
        $plan->name_ar = $data['name_ar'];
        $plan->price = $data['price'];
        $plan->duration = $data['duration'];
        $plan->duration_type = $data['duration_type'];
        $plan->free_trial_duration = $data['free_trial_duration'] ?? null;
        $plan->free_trial_duration_type = $data['free_trial_duration_type'] ?? null;
        $plan->posts_limit = $data['posts_limit'] ?? null;
        $plan->target_user = array_values(array_unique($data['target_user']));
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
        $plan->duration = $data['duration'] ?? $plan->duration;
        $plan->duration_type = $data['duration_type'] ?? $plan->duration_type;
        $plan->free_trial_duration = $data['free_trial_duration'] ?? $plan->free_trial_duration;
        $plan->free_trial_duration_type = $data['free_trial_duration_type'] ?? $plan->free_trial_duration_type;
        $plan->posts_limit = $data['posts_limit'] ?? $plan->posts_limit;
        if (isset($data['target_user'])) {
            $plan->target_user = array_values(array_unique($data['target_user']));
        }
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
                'duration' => $plan->duration,
                'duration_type' => $plan->duration_type,
                'free_trial_duration' => $plan->free_trial_duration,
                'free_trial_duration_type' => $plan->free_trial_duration_type,
                'posts_limit' => $plan->posts_limit,
                'target_user' => implode(',', $plan->target_user ?? []),
                'is_active' => $plan->is_active,
            ];
        }
        $filename = 'plans_export_' . now()->format('Ymd_His') . '.csv';
        $media = ExportHelper::exportToMedia($csvData, auth()->user(), 'exports', $filename);
        $url = $media->getUrl();

        // Build an absolute URL based on the current request to avoid scheme/host
        // mismatches (e.g. APP_URL=https://localhost while local server is http://).
        if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            $url = rtrim(request()->getSchemeAndHttpHost(), '/') . '/' . ltrim($url, '/');
        }

        return $url;
    }
}
