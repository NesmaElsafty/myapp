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

    /** Arabic screen names for generic use */
    private static array $namesAr = [
        'تفاصيل العقار', 'الموقع والعنوان', 'التسعير والدفع', 'نظرة عامة', 'النطاق والمخرجات',
        'الجدول الزمني', 'الميزانية', 'تفاصيل اللوحة', 'معلومات المركبة', 'تفاصيل القطعة',
        'الحالة والصور', 'معلومات العقار', 'المميزات والمرافق', 'تفاصيل الإيجار', 'التوفر والأسعار',
    ];

    /** Arabic descriptions */
    private static array $descriptionsAr = [
        'أدخل المعلومات المطلوبة في هذه الشاشة.',
        'حدد التفاصيل ذات الصلة بهذا القسم.',
        'هذه الشاشة تحتوي على الحقول الأساسية.',
        'أكمل البيانات التالية للمتابعة.',
    ];

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
            'name_ar' => fake()->randomElement(self::$namesAr),
            'description_en' => fake()->paragraph(),
            'description_ar' => fake()->randomElement(self::$descriptionsAr),
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
