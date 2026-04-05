<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Screen;
use Database\Seeders\Concerns\SeedsInputScreens;
use Illuminate\Database\Seeder;

class InputCarsSeeder extends Seeder
{
    use SeedsInputScreens;

    public function run(): void
    {
        if (!Category::find(7)) {
            return;
        }

        $this->registerInputCreatingHook();

        $screen1 = Screen::where('category_id', 7)->where('name_en', 'Basic Car Information')->first();
        $screen2 = Screen::where('category_id', 7)->where('name_en', 'Car Details')->first();

        $this->seedInputsForScreen($screen1, $this->inputsForCategorySevenScreen1());
        $this->seedInputsForScreen($screen2, $this->inputsForCategorySevenScreen2());
    }

    /**
     * Radio choices for `brand`. When {@see CarBrand} rows exist, `value` is the brand id (string)
     * so it matches APIs and {@see CarModel} relations. Otherwise a small legacy slug list is used.
     *
     * @return list<array{value: string, label_en: string, label_ar: string}>
     */
    private function carBrandChoices(): array
    {
        return CarBrand::query()
            ->orderBy('name_en')
            ->get()
            ->map(fn (CarBrand $brand) => [
                'value' => (string) $brand->id,
                'label_en' => $brand->name_en,
                'label_ar' => $brand->name_ar,
            ])
            ->all();
    }

