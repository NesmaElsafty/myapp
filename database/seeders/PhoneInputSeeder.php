<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Screen;
use Database\Seeders\Concerns\SeedsInputScreens;
use Illuminate\Database\Seeder;

class PhoneInputSeeder extends Seeder
{
    use SeedsInputScreens;

    public function run(): void
    {
        if (! Category::find(10)) {
            return;
        }

        $this->registerInputCreatingHook();

        $screen = Screen::where('category_id', 10)
            ->orderBy('position')
            ->first();

        $this->seedInputsForScreen($screen, $this->inputsForPhones());
    }

    private function inputsForPhones(): array
    {
        return [
            [
                'title_en' => 'Brand', 'title_ar' => 'الماركة',
                'placeholder_en' => 'Select brand', 'placeholder_ar' => 'حدد الماركة',
                'description_en' => 'Show more for additional brands.', 'description_ar' => 'شاهد المزيد لماركات إضافية.',
                'name' => 'brand',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'iphone', 'label_en' => 'iPhone', 'label_ar' => 'ايفون / iPhone'],
                        ['value' => 'samsung', 'label_en' => 'Samsung', 'label_ar' => 'سامسونج / Samsung'],
                        ['value' => 'oppo', 'label_en' => 'Oppo', 'label_ar' => 'اوبو / Oppo'],
                        ['value' => 'realme', 'label_en' => 'Realme', 'label_ar' => 'ريلمي / Realme'],
                        ['value' => 'xiaomi', 'label_en' => 'Xiaomi', 'label_ar' => 'شاومي / Xiaomi'],
                        ['value' => 'huawei', 'label_en' => 'Huawei', 'label_ar' => 'هواوي / Huawei'],
                        ['value' => 'other', 'label_en' => 'Other', 'label_ar' => 'أخرى'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Storage capacity', 'title_ar' => 'سعة التخزين',
                'placeholder_en' => 'Select storage', 'placeholder_ar' => 'حدد سعة التخزين',
                'description_en' => 'Show more for more options.', 'description_ar' => 'شاهد المزيد.',
                'name' => 'storage_capacity',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => '64', 'label_en' => '64GB', 'label_ar' => '64GB'],
                        ['value' => '128', 'label_en' => '128GB', 'label_ar' => '128GB'],
                        ['value' => '256', 'label_en' => '256GB', 'label_ar' => '256GB'],
                        ['value' => '512', 'label_en' => '512GB', 'label_ar' => '512GB'],
                        ['value' => '1024', 'label_en' => '1TB', 'label_ar' => '1TB'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'RAM', 'title_ar' => 'الرام',
                'placeholder_en' => 'Select RAM', 'placeholder_ar' => 'حدد الرام',
                'description_en' => 'Show more for more options.', 'description_ar' => 'شاهد المزيد.',
                'name' => 'ram',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => '4', 'label_en' => '4GB', 'label_ar' => '4GB'],
                        ['value' => '6', 'label_en' => '6GB', 'label_ar' => '6GB'],
                        ['value' => '8', 'label_en' => '8GB', 'label_ar' => '8GB'],
                        ['value' => '12', 'label_en' => '12GB', 'label_ar' => '12GB'],
                        ['value' => '16', 'label_en' => '16GB', 'label_ar' => '16GB'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Size (inches)', 'title_ar' => 'الحجم بالبوصة',
                'placeholder_en' => 'Select size', 'placeholder_ar' => 'حدد الحجم بالبوصة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'size_inches',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => '4.7', 'label_en' => '4.7"', 'label_ar' => '4.7 بوصة'],
                        ['value' => '5.4', 'label_en' => '5.4"', 'label_ar' => '5.4 بوصة'],
                        ['value' => '6.1', 'label_en' => '6.1"', 'label_ar' => '6.1 بوصة'],
                        ['value' => '6.5', 'label_en' => '6.5"', 'label_ar' => '6.5 بوصة'],
                        ['value' => '6.7', 'label_en' => '6.7"', 'label_ar' => '6.7 بوصة'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Color', 'title_ar' => 'اللون',
                'placeholder_en' => 'Select color', 'placeholder_ar' => 'حدد اللون',
                'description_en' => null, 'description_ar' => null,
                'name' => 'color',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'black', 'label_en' => 'Black', 'label_ar' => 'أسود'],
                        ['value' => 'white', 'label_en' => 'White', 'label_ar' => 'أبيض'],
                        ['value' => 'silver', 'label_en' => 'Silver', 'label_ar' => 'فضي'],
                        ['value' => 'grey', 'label_en' => 'Grey', 'label_ar' => 'رمادي'],
                        ['value' => 'blue', 'label_en' => 'Blue', 'label_ar' => 'أزرق'],
                        ['value' => 'other', 'label_en' => 'Other', 'label_ar' => 'أخرى'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Condition', 'title_ar' => 'الحالة',
                'placeholder_en' => 'Select condition', 'placeholder_ar' => 'حدد الحالة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'condition',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'new', 'label_en' => 'New', 'label_ar' => 'جديد'],
                        ['value' => 'used', 'label_en' => 'Used', 'label_ar' => 'مستعمل'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Warranty period', 'title_ar' => 'مدة الضمان',
                'placeholder_en' => 'Enter warranty period', 'placeholder_ar' => 'ادخل مدة الضمان',
                'description_en' => null, 'description_ar' => null,
                'name' => 'warranty_period',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Electronics photos and video', 'title_ar' => 'صور وفيديو الإلكترونيات',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Drag & drop or browse. Minimum 4 images required.', 'description_ar' => 'سحب وإفلات أو تصفح الملفات. يجب إضافة 4 صور على الأقل.',
                'name' => 'electronics_photos_video',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'file', 'options' => null, 'is_required' => false,
            ],
        ];
    }
}
