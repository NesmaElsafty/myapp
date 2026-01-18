<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Arabic first names
     */
    protected array $arabicFirstNames = [
        'محمد', 'أحمد', 'علي', 'حسن', 'حسين', 'عبدالله', 'خالد', 'سعد', 'فهد', 'عمر',
        'يوسف', 'إبراهيم', 'عبدالرحمن', 'عبدالعزيز', 'مشعل', 'نواف', 'فيصل', 'تركي', 'بندر', 'سلطان',
        'فاطمة', 'عائشة', 'خديجة', 'مريم', 'زينب', 'سارة', 'نورا', 'لينا', 'ريم', 'ليلى',
        'نورة', 'هند', 'سلمى', 'رغد', 'دانة', 'لولوة', 'جواهر', 'شهد', 'تالا', 'رنا'
    ];

    /**
     * Arabic last names
     */
    protected array $arabicLastNames = [
        'الخالدي', 'السالم', 'العلي', 'الحمد', 'الرشيد', 'الغامدي', 'الزهراني', 'العتيبي', 'الدوسري', 'الشمري',
        'القحطاني', 'القرني', 'الجهني', 'الحربي', 'السهلي', 'المطيري', 'الخالدي', 'الغامدي', 'العنزي', 'السبيعي',
        'النجدي', 'الحجازي', 'النجار', 'الحداد', 'الصالح', 'المالك', 'الخليفة', 'السلطان', 'الأمير', 'الشيخ'
    ];

    /**
     * Saudi Arabia cities
     */
    protected array $saudiCities = [
        'الرياض', 'جدة', 'مكة المكرمة', 'المدينة المنورة', 'الدمام', 'الخبر', 'الطائف', 'بريدة', 'تبوك', 'خميس مشيط',
        'حفر الباطن', 'المبرز', 'الهفوف', 'الجبيل', 'نجران', 'أبها', 'جازان', 'ينبع', 'الباحة', 'الرس',
        'عنيزة', 'سكاكا', 'جيزان', 'القطيف', 'الظهران', 'عرعر', 'الحوية', 'الزلفي', 'الدوادمي', 'صبيا'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween('-3 months', 'now');
        
        return [
            'f_name' => fake()->randomElement($this->arabicFirstNames),
            'l_name' => fake()->randomElement($this->arabicLastNames),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->numerify('05#######'), // Saudi phone format
            'location' => fake()->randomElement($this->saudiCities),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123456'),
            'remember_token' => Str::random(10),
            'created_at' => $createdAt,
            'updated_at' => fake()->dateTimeBetween($createdAt, 'now'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
