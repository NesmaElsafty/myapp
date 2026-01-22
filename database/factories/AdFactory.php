<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_en' => fake()->sentence(4),
            'title_ar' => 'إعلان ' . fake()->numberBetween(1, 100),
            'description_en' => fake()->paragraphs(2, true),
            'description_ar' => fake()->paragraphs(2, true),
            'is_active' => fake()->boolean(80),
            'btn_text_en' => fake()->optional(0.7)->randomElement(['Learn More', 'Shop Now', 'View Details', 'Get Started']),
            'btn_text_ar' => fake()->optional(0.7)->randomElement(['اعرف المزيد', 'تسوق الآن', 'عرض التفاصيل', 'ابدأ الآن']),
            'btn_link' => fake()->optional(0.7)->url(),
            'btn_is_active' => fake()->boolean(50),
            'type' => fake()->randomElement(['promotion', 'interface']),
        ];
    }

    public function promotion(): static
    {
        return $this->state(fn (array $attributes) => ['type' => 'promotion']);
    }

    public function interface(): static
    {
        return $this->state(fn (array $attributes) => ['type' => 'interface']);
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => ['is_active' => true]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => ['is_active' => false]);
    }
}
