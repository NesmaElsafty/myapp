<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Screen;
use Database\Seeders\Concerns\SeedsInputScreens;
use Illuminate\Database\Seeder;

class InputPropertyForRentDailyMonthlySeeder extends Seeder
{
    use SeedsInputScreens;

    public function run(): void
    {
        if (!Category::find(6)) {
            return;
        }

        $this->registerInputCreatingHook();

        $screen1 = Screen::where('category_id', 6)->where('name_en', 'Basic Property Information')->first();
        $screen2 = Screen::where('category_id', 6)->where('name_en', 'Property Details')->first();
        $screen3 = Screen::where('category_id', 6)->where('name_en', 'Property Price')->first();

        $this->seedInputsForScreen($screen1, $this->inputsForCategorySixScreen1());
        $this->seedInputsForScreen($screen2, $this->inputsForCategorySixScreen2());
        $this->seedInputsForScreen($screen3, $this->inputsForCategorySixScreen3());
    }

    private function inputsForCategorySixScreen1(): array
    {
        return [
            [
                'title_en' => 'Period', 'title_ar' => 'الفترة',
                'placeholder_en' => 'Select period', 'placeholder_ar' => 'حدد الفترة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'period',
                'validation_rules' => ['nullable', 'in:daily,weekly,monthly'],
                'type' => 'select', 'options' => [
                    'choices' => [
                        ['value' => 'daily', 'label_en' => 'Daily', 'label_ar' => 'يومي'],
                        ['value' => 'weekly', 'label_en' => 'Weekly', 'label_ar' => 'أسبوعي'],
                        ['value' => 'monthly', 'label_en' => 'Monthly', 'label_ar' => 'شهري'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Category / Class', 'title_ar' => 'الصنف',
                'placeholder_en' => 'Select category', 'placeholder_ar' => 'حدد الصنف',
                'description_en' => null, 'description_ar' => null,
                'name' => 'category_class',
                'validation_rules' => ['nullable', 'in:singles,couples,families'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'singles', 'label_en' => 'Singles', 'label_ar' => 'عزاب'],
                        ['value' => 'families', 'label_en' => 'Families', 'label_ar' => 'عوائل'],
                        ['value' => 'singles_and_families', 'label_en' => 'Singles and families', 'label_ar' => 'عزاب وعوائل'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Property Type', 'title_ar' => 'نوع العقار',
                'placeholder_en' => 'Select property type', 'placeholder_ar' => 'حدد نوع العقار',
                'description_en' => 'Show more for more options.', 'description_ar' => 'شاهد المزيد.',
                'name' => 'property_type',
                'validation_rules' => ['nullable', 'in:resort_hotel,chalet,rest_house,camp'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'resort_hotel', 'label_en' => 'Resort hotel', 'label_ar' => 'منتجع فندقي'],
                        ['value' => 'chalet', 'label_en' => 'Chalet', 'label_ar' => 'شاليه'],
                        ['value' => 'rest_house', 'label_en' => 'Rest house', 'label_ar' => 'استراحة'],
                        ['value' => 'camp', 'label_en' => 'Camp', 'label_ar' => 'مخيم'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Area (m²)', 'title_ar' => 'مساحة (م²)',
                'placeholder_en' => 'Enter area (m²)', 'placeholder_ar' => 'ادخل المساحة (م²)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'area',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Nearby Landmarks', 'title_ar' => 'المعالم القريبة',
                'placeholder_en' => 'Landmark name / Distance', 'placeholder_ar' => 'اسم المعلم / المسافة',
                'description_en' => 'Repeater: add rows with landmark name (text) and distance (number). Actions: Add button + Delete per row.', 'description_ar' => 'صفوف قابلة للتكرار: اسم المعلم (ادخل اسم المعلم)، المسافة (ادخل المسافة). زر اضف + حذف لكل صف.',
                'name' => 'nearby_landmarks',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'textarea', 'options' => null, 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for category 6 - Screen 2: Property Details (تفاصيل العقار).
     * Spec: Steppers (غرف النوم، عدد الصالات، عدد دورات المياه، عدد الأسرة)، المميزات، مرافق عامة، مرافق المطبخ، مرافق دورة المياه، صور وفيديو العقار.
     */

    private function inputsForCategorySixScreen2(): array
    {
        return [
            [
                'title_en' => 'Bedrooms', 'title_ar' => 'غرف النوم',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Stepper (+ / -)', 'description_ar' => 'عداد (+ / -)',
                'name' => 'bedrooms',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Halls', 'title_ar' => 'عدد الصالات',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Stepper (+ / -)', 'description_ar' => 'عداد (+ / -)',
                'name' => 'number_of_halls',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Bathrooms', 'title_ar' => 'عدد دورات المياه',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Stepper (+ / -)', 'description_ar' => 'عداد (+ / -)',
                'name' => 'number_of_bathrooms',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Beds', 'title_ar' => 'عدد الأسرة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Stepper (+ / -)', 'description_ar' => 'عداد (+ / -)',
                'name' => 'number_of_beds',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Features', 'title_ar' => 'المميزات',
                'placeholder_en' => 'Select + Checkbox group', 'placeholder_ar' => 'حدد المميزات',
                'description_en' => 'Show more if expandable.', 'description_ar' => 'شاهد المزيد.',
                'name' => 'features',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'select', 'options' => [
                    'choices' => [
                        ['value' => 'master_bed', 'label_en' => 'Master bed', 'label_ar' => 'سرير ماستر'],
                        ['value' => 'self_checkin', 'label_en' => 'Self check-in', 'label_ar' => 'دخول ذاتي'],
                        ['value' => 'luxury', 'label_en' => 'Luxury', 'label_ar' => 'فخم'],
                        ['value' => '3d_view', 'label_en' => '3D view', 'label_ar' => 'عرض بتقنية ثلاثي الأبعاد'],
                        ['value' => '24h_reception', 'label_en' => '24h reception desk', 'label_ar' => 'مكتب استقبال 24 ساعة'],
                        ['value' => 'wheelchair_accessible', 'label_en' => 'Wheelchair accessible', 'label_ar' => 'ملائم لمستخدمي الكراسي المتحركة'],
                        ['value' => 'room_cleaning', 'label_en' => 'Room cleaning service', 'label_ar' => 'خدمة تنظيف الغرف'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Public Facilities', 'title_ar' => 'مرافق عامة',
                'placeholder_en' => 'Select + Checkbox group', 'placeholder_ar' => 'حدد المرافق العامة',
                'description_en' => 'Show more if expandable.', 'description_ar' => 'شاهد المزيد.',
                'name' => 'public_facilities',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'checkbox', 'options' => [
                    'choices' => [
                        ['value' => 'kids_playground', 'label_en' => 'Kids playground', 'label_ar' => 'العاب أطفال'],
                        ['value' => 'bbq_area', 'label_en' => 'BBQ area', 'label_ar' => 'ركن شواء'],
                        ['value' => 'pool', 'label_en' => 'Pool', 'label_ar' => 'مسبح'],
                        ['value' => 'speakers', 'label_en' => 'Speakers', 'label_ar' => 'سماعات'],
                        ['value' => 'tv', 'label_en' => 'TV', 'label_ar' => 'تلفزيون'],
                        ['value' => 'wifi', 'label_en' => 'WiFi', 'label_ar' => 'واي فاي'],
                        ['value' => 'iron', 'label_en' => 'Iron', 'label_ar' => 'مكواة'],
                        ['value' => 'elevator', 'label_en' => 'Elevator', 'label_ar' => 'مصعد'],
                        ['value' => 'private_parking', 'label_en' => 'Private parking', 'label_ar' => 'موقف خاص'],
                        ['value' => 'basement_parking', 'label_en' => 'Basement parking', 'label_ar' => 'موقف في القبو'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Kitchen Facilities', 'title_ar' => 'مرافق المطبخ',
                'placeholder_en' => 'Select + Checkbox group', 'placeholder_ar' => 'حدد مرافق المطبخ',
                'description_en' => 'Show more if expandable.', 'description_ar' => 'شاهد المزيد.',
                'name' => 'kitchen_facilities',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'checkbox', 'options' => [
                    'choices' => [
                        ['value' => 'freezer', 'label_en' => 'Freezer', 'label_ar' => 'فريزر'],
                        ['value' => 'oven', 'label_en' => 'Oven', 'label_ar' => 'فرن'],
                        ['value' => 'fridge', 'label_en' => 'Refrigerator', 'label_ar' => 'ثلاجة'],
                        ['value' => 'microwave', 'label_en' => 'Microwave', 'label_ar' => 'ميكرويف'],
                        ['value' => 'kettle', 'label_en' => 'Kettle', 'label_ar' => 'غلاية'],
                        ['value' => 'dining_table', 'label_en' => 'Dining table', 'label_ar' => 'طاولة طعام'],
                        ['value' => 'cookware', 'label_en' => 'Cookware', 'label_ar' => 'أواني طبخ'],
                        ['value' => 'coffee_tea_set', 'label_en' => 'Coffee and tea set', 'label_ar' => 'أواني قهوة وشاهي'],
                        ['value' => 'washing_machine', 'label_en' => 'Washing machine', 'label_ar' => 'غسالة'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Bathroom Facilities', 'title_ar' => 'مرافق دورة المياه',
                'placeholder_en' => 'Select + Checkbox group', 'placeholder_ar' => 'حدد مرافق دورة المياه',
                'description_en' => 'Show more if expandable.', 'description_ar' => 'شاهد المزيد.',
                'name' => 'bathroom_facilities',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'checkbox', 'options' => [
                    'choices' => [
                        ['value' => 'jacuzzi', 'label_en' => 'Jacuzzi', 'label_ar' => 'جاكوزي'],
                        ['value' => 'sauna', 'label_en' => 'Sauna', 'label_ar' => 'ساونا'],
                        ['value' => 'bidet', 'label_en' => 'Bidet', 'label_ar' => 'بيدو'],
                        ['value' => 'tissues', 'label_en' => 'Tissues', 'label_ar' => 'مناديل'],
                        ['value' => 'soap', 'label_en' => 'Soap', 'label_ar' => 'صابون'],
                        ['value' => 'heater', 'label_en' => 'Heater', 'label_ar' => 'سخان'],
                        ['value' => 'shampoo', 'label_en' => 'Shampoo', 'label_ar' => 'شامبو'],
                        ['value' => 'towels', 'label_en' => 'Towels', 'label_ar' => 'مناشف'],
                        ['value' => 'shower', 'label_en' => 'Shower', 'label_ar' => 'دش'],
                        ['value' => 'bidet_spray', 'label_en' => 'Bidet spray', 'label_ar' => 'شطاف'],
                        ['value' => 'hair_dryer', 'label_en' => 'Hair dryer', 'label_ar' => 'مجفف شعر'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Property Images and Video', 'title_ar' => 'صور و فيديو العقار',
                'name' => 'property_images_video',
                'validation_rules' => ['nullable', 'array'],
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Drag & drop or browse. Minimum 4 images. List of uploaded files + Delete / View actions.', 'description_ar' => 'سحب وإفلات أو تصفح الملفات. حد أدنى 4 صور. قائمة ملفات مرفوعة + حذف / عرض.',
                'type' => 'file', 'options' => null, 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for category 6 - Screen 3: Property Price (سعر العقار).
     * Spec: الأمور المالية (dynamic), يوجد تأمين (خصم), بدون تأمين, إمكانية إلغاء/التبديل, مدة الإلغاء (ساعة), أسعار يومي/أسبوعي/شهري + بعد الخصم, مبلغ التأمين, السعر شامل خدمات المنصة.
     */

    private function inputsForCategorySixScreen3(): array
    {
        return [
            [
                'title_en' => 'Financial Matters', 'title_ar' => 'الأمور المالية',
                'placeholder_en' => 'Select', 'placeholder_ar' => 'حدد الأمور المالية',
                'description_en' => 'Options loaded dynamically from backend/data.', 'description_ar' => 'الخيارات ديناميكية من الباك إند/الداتا.',
                'name' => 'financial_matters',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'select', 'options' => ['choices' => []], 'is_required' => false,
            ],
            [
                'title_en' => 'Has insurance (discount)', 'title_ar' => 'يوجد تأمين (خصم)',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'has_insurance_discount',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Has insurance (discount)', 'label_ar' => 'يوجد تأمين (خصم)'], 'is_required' => false,
            ],
            [
                'title_en' => 'Without insurance', 'title_ar' => 'بدون تأمين',
                'placeholder_en' => 'Yes / No', 'placeholder_ar' => 'نعم / لا',
                'description_en' => null, 'description_ar' => null,
                'name' => 'without_insurance',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'yes', 'label_en' => 'Yes', 'label_ar' => 'نعم'],
                        ['value' => 'no', 'label_en' => 'No', 'label_ar' => 'لا'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Cancellation or switch possible', 'title_ar' => 'إمكانية إلغاء الحجز أو التبديل',
                'placeholder_en' => 'Yes / No', 'placeholder_ar' => 'نعم / لا',
                'description_en' => null, 'description_ar' => null,
                'name' => 'cancellation_or_switch_possible',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'yes', 'label_en' => 'Yes', 'label_ar' => 'نعم'],
                        ['value' => 'no', 'label_en' => 'No', 'label_ar' => 'لا'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Cancellation or switch period', 'title_ar' => 'مدة إلغاء الحجز أو التبديل',
                'placeholder_en' => 'Enter period (hours)', 'placeholder_ar' => 'أدخل المدة (ساعة)',
                'description_en' => 'Unit: hour (ساعة)', 'description_ar' => 'الوحدة: ساعة',
                'name' => 'cancellation_or_switch_period',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price (daily)', 'title_ar' => 'السعر (يومي)',
                'placeholder_en' => 'Enter price (﷼)', 'placeholder_ar' => 'أدخل السعر (﷼)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'price_daily',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price after discount (daily)', 'title_ar' => 'السعر بعد الخصم (يومي)',
                'placeholder_en' => 'Enter price (﷼)', 'placeholder_ar' => 'أدخل السعر (﷼)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'price_after_discount_daily',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price (weekly)', 'title_ar' => 'السعر (أسبوعي)',
                'placeholder_en' => 'Enter price (﷼)', 'placeholder_ar' => 'أدخل السعر (﷼)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'price_weekly',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price after discount (weekly)', 'title_ar' => 'السعر بعد الخصم (أسبوعي)',
                'placeholder_en' => 'Enter price (﷼)', 'placeholder_ar' => 'أدخل السعر (﷼)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'price_after_discount_weekly',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price (monthly)', 'title_ar' => 'السعر (شهري)',
                'placeholder_en' => 'Enter price (﷼)', 'placeholder_ar' => 'أدخل السعر (﷼)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'price_monthly',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price after discount (monthly)', 'title_ar' => 'السعر بعد الخصم (شهري)',
                'placeholder_en' => 'Enter price (﷼)', 'placeholder_ar' => 'أدخل السعر (﷼)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'price_after_discount_monthly',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Insurance amount', 'title_ar' => 'مبلغ التأمين',
                'placeholder_en' => 'Enter amount (﷼)', 'placeholder_ar' => 'أدخل المبلغ (﷼)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'insurance_amount',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price including platform services', 'title_ar' => 'السعر شامل خدمات المنصة',
                'placeholder_en' => 'Enter price (﷼)', 'placeholder_ar' => 'أدخل السعر (﷼)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'price_including_platform_services',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for category 7 - Screen 1: Basic Car Data (البيانات الأساسية للسيارة).
     * Spec: الماركة، الفئة (الموديل)، النوع (الفئة/الترِم)، الحالة، العداد (كم)، سنة الصنع، صور وفيديو السيارة.
     */

}
