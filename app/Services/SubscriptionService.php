<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\PlanDetails;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubscriptionService
{
    public function mySubscriptions(User $user, string $type = 'current')
    {
        $baseQuery = Subscription::with(['plan', 'planDetail'])
            ->where('user_id', $user->id);

        if($user->origin_id !== null) {
            $baseQuery = Subscription::with(['plan', 'planDetail'])
            ->where('user_id', $user->origin_id);
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
            $subscription->golde_posts = $data['gold_posts'];
            $subscription->silver_posts = $data['silver_posts'];

            $subscription->save();
            

            return $subscription;
        });
    }

    public function updateSubscription(User $user, Subscription $subscription, array $data)
    {
        if ((int) $subscription->user_id !== (int) $user->id) {
            throw ValidationException::withMessages([
                'subscription_id' => ['This subscription does not belong to you.'],
            ]);
        }

        $action = $data['action'] ?? null;

        return match ($action) {
            'cancel' => $this->cancelSubscription($subscription),
            'renew' => $this->renewSubscription($user, $subscription, $data),
            default => throw ValidationException::withMessages([
                'action' => ['Invalid action.'],
            ]),
        };
    }

    public function expireSubscriptions(): int
    {
        return Subscription::where('status', 'active')
            ->whereDate('end_date', '<', Carbon::today())
            ->update(['status' => 'expired']);
    }

    protected function cancelSubscription(Subscription $subscription)
    {
        if ($subscription->status !== 'active') {
            throw ValidationException::withMessages([
                'subscription' => ['Only active subscriptions can be cancelled.'],
            ]);
        }

        $subscription->update([
            'status' => 'cancelled',
            'end_date' => Carbon::today(),
        ]);

        return $subscription->fresh(['plan', 'planDetail']);
    }

    protected function renewSubscription(User $user, Subscription $subscription, array $data)
    {
        if ($subscription->status !== 'active') {
            throw ValidationException::withMessages([
                'subscription' => ['Only active subscriptions can be renewed.'],
            ]);
        }

        return DB::transaction(function () use ($user, $subscription, $data) {
            $planId = $data['plan_id'] ?? $subscription->plan_id;
            $planDetailId = $data['plan_detail_id'] ?? $subscription->plan_detail_id;

            $newSubscription = $this->createSubscriptionFromIds($user, (int) $planId, (int) $planDetailId);

            $subscription->update([
                'status' => 'expired',
                'end_date' => Carbon::today(),
            ]);

            return $newSubscription->fresh(['plan', 'planDetail']);
        });
    }

    protected function createSubscriptionFromIds(User $user, int $planId, int $planDetailId)
    {
        $plan = Plan::where('id', $planId)
            ->where('is_active', true)
            ->first();

        if (!$plan) {
            throw ValidationException::withMessages([
                'plan_id' => ['Selected plan is invalid or inactive.'],
            ]);
        }

        if ($plan->target_user !== $user->type) {
            throw ValidationException::withMessages([
                'plan_id' => ['Selected plan does not match your account type.'],
            ]);
        }

        $planDetail = PlanDetails::where('id', $planDetailId)
            ->where('plan_id', $plan->id)
            ->first();

        if (!$planDetail) {
            throw ValidationException::withMessages([
                'plan_detail_id' => ['Selected plan detail is invalid for the chosen plan.'],
            ]);
        }

        return Subscription::create($this->buildSubscriptionPayload($user, $plan, $planDetail));
    }

    protected function buildSubscriptionPayload(User $user, Plan $plan, PlanDetails $planDetail): array
    {
        $startDate = Carbon::today();
        $endDate = $startDate->copy()->addDays((int) $planDetail->duration);
        $postsLimit = (int) ($plan->posts_limit ?? 1);
        $promotionType = $planDetail->promotion_type;

        return [
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'plan_detail_id' => $planDetail->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price' => $planDetail->price,
            'status' => 'active',
            'available_posts_limit' => $postsLimit,
            'plan_posts_limit' => $postsLimit,
            'golde_posts' => $promotionType === 'gold' ? 1 : 0,
            'silver_posts' => $promotionType === 'silver' ? 1 : 0,
        ];
    }
}
