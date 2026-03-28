<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Screen;
use Database\Seeders\Concerns\SeedsInputScreens;
use Illuminate\Database\Seeder;

class InputCarPlatesSeeder extends Seeder
{
    use SeedsInputScreens;

    public function run(): void
    {
        if (!Category::find(3)) {
            return;
        }

        $this->registerInputCreatingHook();

        $screen1 = Screen::where('category_id', 3)->where('name_en', 'Basic Data for Car Plates')->first();
        $this->seedInputsForScreen($screen1, $this->inputsForCategoryThreeScreen1());
    }

    private function inputsForCategoryThreeScreen1(): array
    {
        return [
            [
                'title_en' => 'Car Plate Type', 'title_ar' => 'نوع لوحة السيارة',
                'placeholder_en' => 'Select Car Plate Type', 'placeholder_ar' => 'حدد نوع لوحة السيارة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'car_plate_type',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'private', 'label_en' => 'Private', 'label_ar' => 'خصوصي'],
                        ['value' => 'special_transport', 'label_en' => 'Special Transport', 'label_ar' => 'نقل خاص'],
                        ['value' => 'motorcycles', 'label_en' => 'Motorcycles', 'label_ar' => 'درجات نارية'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Benefits', 'title_ar' => 'المميزات',
                'placeholder_en' => 'Select benefits', 'placeholder_ar' => 'حدد المميزات',
                'description_en' => 'Multi-select.', 'description_ar' => 'اختيار متعدد.',
                'name' => 'benefits',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'select',
                'options' => [
                    'choices' => [
                        ['value' => 'identical_numbers', 'label_en' => 'Identical Numbers', 'label_ar' => 'ارقام متماثلة'],
                        ['value' => 'identical_letters', 'label_en' => 'Identical Letters', 'label_ar' => 'حروف متماثلة'],
                        ['value' => 'identical_letters_and_numbers', 'label_en' => 'Identical Letters and Numbers', 'label_ar' => 'حروف و ارقام متماثلة'],
                        ['value' => 'letters_with_meaning', 'label_en' => 'Letters with Meaning', 'label_ar' => 'حروف لها معنى'],
                        ['value' => 'number_1', 'label_en' => 'Number 1', 'label_ar' => 'رقم 1'],
                        ['value' => 'odd_number', 'label_en' => 'Odd Number', 'label_ar' => 'رقم فردي'],
                        ['value' => 'two_numbers', 'label_en' => 'Two Numbers', 'label_ar' => 'رقمين'],
                        ['value' => 'three_numbers', 'label_en' => 'Three Numbers', 'label_ar' => 'ثلاثة ارقام'],
                        ['value' => 'four_numbers', 'label_en' => 'Four Numbers', 'label_ar' => 'اربعة ارقام'],
                    ],
                ],
                'is_required' => false,
            ],
            [
                'title_en' => 'Status', 'title_ar' => 'الحالة',
                'placeholder_en' => 'Select Status', 'placeholder_ar' => 'حدد الحالة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'status',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'new', 'label_en' => 'New', 'label_ar' => 'جديد'],
                        ['value' => 'used', 'label_en' => 'Used', 'label_ar' => 'مستعمل'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Plate Number (Saudi Arabia format)', 'title_ar' => 'رقم اللوحة - السعودية',
                'placeholder_en' => 'e.g. ABC 123', 'placeholder_ar' => 'مثال: أ ب ج ١٢٣',
                'description_en' => 'Enter plate number in Saudi Arabia format (3 letters + 3 numbers).', 'description_ar' => 'أدخل رقم اللوحة بصيغة السعودية.',
                'name' => 'plate_number_saudi_arabia',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Plate Number (KSA format)', 'title_ar' => 'رقم اللوحة - KSA',
                'placeholder_en' => 'e.g. ABC 123', 'placeholder_ar' => 'مثال: أ ب ج ١٢٣',
                'description_en' => 'Enter plate number in KSA format.', 'description_ar' => 'أدخل رقم اللوحة بصيغة KSA.',
                'name' => 'plate_number_ksa',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for category 4 - Screen 1: Basic Data for Furniture and Accessories.
     */

}
