<?php

namespace App\Services;

use App\Models\PlanDetails;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubscriptionService
{
    public function mySubscriptions(User $user, string $type = 'current')
    {
        $baseQuery = Subscription::where('user_id', $user->id);

        if($user->origin_id !== null) {
            $origin = User::find($user->origin_id);
            if($origin->subscriptions?->status === 'active') {
                $baseQuery = Subscription::where('user_id', $origin->id);
            }else{
                $baseQuery = Subscription::where('user_id', $user->id);
            }
        }

        if ($type === 'current') {
            $baseQuery->where('status', 'active');
        } else {
            $baseQuery->where('status', '!=', 'active');
        }

        return $baseQuery->paginate(10);
    }

    public function createSubscription(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {

            $planDetail = PlanDetails::find($data['plan_detail_id']);

            if (!$planDetail) {
                throw ValidationException::withMessages([
                    'plan_detail_id' => [__('messages.selected_plan_detail_invalid')],
                ]);
            }

            $plan = $planDetail->plan;


            if ($plan->target_user !== $user->type) {
                throw ValidationException::withMessages([
                    'plan_id' => [__('messages.selected_plan_account_type_mismatch')],
                ]);
            }

            // gold_posts + silver_posts must be less than or equal to the plan_posts_limit
            if ((int) $data['gold_posts'] + (int) $data['silver_posts'] > (int) $plan->posts_limit) {
                throw ValidationException::withMessages([
                    'gold_posts' => [__('messages.gold_posts_exceed_plan_limit')],
                    'silver_posts' => [__('messages.silver_posts_exceed_plan_limit')],
                ]);
            }

            $hasActive = Subscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->exists();

            if($hasActive) {
                $subscription = Subscription::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->first();
                $subscription->update([
                    'status' => 'expired',
                    'end_date' => Carbon::today(),
                ]);
            }
            
            
            // convert duration to days
            $duration = $planDetail->duration;
            $duration = $duration * 30;
            $freeTrialDuration = $planDetail->free_trial_duration ?? 0;

           if($planDetail->free_trial_duration_type === 'months') {
            $freeTrialDuration = $freeTrialDuration * 30;
           } elseif ($planDetail->free_trial_duration_type === 'years') {
            $freeTrialDuration = $freeTrialDuration * 365;
           }

           $endDate = Carbon::today()->addDays($duration + $freeTrialDuration);
                
           $subscription = new Subscription();
    
            $subscription->user_id = $user->id;
            $subscription->plan_id = $plan->id;
            $subscription->plan_detail_id = $planDetail->id;
            $subscription->start_date = Carbon::today();
            $subscription->end_date = $endDate;
            $subscription->price = $planDetail->price;
            $subscription->status = 'active';
            $subscription->available_posts_limit = $plan->posts_limit;
            $subscription->plan_posts_limit = $plan->posts_limit;
            $subscription->golde_posts = $data['gold_posts'] ?? 0;
            $subscription->silver_posts = $data['silver_posts'] ?? 0;

            $subscription->save();
            

            return $subscription;
        });
    }

    public function getAll($data)
    {
        $query = Subscription::query();

        if(isset($data['search'])) {
            $query->where('user_id', 'like', "%{$data['search']}%");
        }

        if(isset($data['status']) && $data['status'] !== 'all') {
            if($data['status'] == 'expired') {
                $query->where('status', 'expired')->orWhere('status', 'cancelled');
            }else{
                $query->where('status', $data['status']);
            }
        }

        if(isset($data['user_type']) && $data['user_type'] !== 'all') {
            $query->whereHas('user', function ($query) use ($data) {
                $query->where('type', $data['user_type']);
            });
        }
        
        if(isset($data['plan_type']) && $data['plan_type'] !== 'all') {
            $query->where('plan_type', $data['plan_type']);
        }

        return $query;
    }

    public function stats(): array
    {
        $now = Carbon::now();

        $currentMonthStart = $now->copy()->startOfMonth();
        $currentMonthEnd = $now->copy()->endOfMonth();
        $previousMonthStart = $now->copy()->subMonth()->startOfMonth();
        $previousMonthEnd = $now->copy()->subMonth()->endOfMonth();

        $totalCurrent = Subscription::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();
        $totalPrevious = Subscription::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        $activeCurrent = Subscription::where('status', 'active')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();
        $activePrevious = Subscription::where('status', 'active')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $expiredCurrent = Subscription::where('status', '!=', 'active')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();
        $expiredPrevious = Subscription::where('status', '!=', 'active')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $currentMonthSeries = $this->buildDailySeries($currentMonthStart, $currentMonthEnd);

        return [
            'period' => $currentMonthStart->format('Y-m'),
            'total_subscriptions' => [
                'value' => $totalCurrent,
                'trend' => $this->calculateTrend($totalCurrent, $totalPrevious),
                'chart' => $currentMonthSeries['total'],
            ],
            'active_subscriptions' => [
                'value' => $activeCurrent,
                'trend' => $this->calculateTrend($activeCurrent, $activePrevious),
                'chart' => $currentMonthSeries['active'],
            ],
            'expired_subscriptions' => [
                'value' => $expiredCurrent,
                'trend' => $this->calculateTrend($expiredCurrent, $expiredPrevious),
                'chart' => $currentMonthSeries['expired'],
            ],
        ];
    }

    protected function calculateTrend(int $current, int $previous): array
    {
        if ($previous === 0) {
            $percentage = $current > 0 ? 100.0 : 0.0;
        } else {
            $percentage = (($current - $previous) / $previous) * 100;
        }

        return [
            
            'difference' => $current - $previous,
            'percentage' => round($percentage, 2),
            'direction' => $current > $previous ? 'up' : ($current < $previous ? 'down' : 'stable'),
        ];
    }

    protected function buildDailySeries(Carbon $monthStart, Carbon $monthEnd): array
    {
        $rows = Subscription::selectRaw('DATE(created_at) as day')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active")
            ->selectRaw("SUM(CASE WHEN status != 'active' THEN 1 ELSE 0 END) as expired")
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $total = [];
        $active = [];
        $expired = [];

        foreach (CarbonPeriod::create($monthStart, $monthEnd) as $date) {
            $day = $date->format('Y-m-d');
            $row = $rows->get($day);

            $total[] = (int) ($row->total ?? 0);
            $active[] = (int) ($row->active ?? 0);
            $expired[] = (int) ($row->expired ?? 0);
        }

        return [
            'total' => $total,
            'active' => $active,
            'expired' => $expired,
        ];
    }

}
