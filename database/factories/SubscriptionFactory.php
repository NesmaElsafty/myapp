<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\PlanDetails;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::instance(fake()->dateTimeBetween('-3 months', 'now'))->startOfDay();
        $duration = fake()->randomElement([30, 60, 90]);
        $status = fake()->randomElement(['active', 'expired', 'cancelled']);
        $endDate = $startDate->copy()->addDays($duration);

        $planDetail = PlanDetails::query()->inRandomOrder()->first();
        $plan = $planDetail?->plan;
        $user = User::whereIn('type', ['individual', 'origin'])->inRandomOrder()->first();

        if (!$planDetail || !$plan) {
            throw new \RuntimeException('SubscriptionFactory requires existing plan_details linked to plans.');
        }

        return [
            'user_id' => $user?->id ?? User::factory()->create(['type' => 'individual'])->id,
            'plan_id' => $plan->id,
            'plan_detail_id' => $planDetail->id,
            'start_date' => $startDate,
            'end_date' => $status === 'active' ? $endDate->copy()->addDays(fake()->numberBetween(1, 45)) : $endDate,
            'price' => fake()->randomFloat(2, 20, 1000),
            'status' => $status,
            'available_posts_limit' => fake()->numberBetween(0, 120),
            'plan_posts_limit' => fake()->numberBetween(1, 120),
            'golden_posts' => fake()->numberBetween(0, 5),
            'silver_posts' => fake()->numberBetween(0, 5),
            'created_at' => $startDate,
            'updated_at' => fake()->dateTimeBetween($startDate, 'now'),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'status' => 'active',
            'end_date' => Carbon::today()->addDays(fake()->numberBetween(1, 45)),
        ]);
    }

    public function expiredOrCancelled(): static
    {
        return $this->state(fn () => [
            'status' => fake()->randomElement(['expired', 'cancelled']),
            'end_date' => Carbon::today()->subDays(fake()->numberBetween(1, 45)),
        ]);
    }
}
