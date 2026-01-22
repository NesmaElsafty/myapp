<?php

namespace Database\Factories;

use App\Models\Support;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Support>
 */
class SupportFactory extends Factory
{
    protected $model = Support::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $accountTypes = ['user', 'individual', 'origin'];
        
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'message' => fake()->paragraphs(3, true),
            'account_type' => fake()->randomElement($accountTypes),
            'is_replied' => fake()->boolean(30),
            'reply_message' => fake()->boolean(30) ? fake()->paragraphs(2, true) : null,
        ];
    }

    public function replied(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_replied' => true,
            'reply_message' => fake()->paragraphs(2, true),
        ]);
    }

    public function notReplied(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_replied' => false,
            'reply_message' => null,
        ]);
    }

    public function forUser(): static
    {
        return $this->state(fn (array $attributes) => ['account_type' => 'user']);
    }

    public function forIndividual(): static
    {
        return $this->state(fn (array $attributes) => ['account_type' => 'individual']);
    }

    public function forAgent(): static
    {
        return $this->state(fn (array $attributes) => ['account_type' => 'agent']);
    }

    public function forOrigin(): static
    {
        return $this->state(fn (array $attributes) => ['account_type' => 'origin']);
    }
}
