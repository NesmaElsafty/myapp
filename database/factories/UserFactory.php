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
     * Specialty areas (for individual, agent, origin)
     */
    protected array $specialtyAreas = [
        'عقارات', 'سيارات', 'إلكترونيات', 'أثاث', 'عقارات تجارية', 'عقارات سكنية',
        'تأجير سيارات', 'عقارات زراعية', 'استثمار', 'تطوير عقاري'
    ];

    /**
     * Majors / fields of study
     */
    protected array $majors = [
        'هندسة', 'حاسوب', 'إدارة أعمال', 'قانون', 'محاسبة', 'عمارة', 'طب', 'تعليم',
        'تسويق', 'مالية', 'اقتصاد', 'علوم', 'آداب'
    ];

    /**
     * Bank names (for individual, agent, origin)
     */
    protected array $bankNames = [
        'البنك الأهلي', 'بنك الراجحي', 'البنك السعودي الفرنسي', 'بنك الرياض',
        'البنك العربي الوطني', 'بنك البلاد', 'البنك السعودي للاستثمار'
    ];

    /**
     * Saudi IBAN prefix
     */
    protected string $ibanPrefix = 'SA';

    /**
     * Saudi bank account length (without IBAN prefix)
     */
    protected int $ibanSaudiLength = 22;

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
            'specialty_areas' => [],
            'major' => null,
            'summary' => null,
            'bank_name' => null,
            'bank_account_number' => null,
            'bank_account_iban' => null,
            'bank_account_address' => null,
            'language' => 'ar',
            'created_at' => $createdAt,
            'updated_at' => fake()->dateTimeBetween($createdAt, 'now'),
        ];
    }

    /**
     * Configure the model factory: fill specialty_areas, major, summary for individual/agent/origin.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (\App\Models\User $user) {
            if (in_array($user->type, ['individual', 'agent', 'origin'], true)) {
                $user->specialty_areas = fake()->randomElements($this->specialtyAreas, fake()->numberBetween(1, 3));
                $user->major = fake()->randomElement($this->majors);
                $user->summary = fake()->paragraph(3);
                $user->bank_name = fake()->randomElement($this->bankNames);
                $user->bank_account_number = fake()->numerify('##############');
                $user->bank_account_iban = $this->ibanPrefix . fake()->numerify(str_repeat('#', $this->ibanSaudiLength));
                $user->bank_account_address = fake()->streetAddress();
            }
        });
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
