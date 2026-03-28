<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Screen;
use Database\Seeders\Concerns\SeedsInputScreens;
use Illuminate\Database\Seeder;

class InputDevicesEquipmentSeeder extends Seeder
{
    use SeedsInputScreens;

    public function run(): void
    {
        if (!Category::find(8)) {
            return;
        }

        $this->registerInputCreatingHook();

        $screen1 = Screen::where('category_id', 8)->where('name_en', 'Basic Data for Devices and Equipment')->first();
        $this->seedInputsForScreen($screen1, $this->inputsForCategoryEightScreen1());
    }

    private function inputsForCategoryEightScreen1(): array
    {
        $sizeInchesChoices = array_map(fn ($n) => [
            'value' => (string) $n,
            'label_en' => $n . '"',
            'label_ar' => $n . ' بوصة',
        ], array_merge(range(5, 15), [17, 19, 21, 24, 27, 32, 43, 49, 55, 65]));

        return [
            [
                'title_en' => 'Device', 'title_ar' => 'الجهاز',
                'placeholder_en' => 'Select device type', 'placeholder_ar' => 'حدد نوع الجهاز',
                'description_en' => null, 'description_ar' => null,
                'name' => 'device',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'mobile', 'label_en' => 'Mobile phone', 'label_ar' => 'جوال'],
                        ['value' => 'computer', 'label_en' => 'Computer', 'label_ar' => 'كمبيوتر'],
                        ['value' => 'tv', 'label_en' => 'TV', 'label_ar' => 'تلفزيون'],
                        ['value' => 'screen', 'label_en' => 'Screen / Monitor', 'label_ar' => 'شاشة'],
                        ['value' => 'printer', 'label_en' => 'Printer', 'label_ar' => 'طابعة'],
                        ['value' => 'mobile_accessory', 'label_en' => 'Mobile accessory', 'label_ar' => 'اكسسوار جوال'],
                        ['value' => 'headphones', 'label_en' => 'Headphones', 'label_ar' => 'سماعات'],
                        ['value' => 'hair_dryer', 'label_en' => 'Hair dryer / Styling', 'label_ar' => 'استشوار'],
                        ['value' => 'charger', 'label_en' => 'Charger', 'label_ar' => 'شاحن'],
                        ['value' => 'sports_device', 'label_en' => 'Sports device', 'label_ar' => 'جهاز رياضي'],
                        ['value' => 'oven_cooking', 'label_en' => 'Oven and cooking device', 'label_ar' => 'فرن وجهاز طبخ'],
                        ['value' => 'window_ac', 'label_en' => 'Window AC', 'label_ar' => 'مكيف شباك'],
                        ['value' => 'split_ac', 'label_en' => 'Split AC', 'label_ar' => 'مكيف سبليت'],
                        ['value' => 'heater', 'label_en' => 'Heater', 'label_ar' => 'دفاية'],
                        ['value' => 'iron', 'label_en' => 'Iron', 'label_ar' => 'مكواة'],
                        ['value' => 'washing_machine', 'label_en' => 'Washing machine', 'label_ar' => 'غسالة ملابس'],
                        ['value' => 'dishwasher', 'label_en' => 'Dishwasher', 'label_ar' => 'غسالة صحون'],
                        ['value' => 'refrigerator', 'label_en' => 'Refrigerator', 'label_ar' => 'ثلاجة'],
                        ['value' => 'freezer', 'label_en' => 'Freezer', 'label_ar' => 'فريزر'],
                        ['value' => 'water_dispenser', 'label_en' => 'Water dispenser', 'label_ar' => 'برادة'],
                        ['value' => 'kettle', 'label_en' => 'Kettle device', 'label_ar' => 'جهاز غلاية'],
                        ['value' => 'lighting', 'label_en' => 'Lighting supplies', 'label_ar' => 'مستلزمات انارة'],
                        ['value' => 'bicycle', 'label_en' => 'Bicycle', 'label_ar' => 'دراجة هوائية'],
                        ['value' => 'motorcycle', 'label_en' => 'Motorcycle', 'label_ar' => 'دباب'],
                        ['value' => 'cleaning_device', 'label_en' => 'Home cleaning device', 'label_ar' => 'جهاز تنظيف منزلي'],
                        ['value' => 'cleaning_kit', 'label_en' => 'Home cleaning kit', 'label_ar' => 'عدة تنظيف منزلي'],
                        ['value' => 'car_accessory', 'label_en' => 'Car accessory', 'label_ar' => 'اكسسوار سيارة'],
                        ['value' => 'tools_equipment', 'label_en' => 'Tools and equipment', 'label_ar' => 'عدد والات'],
                        ['value' => 'other', 'label_en' => 'Other', 'label_ar' => 'اخرى'],
                    ],
                ], 'is_required' => false,
            ],
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
                        ['value' => 'dell', 'label_en' => 'Dell', 'label_ar' => 'ديل / Dell'],
                        ['value' => 'hp', 'label_en' => 'HP', 'label_ar' => 'اتش بي / HP'],
                        ['value' => 'lenovo', 'label_en' => 'Lenovo', 'label_ar' => 'لينوفو / Lenovo'],
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
                        ['value' => '32', 'label_en' => '32GB', 'label_ar' => '32GB'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Size (inches)', 'title_ar' => 'الحجم بالبوصة',
                'placeholder_en' => 'Select size', 'placeholder_ar' => 'حدد الحجم بالبوصة',
                'description_en' => 'Numeric values in inches according to device type.', 'description_ar' => 'قيم رقمية بالبوصة حسب نوع الجهاز.',
                'name' => 'size_inches',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'select', 'options' => ['choices' => $sizeInchesChoices], 'is_required' => false,
            ],
            [
                'title_en' => 'Color', 'title_ar' => 'اللون',
                'placeholder_en' => 'Select color', 'placeholder_ar' => 'حدد اللون',
                'description_en' => null, 'description_ar' => null,
                'name' => 'color',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'select', 'options' => [
                    'choices' => [
                        ['value' => 'black', 'label_en' => 'Black', 'label_ar' => 'أسود'],
                        ['value' => 'white', 'label_en' => 'White', 'label_ar' => 'أبيض'],
                        ['value' => 'silver', 'label_en' => 'Silver', 'label_ar' => 'فضي'],
                        ['value' => 'grey', 'label_en' => 'Grey', 'label_ar' => 'رمادي'],
                        ['value' => 'gold', 'label_en' => 'Gold', 'label_ar' => 'ذهبي'],
                        ['value' => 'blue', 'label_en' => 'Blue', 'label_ar' => 'أزرق'],
                        ['value' => 'red', 'label_en' => 'Red', 'label_ar' => 'أحمر'],
                        ['value' => 'green', 'label_en' => 'Green', 'label_ar' => 'أخضر'],
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
                'description_en' => 'Drag & drop or browse. Minimum 4 images required. List of uploaded files + Delete / View actions.', 'description_ar' => 'سحب وإفلات أو تصفح الملفات. يجب إضافة 4 صور على الأقل. قائمة بالملفات المرفوعة + حذف / عرض.',
                'name' => 'electronics_photos_video',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'file', 'options' => null, 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for category 3 - Screen 1: Basic Data for Car Plates.
     */

}
