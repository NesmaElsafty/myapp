<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $segments = ['user', 'origin', 'individual'];
        
        return [
            'question_en' => fake()->sentence(6) . '?',
            'question_ar' => 'كيف ' . fake()->words(3, true) . '؟',
            'answer_en' => fake()->paragraphs(2, true),
            'answer_ar' => fake()->paragraphs(2, true),
            'segment' => fake()->randomElement($segments),
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

    public function forUser(): static
    {
        return $this->state(fn (array $attributes) => ['segment' => 'user']);
    }

    public function forOrigin(): static
    {
        return $this->state(fn (array $attributes) => ['segment' => 'origin']);
    }

    public function forIndividual(): static
    {
        return $this->state(fn (array $attributes) => ['segment' => 'individual']);
    }
}
