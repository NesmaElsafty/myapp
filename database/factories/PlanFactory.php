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
        $targetUser = fake()->randomElement(['individual', 'origin']);
        $planType = fake()->randomElement(['one_post', 'many_posts']);

        return [
            'posts_limit' => $planType === 'one_post'
                ? fake()->randomElement([1, 2, 3])
                : fake()->randomElement([30, 60, 90, 120]),
            'target_user' => $targetUser,
            'plan_type' => $planType,
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

    public function forOnePost(): static
    {
        return $this->state(fn () => [
            'plan_type' => 'one_post',
            'posts_limit' => fake()->randomElement([1, 2, 3]),
        ]);
    }

    public function forManyPosts(): static
    {
        return $this->state(fn () => [
            'plan_type' => 'many_posts',
            'posts_limit' => fake()->randomElement([30, 60, 90, 120]),
        ]);
    }
}
