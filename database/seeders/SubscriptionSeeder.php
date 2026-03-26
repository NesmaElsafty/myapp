<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanDetails;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $advertisers = User::whereIn('type', ['individual', 'origin'])->get();

        foreach ($advertisers as $advertiser) {
            $plan = Plan::where('is_active', true)
                ->where('target_user', $advertiser->type)
                ->inRandomOrder()
                ->first();

            if (!$plan) {
                continue;
            }

            $planDetails = PlanDetails::where('plan_id', $plan->id)->get();
            if ($planDetails->isEmpty()) {
                continue;
            }

            // History records (0-3) in the last 3 months.
            $historyCount = fake()->numberBetween(0, 3);

            for ($i = 0; $i < $historyCount; $i++) {
                $planDetail = $planDetails->random();
                $startDate = Carbon::instance(fake()->dateTimeBetween('-3 months', '-10 days'))->startOfDay();
                $endDate = $startDate->copy()->addDays((int) $planDetail->duration);
                $status = fake()->randomElement(['expired', 'cancelled']);
                $postsLimit = (int) ($plan->posts_limit ?? 1);

                Subscription::factory()->create([
                    'user_id' => $advertiser->id,
                    'plan_id' => $plan->id,
                    'plan_detail_id' => $planDetail->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate->isFuture() ? Carbon::today()->subDay() : $endDate,
                    'price' => $planDetail->price,
                    'status' => $status,
                    'available_posts_limit' => fake()->numberBetween(0, $postsLimit),
                    'plan_posts_limit' => $postsLimit,
                    'golde_posts' => $planDetail->promotion_type === 'gold' ? 1 : 0,
                    'silver_posts' => $planDetail->promotion_type === 'silver' ? 1 : 0,
                    'created_at' => $startDate,
                    'updated_at' => $startDate->copy()->addDays(fake()->numberBetween(0, 5)),
                ]);
            }

            // Ensure at most one active subscription per advertiser.
            if (fake()->boolean(70)) {
                $planDetail = $planDetails->random();
                $startDate = Carbon::instance(fake()->dateTimeBetween('-15 days', 'now'))->startOfDay();
                $postsLimit = (int) ($plan->posts_limit ?? 1);

                Subscription::factory()->active()->create([
                    'user_id' => $advertiser->id,
                    'plan_id' => $plan->id,
                    'plan_detail_id' => $planDetail->id,
                    'start_date' => $startDate,
                    'end_date' => Carbon::today()->addDays(max(1, (int) $planDetail->duration)),
                    'price' => $planDetail->price,
                    'available_posts_limit' => fake()->numberBetween(0, $postsLimit),
                    'plan_posts_limit' => $postsLimit,
                    'golde_posts' => $planDetail->promotion_type === 'gold' ? 1 : 0,
                    'silver_posts' => $planDetail->promotion_type === 'silver' ? 1 : 0,
                    'created_at' => $startDate,
                    'updated_at' => $startDate->copy()->addDays(fake()->numberBetween(0, 5)),
                ]);
            }
        }
    }
}
