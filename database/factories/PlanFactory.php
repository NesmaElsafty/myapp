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

        return [
            'name_en' => fake()->words(3, true),
            'name_ar' => fake()->words(3, true),
            'price' => fake()->randomFloat(2, 10, 500),
            'official_duration' => fake()->randomElement(['1 month', '3 months', '6 months', '1 year']),
            'free_duration' => fake()->randomElement(['7 days', '14 days', '30 days', null]),
            'posts_limit' => fake()->randomElement(['10', '50', '100', 'unlimited']),
            'target_user' => fake()->randomElement($targetUsers),
            'is_active' => fake()->boolean(80),
        ];
    }

    /**
     * Indicate that the plan is for individuals.
     */
    public function forIndividual(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_user' => 'individual',
        ]);
    }

    /**
     * Indicate that the plan is for origins.
     */
    public function forOrigin(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_user' => 'origin',
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
