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
            $subscription->golde_posts = $data['gold_posts'];
            $subscription->silver_posts = $data['silver_posts'];

            $subscription->save();
            

            return $subscription;
        });
    }

}
