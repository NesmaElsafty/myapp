<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Screen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Screen>
 */
class ScreenFactory extends Factory
{
    protected $model = Screen::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();
        if (!$category) {
            $category = Category::first();
        }
        return [
            'name_en' => fake()->words(3, true),
            'name_ar' => fake()->words(3, true),
            'description_en' => fake()->paragraph(),
            'description_ar' => fake()->paragraph(),
            'category_id' => $category?->id ?? 1,
        ];
    }

    /**
     * Indicate that the screen belongs to a specific category.
     */
    public function forCategory(Category $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => $category->id,
        ]);
    }
}
