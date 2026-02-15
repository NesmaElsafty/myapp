<?php

namespace Database\Factories;

use App\Models\Input;
use App\Models\Screen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Options: one value per option (same for en/ar). select/radio => { choices: [{ value, label_en, label_ar }] }; checkbox => { label_en, label_ar }.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Input>
 */
class InputFactory extends Factory
{
    protected $model = Input::class;

    private static array $types = [
        'text', 'textarea', 'select', 'radio', 'checkbox', 'date', 'time',
        'number', 'email', 'phone', 'url', 'file', 'image', 'video', 'audio', 'link',
    ];

    /** Arabic titles for common field types (title_ar) */
    private static array $titlesAr = [
        'الاسم الكامل', 'البريد الإلكتروني', 'رقم الهاتف', 'تاريخ الميلاد', 'الجنس',
        'الرسالة', 'العنوان', 'رقم الهوية', 'الوقت المفضل', 'الموقع الإلكتروني',
        'رفع الملف', 'الوصف', 'الملاحظات', 'الكمية', 'السعر',
    ];

    /** Arabic placeholders */
    private static array $placeholdersAr = [
        'أدخل هنا', 'اختر من القائمة', 'اكتب رسالتك', 'مثال: 05XXXXXXXX',
        'كما في الهوية', 'حد أقصى 500 حرف', 'اختياري',
    ];

    /** Arabic descriptions */
    private static array $descriptionsAr = [
        'كما يظهر في هويتك', 'سنتواصل معك على هذا البريد', 'جوال أو هاتف ثابت',
        'اختر تاريخ ميلادك', 'حد أقصى 5 ميجا', 'اختياري',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $screen = Screen::inRandomOrder()->first();
        if (!$screen) {
            $screen = Screen::first();
        }
        $type = fake()->randomElement(self::$types);

        $options = null;
        if (in_array($type, ['select', 'radio'])) {
            $options = $this->randomChoicesOptions();
        }
        if ($type === 'checkbox') {
            $options = ['label_en' => 'I agree', 'label_ar' => 'أوافق'];
        }

        return [
            'screen_id' => $screen?->id ?? 1,
            'title_en' => fake()->words(3, true),
            'title_ar' => fake()->randomElement(self::$titlesAr),
            'placeholder_en' => fake()->optional(0.7)->sentence(),
            'placeholder_ar' => fake()->optional(0.7)->randomElement(self::$placeholdersAr),
            'description_en' => fake()->optional(0.5)->paragraph(),
            'description_ar' => fake()->optional(0.5)->randomElement(self::$descriptionsAr),
            'type' => $type,
            'options' => $options,
            'is_required' => fake()->boolean(30),
        ];
    }

    /**
     * Options for select/radio: same value for en/ar, label_en and label_ar per choice.
     */
    private function randomChoicesOptions(): array
    {
        $sets = [
            [
                ['value' => 'opt1', 'label_en' => 'Option 1', 'label_ar' => 'الخيار الأول'],
                ['value' => 'opt2', 'label_en' => 'Option 2', 'label_ar' => 'الخيار الثاني'],
            ],
            [
                ['value' => 'yes', 'label_en' => 'Yes', 'label_ar' => 'نعم'],
                ['value' => 'no', 'label_en' => 'No', 'label_ar' => 'لا'],
            ],
            [
                ['value' => 'male', 'label_en' => 'Male', 'label_ar' => 'ذكر'],
                ['value' => 'female', 'label_en' => 'Female', 'label_ar' => 'أنثى'],
            ],
        ];
        return ['choices' => fake()->randomElement($sets)];
    }

    public function forScreen(Screen $screen): static
    {
        return $this->state(fn (array $attributes) => [
            'screen_id' => $screen->id,
        ]);
    }
}
