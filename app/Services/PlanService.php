<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\PlanDetails;
// helper to export plans
use App\Helpers\ExportHelper;
class PlanService
{
    public function getAll($data = [], ?string $language = 'en')
    {
        $query = Plan::query();

        if (isset($data['target_user']) && $data['target_user'] !== 'all') {
            $query->where('target_user', $data['target_user']);
        }

        if (isset($data['plan_type']) && $data['plan_type'] !== 'all') {
            $query->where('plan_type', $data['plan_type']);
        }

        if (isset($data['sorted_by']) && $data['sorted_by'] !== 'all') {
            switch ($data['sorted_by']) {
                case 'newest':
                    $query->orderBy('id', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
            }
        } 

        if (isset($data['is_active']) && $data['is_active'] !== 'all') {
            $query->where('is_active', $data['is_active']);
        }

        return $query;
    }

    public function create($data)
    {
        $plan = new Plan();
        $plan->target_user = $data['target_user'];
        $plan->plan_type = $data['plan_type'];
        $plan->posts_limit = $data['plan_type'] === 'one_post' ? 1 : $data['posts_limit'];
        $plan->is_active = $data['is_active'];
        $plan->save();

        if($plan->plan_type === 'one_post') {
            foreach ($data['details'] as $detail) {
                $planDetails = new PlanDetails();
                $planDetails->plan_id = $plan->id;
                $planDetails->price = $detail['price'];
                $planDetails->duration = $detail['duration'];
                $planDetails->category_id = $detail['category_id'];
                $planDetails->is_promoted = $detail['is_promoted'];
                $planDetails->promotion_type = $detail['promotion_type'];
                $planDetails->save();
            }
        } else {
            foreach ($data['details'] as $detail) {
                $planDetails = new PlanDetails();
                $planDetails->plan_id = $plan->id;
                $planDetails->price = $detail['price'];
                $planDetails->duration = $detail['duration'];
                $planDetails->free_trial_duration = $detail['free_trial_duration'];
                $planDetails->free_trial_duration_type = $detail['free_trial_duration_type'];
                $planDetails->save();
            }
        }


        return $plan;
    }

    public function update($plan, $data)
    {
        $plan->target_user = $data['target_user'];
        $plan->plan_type = $data['plan_type'];
        $plan->posts_limit = $data['plan_type'] === 'one_post' ? 1 : $data['posts_limit'];
        $plan->is_active = $data['is_active'];
        $plan->save();

        if($plan->plan_type === 'one_post') {
            foreach ($data['details'] as $detail) {
                $planDetails = PlanDetails::updateOrCreate([
                    'plan_id' => $plan->id,
                    'category_id' => $detail['category_id'],
                    'is_promoted' => $detail['is_promoted'],
                ], [
                    'price' => $detail['price'],
                    'duration' => $detail['duration'],
                    'promotion_type' => $detail['promotion_type'],
                ]);
            }
        } else {
            foreach ($data['details'] as $detail) {
                $planDetails = PlanDetails::updateOrCreate([
                    'plan_id' => $plan->id,
                    'duration' => $detail['duration'],
                ], [
                    'price' => $detail['price'],
                    'free_trial_duration' => $detail['free_trial_duration'],
                    'free_trial_duration_type' => $detail['free_trial_duration_type'],
                ]);
            }
        }

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
                'id' => $plan->id,
                'target_user' => $plan->target_user,
                'plan_type' => $plan->plan_type,
                'posts_count' => 0,
                'subscription_count' => 0,
                'is_active' => $plan->is_active,
                'created_at' => $plan->created_at?->format('Y-m-d H:i:s'),
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