    private function inputsForCategorySevenScreen1(): array
    {
        $yearChoices = array_map(fn ($y) => [
            'value' => (string) $y,
            'label_en' => (string) $y,
            'label_ar' => (string) $y,
        ], range(2026, 2000));

        $brandChoices = $this->carBrandChoices();

        return [
            [
                'title_en' => 'Brand', 'title_ar' => 'الماركة',
                'placeholder_en' => 'Select brand', 'placeholder_ar' => 'حدد الماركة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'car_brand',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'brandChoices_radio', 'options' => [
                    'choices' => $brandChoices,
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Model', 'title_ar' => 'الموديل',
                'placeholder_en' => 'Select model', 'placeholder_ar' => 'حدد الموديل',
                'description_en' => null, 'description_ar' => null,
                'name' => 'car_model',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'modelChoices_radio', 'options' => [
                    'choices' => [],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Type', 'title_ar' => 'النوع',
                'placeholder_en' => 'Select type', 'placeholder_ar' => 'حدد النوع',
                'description_en' => null, 'description_ar' => null,
                'name' => 'type_trim',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'plus', 'label_en' => 'Plus', 'label_ar' => 'بلس'],
                        ['value' => 'standard', 'label_en' => 'Standard', 'label_ar' => 'عادي'],
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
                'title_en' => 'Odometer (km)', 'title_ar' => 'العداد (كم)',
                'placeholder_en' => 'Enter kilometers', 'placeholder_ar' => 'ادخل الكيلومترات',
                'description_en' => null, 'description_ar' => null,
                'name' => 'odometer_km',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Year of manufacture', 'title_ar' => 'سنة الصنع',
                'placeholder_en' => 'Enter year', 'placeholder_ar' => 'ادخل سنة الصنع',
                'description_en' => null, 'description_ar' => null,
                'name' => 'year_of_manufacture',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Car photos and video', 'title_ar' => 'صور وفيديو السيارة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Drag & drop or browse files.', 'description_ar' => 'سحب وإفلات أو تصفح الملفات.',
                'name' => 'car_photos_video',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'file', 'options' => null, 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for category 7 - Screen 2: Car Details (تفاصيل السيارة).
     * Spec: نوع السيارة، المحرك، الطاقة، الاستهلاك، نوع الجير، نظام الدفع، نوع الوقود، عدد السلندرات، اللون الخارجي/الداخلي، عدد الأبواب، إضافات، مدة الضمان.
     */

    private function inputsForCategorySevenScreen2(): array
    {
        $extrasChoices = [
            ['value' => 'abs', 'label_en' => 'Anti-lock braking system', 'label_ar' => 'نظام الفرامل المانعة للانغلاق'],
            ['value' => 'airbags', 'label_en' => 'Airbags', 'label_ar' => 'وسادات هوائية'],
            ['value' => 'radio_am_fm', 'label_en' => 'AM/FM Radio', 'label_ar' => 'راديو AM/FM'],
            ['value' => 'abs_ebd', 'label_en' => 'ABS + EBD', 'label_ar' => 'ABS + EBD'],
            ['value' => 'esp', 'label_en' => 'ESP (Electronic stability)', 'label_ar' => 'ESP (توازن إلكتروني)'],
            ['value' => 'sensors', 'label_en' => 'Front/Rear sensors', 'label_ar' => 'حساسات أمامية/خلفية'],
            ['value' => 'rear_camera', 'label_en' => 'Rear camera', 'label_ar' => 'كاميرا خلفية'],
            ['value' => 'camera_360', 'label_en' => '360 camera', 'label_ar' => 'كاميرا 360'],
            ['value' => 'nav_screen', 'label_en' => 'Navigation screen', 'label_ar' => 'شاشة ملاحة'],
            ['value' => 'bluetooth', 'label_en' => 'Bluetooth', 'label_ar' => 'بلوتوث'],
            ['value' => 'carplay', 'label_en' => 'Apple CarPlay', 'label_ar' => 'Apple CarPlay'],
            ['value' => 'android_auto', 'label_en' => 'Android Auto', 'label_ar' => 'Android Auto'],
            ['value' => 'cruise_control', 'label_en' => 'Cruise control', 'label_ar' => 'مثبت سرعة'],
            ['value' => 'adaptive_cruise', 'label_en' => 'Adaptive cruise control', 'label_ar' => 'مثبت سرعة راداري'],
            ['value' => 'sunroof', 'label_en' => 'Sunroof', 'label_ar' => 'فتحة سقف'],
            ['value' => 'panorama', 'label_en' => 'Panoramic roof', 'label_ar' => 'بانوراما'],
            ['value' => 'leather_seats', 'label_en' => 'Leather seats', 'label_ar' => 'مقاعد جلد'],
            ['value' => 'heated_seats', 'label_en' => 'Heated seats', 'label_ar' => 'تسخين مقاعد'],
            ['value' => 'cooled_seats', 'label_en' => 'Cooled seats', 'label_ar' => 'تبريد مقاعد'],
            ['value' => 'power_seats', 'label_en' => 'Power seats', 'label_ar' => 'مقاعد كهربائية'],
            ['value' => 'push_start', 'label_en' => 'Push start (keyless)', 'label_ar' => 'بصمة تشغيل (زر تشغيل)'],
            ['value' => 'smart_entry', 'label_en' => 'Smart entry', 'label_ar' => 'دخول ذكي'],
            ['value' => 'led', 'label_en' => 'LED lights', 'label_ar' => 'LED'],
            ['value' => 'xenon', 'label_en' => 'Xenon', 'label_ar' => 'زينون'],
            ['value' => 'premium_sound', 'label_en' => 'Premium sound system', 'label_ar' => 'نظام صوتي فاخر'],
            ['value' => 'wireless_charger', 'label_en' => 'Wireless charger', 'label_ar' => 'شاحن لاسلكي'],
            ['value' => 'auto_hold', 'label_en' => 'Auto Hold', 'label_ar' => 'Auto Hold'],
            ['value' => 'parking_assist', 'label_en' => 'Parking Assist', 'label_ar' => 'Parking Assist'],
        ];

        return [
            [
                'title_en' => 'Car type', 'title_ar' => 'نوع السيارة',
                'placeholder_en' => 'Select car type', 'placeholder_ar' => 'حدد نوع السيارة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'car_type',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'sedan', 'label_en' => 'Sedan', 'label_ar' => 'سيدان'],
                        ['value' => 'sport', 'label_en' => 'Sport', 'label_ar' => 'سبورت'],
                        ['value' => 'convertible', 'label_en' => 'Convertible', 'label_ar' => 'كشف'],
                        ['value' => 'luxury', 'label_en' => 'Luxury', 'label_ar' => 'فخمة'],
                        ['value' => 'suv', 'label_en' => 'SUV', 'label_ar' => 'SUV'],
                        ['value' => 'crossover', 'label_en' => 'Crossover', 'label_ar' => 'كروس أوفر'],
                        ['value' => 'hatchback', 'label_en' => 'Hatchback', 'label_ar' => 'هاتشباك'],
                        ['value' => 'pickup', 'label_en' => 'Pick-up', 'label_ar' => 'بيك أب'],
                        ['value' => 'van', 'label_en' => 'Van', 'label_ar' => 'فان'],
                        ['value' => 'coupe', 'label_en' => 'Coupe', 'label_ar' => 'كوبيه'],
                        ['value' => 'wagon', 'label_en' => 'Wagon (Station)', 'label_ar' => 'واجن (ستيشن)'],
                        ['value' => 'four_wheel', 'label_en' => '4x4', 'label_ar' => 'دفع رباعي'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Engine (cc)', 'title_ar' => 'المحرك (سي سي)',
                'placeholder_en' => 'Enter engine (cc)', 'placeholder_ar' => 'ادخل المحرك (سي سي)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'engine_cc',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Power (hp)', 'title_ar' => 'الطاقة (قوة حصان)',
                'placeholder_en' => 'Enter power (hp)', 'placeholder_ar' => 'ادخل الطاقة (قوة حصان)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'power_hp',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Consumption (L/100km)', 'title_ar' => 'الاستهلاك (لتر/100كم)',
                'placeholder_en' => 'Enter consumption', 'placeholder_ar' => 'ادخل الاستهلاك (لتر/100كم)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'consumption_l_100km',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Gear type', 'title_ar' => 'نوع الجير',
                'placeholder_en' => 'Select gear type', 'placeholder_ar' => 'حدد نوع الجير',
                'description_en' => null, 'description_ar' => null,
                'name' => 'gear_type',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'manual', 'label_en' => 'Manual', 'label_ar' => 'عادي'],
                        ['value' => 'automatic', 'label_en' => 'Automatic', 'label_ar' => 'اتوماتيك'],
                        ['value' => 'tiptronic', 'label_en' => 'Tiptronic', 'label_ar' => 'تبترونك'],
                        ['value' => 'm1', 'label_en' => 'F1', 'label_ar' => 'ف1'],
                        ['value' => 'smg', 'label_en' => 'SMG', 'label_ar' => 'اس ام جي'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Drive system', 'title_ar' => 'نظام الدفع',
                'placeholder_en' => 'Select drive system', 'placeholder_ar' => 'حدد نظام الدفع',
                'description_en' => null, 'description_ar' => null,
                'name' => 'drive_system',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'fwd', 'label_en' => 'Front-wheel drive', 'label_ar' => 'دفع امامي'],
                        ['value' => 'rwd', 'label_en' => 'Rear-wheel drive', 'label_ar' => 'دفع خلفي'],
                        ['value' => 'awd', 'label_en' => 'All-wheel drive', 'label_ar' => 'دفع رباعي'],
                        ['value' => 'full_time_4wd', 'label_en' => 'Full-time 4WD', 'label_ar' => 'دفع كل مستمر'],
                        ['value' => 'smart_awd', 'label_en' => 'Smart AWD', 'label_ar' => 'AWD ذكي'],
                        ['value' => '4x4_low_high', 'label_en' => '4x4 Low/High', 'label_ar' => '4x4 Low/High'],
                        ['value' => 'selectable_4wd', 'label_en' => 'Selectable 4WD', 'label_ar' => 'دفع رباعي قابل للفصل'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Fuel type', 'title_ar' => 'نوع الوقود',
                'placeholder_en' => 'Select fuel type', 'placeholder_ar' => 'حدد نوع الوقود',
                'description_en' => null, 'description_ar' => null,
                'name' => 'fuel_type',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'petrol', 'label_en' => 'Petrol', 'label_ar' => 'بنزين'],
                        ['value' => 'diesel', 'label_en' => 'Diesel', 'label_ar' => 'ديزل'],
                        ['value' => 'hybrid', 'label_en' => 'Hybrid', 'label_ar' => 'هايبرد'],
                        ['value' => 'electric', 'label_en' => 'Electric', 'label_ar' => 'كهربائي'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Number of cylinders', 'title_ar' => 'عدد السلندرات',
                'placeholder_en' => 'Enter number of cylinders', 'placeholder_ar' => 'ادخل عدد السلندرات',
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_cylinders',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'counter', 'options' => null, 'is_required' => false,
            ],

            [
                'title_en' => 'Exterior color', 'title_ar' => 'اللون الخارجي',
                'placeholder_en' => 'Select color', 'placeholder_ar' => 'حدد اللون الخارجي',
                'description_en' => null, 'description_ar' => null,
                'name' => 'exterior_color',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'white', 'label_en' => 'White', 'label_ar' => 'أبيض'],
                        ['value' => 'black', 'label_en' => 'Black', 'label_ar' => 'أسود'],
                        ['value' => 'silver', 'label_en' => 'Silver', 'label_ar' => 'فضي'],
                        ['value' => 'grey', 'label_en' => 'Grey', 'label_ar' => 'رمادي'],
                        ['value' => 'blue', 'label_en' => 'Blue', 'label_ar' => 'أزرق'],
                        ['value' => 'red', 'label_en' => 'Red', 'label_ar' => 'أحمر'],
                        ['value' => 'brown', 'label_en' => 'Brown', 'label_ar' => 'بني'],
                        ['value' => 'beige', 'label_en' => 'Beige', 'label_ar' => 'بيج'],
                        ['value' => 'green', 'label_en' => 'Green', 'label_ar' => 'أخضر'],
                        ['value' => 'yellow', 'label_en' => 'Yellow', 'label_ar' => 'أصفر'],
                        ['value' => 'orange', 'label_en' => 'Orange', 'label_ar' => 'برتقالي'],
                        ['value' => 'gold', 'label_en' => 'Gold', 'label_ar' => 'ذهبي'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Interior color', 'title_ar' => 'اللون الداخلي',
                'placeholder_en' => 'Select color', 'placeholder_ar' => 'حدد اللون الداخلي',
                'description_en' => null, 'description_ar' => null,
                'name' => 'interior_color',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'black', 'label_en' => 'Black', 'label_ar' => 'أسود'],
                        ['value' => 'beige', 'label_en' => 'Beige', 'label_ar' => 'بيج'],
                        ['value' => 'grey', 'label_en' => 'Grey', 'label_ar' => 'رمادي'],
                        ['value' => 'brown', 'label_en' => 'Brown', 'label_ar' => 'بني'],
                        ['value' => 'red', 'label_en' => 'Red', 'label_ar' => 'أحمر'],
                        ['value' => 'navy', 'label_en' => 'Navy', 'label_ar' => 'كحلي'],
                        ['value' => 'white', 'label_en' => 'White', 'label_ar' => 'أبيض'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Number of doors', 'title_ar' => 'عدد الأبواب',
                'placeholder_en' => 'Select', 'placeholder_ar' => 'حدد عدد الأبواب',
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_doors',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => '2_3', 'label_en' => '2/3', 'label_ar' => '2/3'],
                        ['value' => '4_5', 'label_en' => '4/5', 'label_ar' => '4/5'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Extras', 'title_ar' => 'إضافات',
                'placeholder_en' => 'Select + Checkbox group', 'placeholder_ar' => 'حدد الإضافات',
                'description_en' => null, 'description_ar' => null,
                'name' => 'extras',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'multi_select', 'options' => ['choices' => $extrasChoices], 'is_required' => false,
            ],
            [
                'title_en' => 'Warranty period', 'title_ar' => 'مدة الضمان',
                'placeholder_en' => 'Enter warranty period', 'placeholder_ar' => 'ادخل مدة الضمان',
                'description_en' => null, 'description_ar' => null,
                'name' => 'warranty_period',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for category 8 - Screen 1: Basic Data for Devices and Equipment (البيانات الأساسية للأجهزة والمعدات).
     * Spec: الجهاز (نوع الجهاز)، الماركة، سعة التخزين، الرام، الحجم بالبوصة، اللون، الحالة، مدة الضمان، صور وفيديو الإلكترونيات.
     */

}
