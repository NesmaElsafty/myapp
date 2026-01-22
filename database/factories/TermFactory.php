<?php

namespace Database\Factories;

use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Term>
 */
class TermFactory extends Factory
{
    protected $model = Term::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['terms', 'privacy'];
        
        return [
            'title_en' => fake()->sentence(4),
            'title_ar' => 'شروط ' . fake()->words(2, true),
            'content_en' => fake()->paragraphs(5, true),
            'content_ar' => fake()->paragraphs(5, true),
            'type' => fake()->randomElement($types),
            'is_active' => fake()->boolean(80),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => ['is_active' => true]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => ['is_active' => false]);
    }

    public function forTerms(): static
    {
        return $this->state(fn (array $attributes) => ['type' => 'terms']);
    }

    public function forPrivacy(): static
    {
        return $this->state(fn (array $attributes) => ['type' => 'privacy']);
    }
}
