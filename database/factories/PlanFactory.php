<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $targetUsers = ['individual', 'origin'];
        $durationTypes = ['days', 'months', 'years'];
        $freeTrialDurationTypes = ['days', 'months', 'years'];

        $durationType = fake()->randomElement($durationTypes);
        $durationValue = match ($durationType) {
            'days' => fake()->randomElement([7, 14, 30, 60, 90]),
            'months' => fake()->randomElement([1, 3, 6, 12]),
            'years' => fake()->randomElement([1, 2]),
        };

        $freeTrialType = fake()->randomElement($freeTrialDurationTypes);
        $freeTrialValue = match ($freeTrialType) {
            'days' => fake()->randomElement([0, 3, 7, 14, 30]),
            'months' => fake()->randomElement([0, 1, 2]),
            'years' => fake()->randomElement([0, 1]),
        };

        $selectedTargetUsers = fake()->randomElements($targetUsers, fake()->numberBetween(1, 2));

        return [
            'name_en' => fake()->words(3, true),
            'name_ar' => fake()->words(3, true),
            'price' => fake()->randomFloat(2, 10, 500),
            'duration' => $durationValue,
            'duration_type' => $durationType,
            'free_trial_duration' => $freeTrialValue,
            'free_trial_duration_type' => $freeTrialType,
            'posts_limit' => fake()->randomElement([10, 50, 100, 200, 500, 1000]),
            'target_user' => $selectedTargetUsers,
            'is_active' => fake()->boolean(80),
        ];
    }

    /**
     * Indicate that the plan is for individuals.
     */
    public function forIndividual(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_user' => ['individual'],
        ]);
    }

    /**
     * Indicate that the plan is for origins.
     */
    public function forOrigin(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_user' => ['origin'],
        ]);
    }

    public function forAllTargets(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_user' => ['individual', 'origin'],
        ]);
    }

    /**
     * Indicate that the plan is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the plan is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
