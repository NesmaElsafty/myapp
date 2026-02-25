<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Input;
use App\Models\Screen;
use Illuminate\Database\Seeder;

class InputSeeder extends Seeder
{
    /**
     * Fixed inputs for Screen 1: Basic Property Information (category id 1).
     */
    private function inputsForBasicPropertyInfo(): array
    {
        return [
            [
                'title_en' => 'Purpose', 'title_ar' => 'الغرض',
                'placeholder_en' => 'Select Purpose', 'placeholder_ar' => 'حدد الغرض',
                'description_en' => null, 'description_ar' => null,
                'name' => 'purpose',
                'validation_rules' => ['nullable', 'in:residential,commercial'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'residential', 'label_en' => 'Residential', 'label_ar' => 'سكني'],
                        ['value' => 'commercial', 'label_en' => 'Commercial', 'label_ar' => 'تجاري'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Property Type', 'title_ar' => 'نوع العقار',
                'placeholder_en' => 'Select Property Type', 'placeholder_ar' => 'حدد نوع العقار',
                'description_en' => null, 'description_ar' => null,
                'name' => 'property_type',
                'validation_rules' => ['nullable', 'in:apartment,villa,residential_land,commercial_land,agricultural_land,premium_apartment,luxury_apartment,duplex_apartment,premium_villa,luxury_villa,townhouse,studio,floor,duplex,residential_building,commercial_building,palace,room,rest_house,premium_rest_house,traditional_house,office,warehouse,farm,chalet,workshop,shop,showroom,exhibition_hall,corner_block,factory,hotel,private_school,private_health_center,gas_station,other'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'apartment', 'label_en' => 'Apartment', 'label_ar' => 'شقة'],
                        ['value' => 'villa', 'label_en' => 'Villa', 'label_ar' => 'فيلا'],
                        ['value' => 'residential_land', 'label_en' => 'Residential land', 'label_ar' => 'أرض سكنية'],
                        ['value' => 'commercial_land', 'label_en' => 'Commercial land', 'label_ar' => 'أرض تجارية'],
                        ['value' => 'agricultural_land', 'label_en' => 'Agricultural land', 'label_ar' => 'أرض زراعية'],
                        ['value' => 'premium_apartment', 'label_en' => 'Premium apartment', 'label_ar' => 'شقة مميزة'],
                        ['value' => 'luxury_apartment', 'label_en' => 'Luxury apartment', 'label_ar' => 'شقة فخمة'],
                        ['value' => 'duplex_apartment', 'label_en' => 'Duplex apartment', 'label_ar' => 'شقة دورين'],
                        ['value' => 'premium_villa', 'label_en' => 'Premium villa', 'label_ar' => 'فيلا مميزة'],
                        ['value' => 'luxury_villa', 'label_en' => 'Luxury villa', 'label_ar' => 'فيلا فخمة'],
                        ['value' => 'townhouse', 'label_en' => 'Townhouse', 'label_ar' => 'تاون هاوس'],
                        ['value' => 'studio', 'label_en' => 'Studio', 'label_ar' => 'استديو'],
                        ['value' => 'floor', 'label_en' => 'Floor', 'label_ar' => 'دور'],
                        ['value' => 'duplex', 'label_en' => 'Duplex', 'label_ar' => 'دبلكس'],
                        ['value' => 'residential_building', 'label_en' => 'Residential building', 'label_ar' => 'عمارة سكنية'],
                        ['value' => 'commercial_building', 'label_en' => 'Commercial building', 'label_ar' => 'عمارة تجارية'],
                        ['value' => 'palace', 'label_en' => 'Palace', 'label_ar' => 'قصر'],
                        ['value' => 'room', 'label_en' => 'Room', 'label_ar' => 'غرفة'],
                        ['value' => 'rest_house', 'label_en' => 'Rest house', 'label_ar' => 'استراحة'],
                        ['value' => 'premium_rest_house', 'label_en' => 'Premium rest house', 'label_ar' => 'استراحة مميزة'],
                        ['value' => 'traditional_house', 'label_en' => 'Traditional house', 'label_ar' => 'بيت شعبي'],
                        ['value' => 'office', 'label_en' => 'Office', 'label_ar' => 'مكتب'],
                        ['value' => 'warehouse', 'label_en' => 'Warehouse', 'label_ar' => 'مستودع'],
                        ['value' => 'farm', 'label_en' => 'Farm', 'label_ar' => 'مزرعة'],
                        ['value' => 'chalet', 'label_en' => 'Chalet', 'label_ar' => 'شاليه'],
                        ['value' => 'workshop', 'label_en' => 'Workshop', 'label_ar' => 'ورشة'],
                        ['value' => 'shop', 'label_en' => 'Shop', 'label_ar' => 'محل'],
                        ['value' => 'showroom', 'label_en' => 'Showroom', 'label_ar' => 'معرض'],
                        ['value' => 'exhibition_hall', 'label_en' => 'Exhibition hall', 'label_ar' => 'صالة عرض'],
                        ['value' => 'corner_block', 'label_en' => 'Corner block', 'label_ar' => 'رأس بلك'],
                        ['value' => 'factory', 'label_en' => 'Factory', 'label_ar' => 'مصنع'],
                        ['value' => 'hotel', 'label_en' => 'Hotel', 'label_ar' => 'فندق'],
                        ['value' => 'private_school', 'label_en' => 'Private school', 'label_ar' => 'مدرسة أهلية'],
                        ['value' => 'private_health_center', 'label_en' => 'Private health center', 'label_ar' => 'مركز صحي أهلى'],
                        ['value' => 'gas_station', 'label_en' => 'Gas station', 'label_ar' => 'محطة بنزين'],
                        ['value' => 'other', 'label_en' => 'Other', 'label_ar' => 'أخرى'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Property Status', 'title_ar' => 'حالة العقار',
                'placeholder_en' => 'Select Property Status', 'placeholder_ar' => 'حدد حالة العقار',
                'description_en' => null, 'description_ar' => null,
                'name' => 'property_status',
                'validation_rules' => ['nullable', 'in:ready,under_construction'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'ready', 'label_en' => 'Ready', 'label_ar' => 'جاهز'],
                        ['value' => 'under_construction', 'label_en' => 'Under Construction', 'label_ar' => 'قيد الإنشاء'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Furnishing', 'title_ar' => 'التأثيت',
                'placeholder_en' => 'Select Furnishing', 'placeholder_ar' => 'حدد التأثيث',
                'description_en' => null, 'description_ar' => null,
                'name' => 'furnishing',
                'validation_rules' => ['required', 'in:furnished,unfurnished'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'furnished', 'label_en' => 'Furnished', 'label_ar' => 'مؤثث'],
                        ['value' => 'unfurnished', 'label_en' => 'Unfurnished', 'label_ar' => 'غير مؤثث'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Property Condition', 'title_ar' => 'وضع العقار',
                'placeholder_en' => 'Select Property Condition', 'placeholder_ar' => 'حدد وضع العقار',
                'description_en' => null, 'description_ar' => null,
                'name' => 'property_condition',
                'validation_rules' => ['required', 'in:new,used,renovated'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'new', 'label_en' => 'New', 'label_ar' => 'جديد'],
                        ['value' => 'used', 'label_en' => 'Used', 'label_ar' => 'مستعمل'],
                        ['value' => 'renewed', 'label_en' => 'Renewed', 'label_ar' => 'مجدد'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Construction Date', 'title_ar' => 'تاريخ البناء',
                'placeholder_en' => 'Enter Construction Date', 'placeholder_ar' => 'أدخل تاريخ البناء',
                'description_en' => null, 'description_ar' => null,
                'name' => 'construction_date',
                'validation_rules' => ['nullable', 'date'],
                'type' => 'date', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Area (m²)', 'title_ar' => 'مساحة (م²)',
                'placeholder_en' => 'Enter Area (m²)', 'placeholder_ar' => 'أدخل المساحة (م²)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'area',
                'validation_rules' => ['required', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Facade', 'title_ar' => 'الواجهة',
                'placeholder_en' => 'Select Facade', 'placeholder_ar' => 'حدد الواجهة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'facade',
                'validation_rules' => ['nullable', 'in:east,south,north,west,two_streets'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'east', 'label_en' => 'East', 'label_ar' => 'شرقية'],
                        ['value' => 'south', 'label_en' => 'South', 'label_ar' => 'جنوبية'],
                        ['value' => 'north', 'label_en' => 'North', 'label_ar' => 'شمالية'],
                        ['value' => 'west', 'label_en' => 'West', 'label_ar' => 'غربية'],
                        ['value' => 'two_streets', 'label_en' => 'On two streets', 'label_ar' => 'على شارعين'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Street Width (m)', 'title_ar' => 'عرض الشارع (م)',
                'placeholder_en' => 'Enter Street Width (m)', 'placeholder_ar' => 'أدخل عرض الشارع (م)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'street_width',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Nearby Landmarks', 'title_ar' => 'المعالم القريبة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Add multiple entries as needed.', 'description_ar' => 'أضف أكثر من معلم حسب الحاجة.',
                'name' => 'nearby_landmarks',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'repeatable',
                'options' => [
                    'fields' => [
                        [
                            'key' => 'name',
                            'label_en' => 'Landmark name',
                            'label_ar' => 'اسم المعلم',
                            'placeholder_en' => 'Enter landmark name',
                            'placeholder_ar' => 'ادخل اسم المعلم',
                            'type' => 'text',
                            'name' => 'name',
                            'validation_rules' => ['nullable', 'string'],
                        ],
                        [
                            'key' => 'distance',
                            'label_en' => 'Distance',
                            'label_ar' => 'المسافة',
                            'placeholder_en' => 'Enter distance',
                            'placeholder_ar' => 'ادخل المسافة',
                            'type' => 'text',
                            'name' => 'distance',
                            'validation_rules' => ['nullable', 'numeric'],
                        ],
                    ],
                    'add_label_en' => 'Add',
                    'add_label_ar' => 'اضف',
                ],
                'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for Screen 2: Property Details (category id 1).
     */
    private function inputsForPropertyDetails(): array
    {
        return [
            [
                'title_en' => 'Bedrooms', 'title_ar' => 'غرف النوم',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'bedrooms',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Halls', 'title_ar' => 'عدد الصالات',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_halls',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Bathrooms', 'title_ar' => 'عدد دورات المياه',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_bathrooms',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Apartment Arrangement', 'title_ar' => 'ترتيب الشقة',
                'placeholder_en' => 'Select Apartment Arrangement', 'placeholder_ar' => 'حدد ترتيب الشقة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'apartment_arrangement',
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'ground_floor', 'label_en' => 'Ground Floor', 'label_ar' => 'دور أرضي'],
                        ['value' => '1', 'label_en' => '1', 'label_ar' => '1'],
                        ['value' => '2', 'label_en' => '2', 'label_ar' => '2'],
                        ['value' => '3', 'label_en' => '3', 'label_ar' => '3'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Water', 'title_ar' => 'ماء',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'water',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Water', 'label_ar' => 'ماء'], 'is_required' => false,
            ],
            [
                'title_en' => 'Electricity', 'title_ar' => 'كهرباء',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'electricity',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Electricity', 'label_ar' => 'كهرباء'], 'is_required' => false,
            ],
            [
                'title_en' => 'Sewage', 'title_ar' => 'صرف صحي',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'sewage',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Sewage', 'label_ar' => 'صرف صحي'], 'is_required' => false,
            ],
            [
                'title_en' => 'Fiber optics', 'title_ar' => 'الياف بصرية',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'fiber_optics',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Fiber optics', 'label_ar' => 'الياف بصرية'], 'is_required' => false,
            ],
            [
                'title_en' => 'Near a mosque', 'title_ar' => 'قرب مسجد',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'near_a_mosque',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Near a mosque', 'label_ar' => 'قرب مسجد'], 'is_required' => false,
            ],
            [
                'title_en' => "Maid's room", 'title_ar' => 'غرفة خادمة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'maid_s_room',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => "Maid's room", 'label_ar' => 'غرفة خادمة'], 'is_required' => false,
            ],
            [
                'title_en' => "Driver's room", 'title_ar' => 'غرفة سائق',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'driver_s_room',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => "Driver's room", 'label_ar' => 'غرفة سائق'], 'is_required' => false,
            ],
            [
                'title_en' => 'Near a garden', 'title_ar' => 'قرب حديقة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'near_a_garden',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Near a garden', 'label_ar' => 'قرب حديقة'], 'is_required' => false,
            ],
            [
                'title_en' => 'Near a train station', 'title_ar' => 'قرب محطة قطار',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'near_a_train_station',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Near a train station', 'label_ar' => 'قرب محطة قطار'], 'is_required' => false,
            ],
            [
                'title_en' => 'Independent electricity meter', 'title_ar' => 'عداد كهرباء مستقل',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'independent_electricity_meter',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Independent electricity meter', 'label_ar' => 'عداد كهرباء مستقل'], 'is_required' => false,
            ],
            [
                'title_en' => 'Independent water meter', 'title_ar' => 'عداد ماء مستقل',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'independent_water_meter',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Independent water meter', 'label_ar' => 'عداد ماء مستقل'], 'is_required' => false,
            ],
            [
                'title_en' => 'Balcony', 'title_ar' => 'شرفه',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'balcony',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Balcony', 'label_ar' => 'شرفه'], 'is_required' => false,
            ],
            [
                'title_en' => 'Surveillance camera system', 'title_ar' => 'نظام كاميرات مراقبة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'surveillance_camera_system',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Surveillance camera system', 'label_ar' => 'نظام كاميرات مراقبة'], 'is_required' => false,
            ],
            [
                'title_en' => 'Private entrance', 'title_ar' => 'مدخل خاص',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'private_entrance',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Private entrance', 'label_ar' => 'مدخل خاص'], 'is_required' => false,
            ],
            [
                'title_en' => 'Private garden', 'title_ar' => 'حديقة خاصة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'private_garden',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Private garden', 'label_ar' => 'حديقة خاصة'], 'is_required' => false,
            ],
            [
                'title_en' => 'Central water heater', 'title_ar' => 'سخان مركزي',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'central_water_heater',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Central water heater', 'label_ar' => 'سخان مركزي'], 'is_required' => false,
            ],
            [
                'title_en' => 'Private rooftop', 'title_ar' => 'سطح خاص',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'private_rooftop',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Private rooftop', 'label_ar' => 'سطح خاص'], 'is_required' => false,
            ],
            [
                'title_en' => 'Upper annex', 'title_ar' => 'ملحق علوي',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'upper_annex',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Upper annex', 'label_ar' => 'ملحق علوي'], 'is_required' => false,
            ],
            [
                'title_en' => 'Ground floor annex', 'title_ar' => 'ملحق أرضي',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'ground_floor_annex',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Ground floor annex', 'label_ar' => 'ملحق أرضي'], 'is_required' => false,
            ],
            [
                'title_en' => 'Tent / poetic house', 'title_ar' => 'بيت شعر',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'tent_poetic_house',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Tent / poetic house', 'label_ar' => 'بيت شعر'], 'is_required' => false,
            ],
            [
                'title_en' => 'Laundry room', 'title_ar' => 'غرفة غسيل',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'laundry_room',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Laundry room', 'label_ar' => 'غرفة غسيل'], 'is_required' => false,
            ],
            [
                'title_en' => 'Hallway stairs', 'title_ar' => 'درج صالة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'hallway_stairs',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Hallway stairs', 'label_ar' => 'درج صالة'], 'is_required' => false,
            ],
            [
                'title_en' => 'Side stairs', 'title_ar' => 'درج جانبي',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'side_stairs',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Side stairs', 'label_ar' => 'درج جانبي'], 'is_required' => false,
            ],
            [
                'title_en' => 'Emergency backup electrical system', 'title_ar' => 'نظام كهربائي احتياطي للطوارئ',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'emergency_backup_electrical_system',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Emergency backup electrical system', 'label_ar' => 'نظام كهربائي احتياطي للطوارئ'], 'is_required' => false,
            ],
            [
                'title_en' => 'Central heating and air conditioning', 'title_ar' => 'تدفئة وتكييف مركزي',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'central_heating_and_air_conditioning',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Central heating and air conditioning', 'label_ar' => 'تدفئة وتكييف مركزي'], 'is_required' => false,
            ],
            [
                'title_en' => 'AC Type', 'title_ar' => 'نوع التكييف',
                'placeholder_en' => 'Select AC Type', 'placeholder_ar' => 'حدد نوع التكييف',
                'description_en' => null, 'description_ar' => null,
                'name' => 'ac_type',
                'validation_rules' => ['nullable', 'in:central,split,window'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'central', 'label_en' => 'Central', 'label_ar' => 'مركزي'],
                        ['value' => 'split', 'label_en' => 'Split', 'label_ar' => 'اسبليت'],
                        ['value' => 'window', 'label_en' => 'Window', 'label_ar' => 'شباك'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Warranty Period', 'title_ar' => 'مدة الضمان',
                'placeholder_en' => 'Enter Warranty Period', 'placeholder_ar' => 'أدخل مدة الضمان',
                'description_en' => null, 'description_ar' => null,
                'name' => 'warranty_period',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Property Photos & Video', 'title_ar' => 'صور و فيديو العقار',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'At least 4 photos recommended for a clearer listing.', 'description_ar' => 'يجب إضافة ٤ صور على الأقل لكي يظهر اعلانك بشكل أوضح',
                'name' => 'property_photos_video',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'image', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Miniature Plan / Blueprint', 'title_ar' => 'مخطط مصغر',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Upload blueprint or floor plan.', 'description_ar' => 'ارفع المخطط أو المسقط الأفقي.',
                'name' => 'miniature_plan_blueprint',
                'validation_rules' => ['nullable', 'file'],
                'type' => 'file', 'options' => null, 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for Screen 1: Basic Project Information (category id 2).
     * Spec: الغرض، نوع المشروع، حالة المشروع، التأثيث، وضع المشروع، تاريخ البناء، عدد الوحدات، عدد العمارات، المساحة (من/إلى)، السعر (من/إلى)، الواجهة، عرض الشارع، المميزات (25)، تاريخ التسليم، صور وفيديو، كتيب المشروع، شعار الشركة، المعالم القريبة.
     */
    private function inputsForBasicProjectInfo(): array
    {
        $featuresChoices = [
            ['value' => 'water', 'label_en' => 'Water', 'label_ar' => 'ماء'],
            ['value' => 'electricity', 'label_en' => 'Electricity', 'label_ar' => 'كهرباء'],
            ['value' => 'sewage', 'label_en' => 'Sewage', 'label_ar' => 'صرف صحي'],
            ['value' => 'fiber_optics', 'label_en' => 'Fiber optics', 'label_ar' => 'ألياف بصرية'],
            ['value' => 'near_mosque', 'label_en' => 'Near mosque', 'label_ar' => 'قرب مسجد'],
            ['value' => 'maids_room', 'label_en' => "Maid's room", 'label_ar' => 'غرفة خادمة'],
            ['value' => 'drivers_rooms', 'label_en' => "Driver's rooms", 'label_ar' => 'غرف سائق'],
            ['value' => 'near_garden', 'label_en' => 'Near garden', 'label_ar' => 'قرب حديقة'],
            ['value' => 'near_train_station', 'label_en' => 'Near train station', 'label_ar' => 'قرب محطة قطار'],
            ['value' => 'independent_electricity_meter', 'label_en' => 'Independent electricity meter', 'label_ar' => 'عداد كهرباء مستقل'],
            ['value' => 'independent_water_meter', 'label_en' => 'Independent water meter', 'label_ar' => 'عداد ماء مستقل'],
            ['value' => 'balcony', 'label_en' => 'Balcony', 'label_ar' => 'شرفة'],
            ['value' => 'surveillance_cameras', 'label_en' => 'Surveillance camera system', 'label_ar' => 'نظام كاميرات مراقبة'],
            ['value' => 'security_guard', 'label_en' => 'Security guard', 'label_ar' => 'حراسة أمن'],
            ['value' => 'private_entrance', 'label_en' => 'Private entrance', 'label_ar' => 'مدخل خاص'],
            ['value' => 'private_garden', 'label_en' => 'Private garden', 'label_ar' => 'حديقة خاصة'],
            ['value' => 'central_heater', 'label_en' => 'Central water heater', 'label_ar' => 'سخان مركزي'],
            ['value' => 'private_rooftop', 'label_en' => 'Private rooftop', 'label_ar' => 'سطح خاص'],
            ['value' => 'laundry_room', 'label_en' => 'Laundry room', 'label_ar' => 'غرفة غسيل'],
            ['value' => 'upper_annex', 'label_en' => 'Upper annex', 'label_ar' => 'ملحق علوي'],
            ['value' => 'stairs_in_hall', 'label_en' => 'Stairs in the hall', 'label_ar' => 'درج بالصالة'],
            ['value' => 'side_stairs', 'label_en' => 'Side stairs', 'label_ar' => 'درج جانبي'],
            ['value' => 'ground_floor_annex', 'label_en' => 'Ground floor annex', 'label_ar' => 'ملحق أرضي'],
            ['value' => 'emergency_backup_power', 'label_en' => 'Emergency backup power system', 'label_ar' => 'نظام كهرباء احتياطي للطوارئ'],
            ['value' => 'central_heating_ac', 'label_en' => 'Central heating and air conditioning', 'label_ar' => 'تدفئة وتكييف مركزي'],
        ];

        $buildingCountChoices = array_map(fn ($n) => [
            'value' => (string) $n,
            'label_en' => (string) $n,
            'label_ar' => (string) $n,
        ], range(1, 20));

        return [
            [
                'title_en' => 'Purpose', 'title_ar' => 'الغرض',
                'placeholder_en' => 'Select purpose', 'placeholder_ar' => 'حدد الغرض',
                'description_en' => null, 'description_ar' => null,
                'name' => 'purpose',
                'validation_rules' => ['nullable', 'in:residential,commercial'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'residential', 'label_en' => 'Residential', 'label_ar' => 'سكني'],
                        ['value' => 'commercial', 'label_en' => 'Commercial', 'label_ar' => 'تجاري'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Project Type', 'title_ar' => 'نوع المشروع',
                'placeholder_en' => 'Select project type', 'placeholder_ar' => 'حدد نوع المشروع',
                'description_en' => null, 'description_ar' => null,
                'name' => 'project_type',
                'validation_rules' => ['nullable', 'in:apartment,villa,buildings,land'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'apartment', 'label_en' => 'Apartment', 'label_ar' => 'شقة'],
                        ['value' => 'villa', 'label_en' => 'Villa', 'label_ar' => 'فيلا'],
                        ['value' => 'buildings', 'label_en' => 'Buildings', 'label_ar' => 'عمارات'],
                        ['value' => 'land', 'label_en' => 'Land', 'label_ar' => 'أرض'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Project Status', 'title_ar' => 'حالة المشروع',
                'placeholder_en' => 'Select project status', 'placeholder_ar' => 'حدد حالة المشروع',
                'description_en' => null, 'description_ar' => null,
                'name' => 'project_status',
                'validation_rules' => ['nullable', 'in:on_map,ready,under_construction'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'on_map', 'label_en' => 'On Map', 'label_ar' => 'على الخريطة'],
                        ['value' => 'ready', 'label_en' => 'Ready', 'label_ar' => 'جاهز'],
                        ['value' => 'under_construction', 'label_en' => 'Under Construction', 'label_ar' => 'قيد الإنشاء'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Furnishing', 'title_ar' => 'التأثيث',
                'placeholder_en' => 'Select furnishing', 'placeholder_ar' => 'حدد التأثيث',
                'description_en' => null, 'description_ar' => null,
                'name' => 'furnishing',
                'validation_rules' => ['nullable', 'in:furnished,unfurnished'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'furnished', 'label_en' => 'Furnished', 'label_ar' => 'مؤثث'],
                        ['value' => 'unfurnished', 'label_en' => 'Unfurnished', 'label_ar' => 'غير مؤثث'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Project Condition', 'title_ar' => 'وضع المشروع',
                'placeholder_en' => 'Select condition', 'placeholder_ar' => 'حدد وضع المشروع',
                'description_en' => null, 'description_ar' => null,
                'name' => 'project_condition',
                'validation_rules' => ['nullable', 'in:new,used,renewed'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'new', 'label_en' => 'New', 'label_ar' => 'جديد'],
                        ['value' => 'used', 'label_en' => 'Used', 'label_ar' => 'مستعمل'],
                        ['value' => 'renewed', 'label_en' => 'Renewed', 'label_ar' => 'مجدد'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Construction Date', 'title_ar' => 'تاريخ البناء',
                'placeholder_en' => 'Day / Month / Year', 'placeholder_ar' => 'يوم / شهر / سنة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'construction_date',
                'validation_rules' => ['nullable', 'date'],
                'type' => 'date', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Units', 'title_ar' => 'عدد الوحدات',
                'placeholder_en' => 'Enter number of units', 'placeholder_ar' => 'أدخل عدد الوحدات',
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_units',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Buildings', 'title_ar' => 'عدد العمارات',
                'placeholder_en' => 'Select number of buildings', 'placeholder_ar' => 'حدد عدد العمارات',
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_buildings',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'select', 'options' => ['choices' => $buildingCountChoices], 'is_required' => false,
            ],
            [
                'title_en' => 'Area from (m²)', 'title_ar' => 'المساحة من (م²)',
                'placeholder_en' => 'From', 'placeholder_ar' => 'من',
                'description_en' => 'Area range (from)', 'description_ar' => 'المساحة (من)',
                'name' => 'area_from',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Area to (m²)', 'title_ar' => 'المساحة إلى (م²)',
                'placeholder_en' => 'To', 'placeholder_ar' => 'إلى',
                'description_en' => 'Area range (to)', 'description_ar' => 'المساحة (إلى)',
                'name' => 'area_to',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price from', 'title_ar' => 'السعر من',
                'placeholder_en' => 'From (SAR)', 'placeholder_ar' => 'من (ريال)',
                'description_en' => 'Price range (from)', 'description_ar' => 'السعر (من)',
                'name' => 'price_from',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price to', 'title_ar' => 'السعر إلى',
                'placeholder_en' => 'To (SAR)', 'placeholder_ar' => 'إلى (ريال)',
                'description_en' => 'Price range (to)', 'description_ar' => 'السعر (إلى)',
                'name' => 'price_to',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Facade', 'title_ar' => 'الواجهة',
                'placeholder_en' => 'Select facade', 'placeholder_ar' => 'حدد الواجهة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'facade',
                'validation_rules' => ['nullable', 'in:north,south,east,west,unknown'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'north', 'label_en' => 'North', 'label_ar' => 'شمالية'],
                        ['value' => 'south', 'label_en' => 'South', 'label_ar' => 'جنوبية'],
                        ['value' => 'east', 'label_en' => 'East', 'label_ar' => 'شرقية'],
                        ['value' => 'west', 'label_en' => 'West', 'label_ar' => 'غربية'],
                        ['value' => 'unknown', 'label_en' => 'Unknown', 'label_ar' => 'غير معروفة'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Street Width (m)', 'title_ar' => 'عرض الشارع (م)',
                'placeholder_en' => 'Enter street width', 'placeholder_ar' => 'أدخل عرض الشارع',
                'description_en' => null, 'description_ar' => null,
                'name' => 'street_width',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Features', 'title_ar' => 'المميزات',
                'placeholder_en' => 'The features are:', 'placeholder_ar' => 'المميزات هي:',
                'description_en' => 'Multi-select. Show more if expandable.', 'description_ar' => 'اختيار متعدد. شاهد المزيد إن وجد.',
                'name' => 'features',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'select', 'options' => ['choices' => $featuresChoices], 'is_required' => false,
            ],
            [
                'title_en' => 'Expected Delivery Date', 'title_ar' => 'تاريخ التسليم المتوقع',
                'placeholder_en' => 'Day / Month / Year', 'placeholder_ar' => 'يوم / شهر / سنة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'expected_delivery_date',
                'validation_rules' => ['nullable', 'date'],
                'type' => 'date', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Project Images and Video', 'title_ar' => 'صور وفيديو المشروع',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Drag & drop or browse. List of uploaded files with delete/view actions.', 'description_ar' => 'سحب وإفلات أو تصفح الملفات. قائمة الملفات المرفوعة مع حذف/عرض.',
                'name' => 'project_images_video',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'file', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Project Brochure', 'title_ar' => 'كتيب المشروع',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Upload file (e.g. PDF).', 'description_ar' => 'تحميل الملف (مثل PDF).',
                'name' => 'project_brochure',
                'validation_rules' => ['nullable', 'file'],
                'type' => 'file', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Company Logo', 'title_ar' => 'شعار الشركة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Upload image.', 'description_ar' => 'تحميل صورة الشعار.',
                'name' => 'company_logo',
                'validation_rules' => ['nullable', 'file'],
                'type' => 'file', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Nearby Landmarks', 'title_ar' => 'المعالم القريبة',
                'placeholder_en' => 'Landmark name, Distance (m)', 'placeholder_ar' => 'اسم المعلم، المسافة (م)',
                'description_en' => 'Repeater: add rows with landmark name and distance. One entry per line: "name, distance".', 'description_ar' => 'أضف سطوراً: اسم المعلم والمسافة. سطر لكل معلم.',
                'name' => 'nearby_landmarks',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'textarea', 'options' => null, 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for Screen 2: Property Details - Project (category id 2).
     * Spec: اسم العقار، وصف العقار، السعر، السعر بعد الخصم، مساحة (م²)، غرف النوم، عدد الحمامات، عدد دورات المياه، ترتيب الشقة، الصفات والميزات (5)، نوع التكييف، صور وفيديو العقار، الحالة.
     */
    private function inputsForPropertyDetailsProject(): array
    {
        return [
            [
                'title_en' => 'Property Name', 'title_ar' => 'اسم العقار',
                'placeholder_en' => 'Enter property name', 'placeholder_ar' => 'أدخل اسم العقار',
                'description_en' => null, 'description_ar' => null,
                'name' => 'property_name',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Property Description', 'title_ar' => 'وصف العقار',
                'placeholder_en' => 'Enter description', 'placeholder_ar' => 'أدخل وصف العقار',
                'description_en' => null, 'description_ar' => null,
                'name' => 'property_description',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'textarea', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price', 'title_ar' => 'السعر',
                'placeholder_en' => 'Enter price (SAR)', 'placeholder_ar' => 'أدخل السعر (ريال)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'price',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Price after discount', 'title_ar' => 'السعر بعد الخصم',
                'placeholder_en' => 'Enter price after discount (SAR)', 'placeholder_ar' => 'أدخل السعر بعد الخصم (ريال)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'price_after_discount',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Area (m²)', 'title_ar' => 'مساحة (م²)',
                'placeholder_en' => 'Enter area', 'placeholder_ar' => 'أدخل المساحة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'area',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Bedrooms', 'title_ar' => 'غرف النوم',
                'placeholder_en' => 'Number of bedrooms', 'placeholder_ar' => 'عدد غرف النوم',
                'description_en' => 'Stepper / Counter (+ / -)', 'description_ar' => 'عداد (+ / -)',
                'name' => 'bedrooms',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Bathrooms', 'title_ar' => 'عدد الحمامات',
                'placeholder_en' => 'Number of bathrooms', 'placeholder_ar' => 'عدد الحمامات',
                'description_en' => 'Stepper / Counter (+ / -)', 'description_ar' => 'عداد (+ / -)',
                'name' => 'number_of_bathrooms',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Toilets', 'title_ar' => 'عدد دورات المياه',
                'placeholder_en' => 'Number of toilets', 'placeholder_ar' => 'عدد دورات المياه',
                'description_en' => 'Stepper / Counter (+ / -)', 'description_ar' => 'عداد (+ / -)',
                'name' => 'number_of_toilets',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Apartment Floor', 'title_ar' => 'ترتيب الشقة',
                'placeholder_en' => 'Select floor', 'placeholder_ar' => 'حدد ترتيب الشقة',
                'description_en' => 'Ground floor / 1 / 2 / 3 … (Show more for more floors)', 'description_ar' => 'دور أرضي / 1 / 2 / 3 … (شاهد المزيد لزيادة الأدوار)',
                'name' => 'apartment_floor',
                'validation_rules' => ['nullable', 'in:ground_floor,1,2,3,4,5,6,7,8,9,10'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'ground_floor', 'label_en' => 'Ground Floor', 'label_ar' => 'دور أرضي'],
                        ['value' => '1', 'label_en' => '1', 'label_ar' => '1'],
                        ['value' => '2', 'label_en' => '2', 'label_ar' => '2'],
                        ['value' => '3', 'label_en' => '3', 'label_ar' => '3'],
                        ['value' => '4', 'label_en' => '4', 'label_ar' => '4'],
                        ['value' => '5', 'label_en' => '5', 'label_ar' => '5'],
                        ['value' => '6', 'label_en' => '6', 'label_ar' => '6'],
                        ['value' => '7', 'label_en' => '7', 'label_ar' => '7'],
                        ['value' => '8', 'label_en' => '8', 'label_ar' => '8'],
                        ['value' => '9', 'label_en' => '9', 'label_ar' => '9'],
                        ['value' => '10', 'label_en' => '10+', 'label_ar' => '10 وأكثر'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Appliance renewal', 'title_ar' => 'تجديد الأدوات',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Optional details (placeholder)', 'description_ar' => 'تفاصيل اختيارية',
                'name' => 'appliance_renewal',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Appliance renewal', 'label_ar' => 'تجديد الأدوات'], 'is_required' => false,
            ],
            [
                'title_en' => 'Heater', 'title_ar' => 'المدفأة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'heater',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Heater', 'label_ar' => 'المدفأة'], 'is_required' => false,
            ],
            [
                'title_en' => 'Insulation works', 'title_ar' => 'أعمال عزل',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'insulation_works',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Insulation works', 'label_ar' => 'أعمال عزل'], 'is_required' => false,
            ],
            [
                'title_en' => 'Elevator maintenance', 'title_ar' => 'صيانة المصعد',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'elevator_maintenance',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Elevator maintenance', 'label_ar' => 'صيانة المصعد'], 'is_required' => false,
            ],
            [
                'title_en' => 'Annex', 'title_ar' => 'الملحق',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'annex',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Annex', 'label_ar' => 'الملحق'], 'is_required' => false,
            ],
            [
                'title_en' => 'AC Type', 'title_ar' => 'نوع التكييف',
                'placeholder_en' => 'Select AC type', 'placeholder_ar' => 'حدد نوع التكييف',
                'description_en' => null, 'description_ar' => null,
                'name' => 'ac_type',
                'validation_rules' => ['nullable', 'in:central,duct,split'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'central', 'label_en' => 'Central', 'label_ar' => 'مركزي'],
                        ['value' => 'duct', 'label_en' => 'Duct', 'label_ar' => 'دكت'],
                        ['value' => 'split', 'label_en' => 'Split', 'label_ar' => 'سبليت'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Property Images and Video', 'title_ar' => 'صور وفيديو العقار',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Drag & drop or browse. Minimum 4 images required. List of files with delete/view actions.', 'description_ar' => 'سحب وإفلات أو تصفح الملفات. حد أدنى 4 صور. قائمة الملفات مع حذف/عرض.',
                'name' => 'property_images_video',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'file', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Status', 'title_ar' => 'الحالة',
                'placeholder_en' => 'Select status', 'placeholder_ar' => 'حدد الحالة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'status',
                'validation_rules' => ['nullable', 'in:available,unavailable'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'available', 'label_en' => 'Available', 'label_ar' => 'متاح'],
                        ['value' => 'unavailable', 'label_en' => 'Unavailable', 'label_ar' => 'غير متاح'],
                    ],
                ], 'is_required' => false,
            ],
        ];
    }

    /**
     * Fixed inputs for category 6 - Screen 1: Basic Property Information (المعلومات الأساسية للعقار).
     * Spec: الفترة (يومي/أسبوعي/شهري)، الصنف (عزاب/عوائل/عزاب وعوائل)، نوع العقار (منتجع فندقي/شاليه/استراحة/مخيم)، مساحة، المعالم القريبة (Repeater).
     */
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
    private function inputsForCategorySevenScreen1(): array
    {
        $yearChoices = array_map(fn ($y) => [
            'value' => (string) $y,
            'label_en' => (string) $y,
            'label_ar' => (string) $y,
        ], range(2026, 2000));

        return [
            [
                'title_en' => 'Brand', 'title_ar' => 'الماركة',
                'placeholder_en' => 'Select brand', 'placeholder_ar' => 'حدد الماركة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'brand',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'opel', 'label_en' => 'Opel', 'label_ar' => 'أوبل'],
                        ['value' => 'bmw', 'label_en' => 'BMW', 'label_ar' => 'بي إم دبليو'],
                        ['value' => 'mercedes', 'label_en' => 'Mercedes', 'label_ar' => 'مرسيدس'],
                        ['value' => 'porsche', 'label_en' => 'Porsche', 'label_ar' => 'بورش'],
                        ['value' => 'toyota', 'label_en' => 'Toyota', 'label_ar' => 'تويوتا'],
                        ['value' => 'nissan', 'label_en' => 'Nissan', 'label_ar' => 'نيسان'],
                        ['value' => 'hyundai', 'label_en' => 'Hyundai', 'label_ar' => 'هيونداي'],
                        ['value' => 'kia', 'label_en' => 'Kia', 'label_ar' => 'كيا'],
                        ['value' => 'honda', 'label_en' => 'Honda', 'label_ar' => 'هوندا'],
                        ['value' => 'ford', 'label_en' => 'Ford', 'label_ar' => 'فورد'],
                        ['value' => 'chevrolet', 'label_en' => 'Chevrolet', 'label_ar' => 'شيفروليه'],
                        ['value' => 'audi', 'label_en' => 'Audi', 'label_ar' => 'أودي'],
                        ['value' => 'volkswagen', 'label_en' => 'Volkswagen', 'label_ar' => 'فولكس فاجن'],
                        ['value' => 'lexus', 'label_en' => 'Lexus', 'label_ar' => 'لكزس'],
                        ['value' => 'land_rover', 'label_en' => 'Land Rover', 'label_ar' => 'لاند روفر'],
                        ['value' => 'jeep', 'label_en' => 'Jeep', 'label_ar' => 'جيب'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Category (Model)', 'title_ar' => 'الفئة (الموديل)',
                'placeholder_en' => 'Select category', 'placeholder_ar' => 'حدد الفئة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'category_model',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'mokka', 'label_en' => 'Mokka', 'label_ar' => 'موكا'],
                        ['value' => 'corsa', 'label_en' => 'Corsa', 'label_ar' => 'كورسا'],
                        ['value' => 'gtc', 'label_en' => 'GTC', 'label_ar' => 'جي تي سي'],
                        ['value' => 'grandland', 'label_en' => 'Grandland', 'label_ar' => 'جراند لاند'],
                        ['value' => 'astra', 'label_en' => 'Astra', 'label_ar' => 'أسترا'],
                        ['value' => 'insignia', 'label_en' => 'Insignia', 'label_ar' => 'إنسيجنيا'],
                        ['value' => 'crossland', 'label_en' => 'Crossland', 'label_ar' => 'كروس لاند'],
                        ['value' => 'zafira', 'label_en' => 'Zafira', 'label_ar' => 'زافيرا'],
                        ['value' => 'adam', 'label_en' => 'Adam', 'label_ar' => 'آدم'],
                        ['value' => 'vectra', 'label_en' => 'Vectra', 'label_ar' => 'فيكترا'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Type (Trim)', 'title_ar' => 'النوع (الفئة/الترِم)',
                'placeholder_en' => 'Select type', 'placeholder_ar' => 'حدد النوع',
                'description_en' => null, 'description_ar' => null,
                'name' => 'type_trim',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'plus', 'label_en' => 'Plus', 'label_ar' => 'بلس'],
                        ['value' => 'standard', 'label_en' => 'Standard', 'label_ar' => 'عادي'],
                        ['value' => 'comfort', 'label_en' => 'Comfort', 'label_ar' => 'كومفورت'],
                        ['value' => 'premium', 'label_en' => 'Premium', 'label_ar' => 'بريميوم'],
                        ['value' => 'luxury', 'label_en' => 'Luxury', 'label_ar' => 'فل كامل'],
                        ['value' => 'sport', 'label_en' => 'Sport', 'label_ar' => 'سبورت'],
                        ['value' => 'limited', 'label_en' => 'Limited', 'label_ar' => 'ليمتد'],
                        ['value' => 'gt', 'label_en' => 'GT', 'label_ar' => 'جي تي'],
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
                        ['value' => 'like_new', 'label_en' => 'Like new', 'label_ar' => 'كالجديد'],
                        ['value' => 'renewed', 'label_en' => 'Renewed', 'label_ar' => 'مجدد'],
                        ['value' => 'needs_minor_maintenance', 'label_en' => 'Needs minor maintenance', 'label_ar' => 'يحتاج صيانة بسيطة'],
                        ['value' => 'needs_major_maintenance', 'label_en' => 'Needs major maintenance', 'label_ar' => 'يحتاج صيانة كبيرة'],
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
                'placeholder_en' => 'Select year', 'placeholder_ar' => 'حدد سنة الصنع',
                'description_en' => null, 'description_ar' => null,
                'name' => 'year_of_manufacture',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'select', 'options' => ['choices' => $yearChoices], 'is_required' => false,
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
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Power (hp)', 'title_ar' => 'الطاقة (قوة حصان)',
                'placeholder_en' => 'Enter power (hp)', 'placeholder_ar' => 'ادخل الطاقة (قوة حصان)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'power_hp',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Consumption (L/100km)', 'title_ar' => 'الاستهلاك (لتر/100كم)',
                'placeholder_en' => 'Enter consumption', 'placeholder_ar' => 'ادخل الاستهلاك (لتر/100كم)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'consumption_l_100km',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
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
                        ['value' => 'automatic', 'label_en' => 'Automatic', 'label_ar' => 'اوتوماتك'],
                        ['value' => 'tiptronic', 'label_en' => 'Tiptronic', 'label_ar' => 'تيبترونيك'],
                        ['value' => 'm1', 'label_en' => 'M1', 'label_ar' => 'ام 1'],
                        ['value' => 'smg', 'label_en' => 'SMG', 'label_ar' => 'اس ام جي'],
                        ['value' => 'cvt', 'label_en' => 'CVT', 'label_ar' => 'CVT'],
                        ['value' => 'dct', 'label_en' => 'DCT (Dual clutch)', 'label_ar' => 'DCT (دبل كلتش)'],
                        ['value' => 'dsg', 'label_en' => 'DSG', 'label_ar' => 'DSG'],
                        ['value' => 'sequential', 'label_en' => 'Manual Sequential', 'label_ar' => 'Manual Sequential'],
                        ['value' => 'ecvt', 'label_en' => 'Hybrid e-CVT', 'label_ar' => 'Hybrid e-CVT'],
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
                        ['value' => 'plug_in_hybrid', 'label_en' => 'Plug-in Hybrid', 'label_ar' => 'Plug-in Hybrid'],
                        ['value' => 'gas', 'label_en' => 'Gas (CNG/LPG)', 'label_ar' => 'غاز (CNG/LPG)'],
                        ['value' => 'hydrogen', 'label_en' => 'Hydrogen', 'label_ar' => 'هيدروجين'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Number of cylinders', 'title_ar' => 'عدد السلندرات',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Stepper / Counter (+ / -)', 'description_ar' => 'عداد (+ / -)',
                'name' => 'number_of_cylinders',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => '3', 'label_en' => '3', 'label_ar' => '3'],
                        ['value' => '4', 'label_en' => '4', 'label_ar' => '4'],
                        ['value' => '5', 'label_en' => '5', 'label_ar' => '5'],
                        ['value' => '6', 'label_en' => '6', 'label_ar' => '6'],
                        ['value' => '8', 'label_en' => '8', 'label_ar' => '8'],
                        ['value' => '10', 'label_en' => '10', 'label_ar' => '10'],
                        ['value' => '12', 'label_en' => '12', 'label_ar' => '12'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Exterior color', 'title_ar' => 'اللون الخارجي',
                'placeholder_en' => 'Select color', 'placeholder_ar' => 'حدد اللون الخارجي',
                'description_en' => null, 'description_ar' => null,
                'name' => 'exterior_color',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'select', 'options' => [
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
                'type' => 'select', 'options' => [
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
                        ['value' => '2', 'label_en' => '2', 'label_ar' => '2'],
                        ['value' => '3', 'label_en' => '3', 'label_ar' => '3'],
                        ['value' => '4', 'label_en' => '4', 'label_ar' => '4'],
                        ['value' => '5', 'label_en' => '5', 'label_ar' => '5'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Extras', 'title_ar' => 'إضافات',
                'placeholder_en' => 'Select + Checkbox group', 'placeholder_ar' => 'حدد الإضافات',
                'description_en' => null, 'description_ar' => null,
                'name' => 'extras',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'select', 'options' => ['choices' => $extrasChoices], 'is_required' => false,
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
                        ['value' => '64gb', 'label_en' => '64GB', 'label_ar' => '64GB'],
                        ['value' => '128gb', 'label_en' => '128GB', 'label_ar' => '128GB'],
                        ['value' => '256gb', 'label_en' => '256GB', 'label_ar' => '256GB'],
                        ['value' => '512gb', 'label_en' => '512GB', 'label_ar' => '512GB'],
                        ['value' => '1tb', 'label_en' => '1TB', 'label_ar' => '1TB'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'RAM', 'title_ar' => 'الرام',
                'placeholder_en' => 'Select RAM', 'placeholder_ar' => 'حدد الرام',
                'description_en' => 'Show more for more options.', 'description_ar' => 'شاهد المزيد.',
                'name' => 'ram',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => '4gb', 'label_en' => '4GB', 'label_ar' => '4GB'],
                        ['value' => '6gb', 'label_en' => '6GB', 'label_ar' => '6GB'],
                        ['value' => '8gb', 'label_en' => '8GB', 'label_ar' => '8GB'],
                        ['value' => '12gb', 'label_en' => '12GB', 'label_ar' => '12GB'],
                        ['value' => '16gb', 'label_en' => '16GB', 'label_ar' => '16GB'],
                        ['value' => '32gb', 'label_en' => '32GB', 'label_ar' => '32GB'],
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
                'title_en' => 'Identical Numbers', 'title_ar' => 'ارقام متماثلة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'identical_numbers',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Identical Numbers', 'label_ar' => 'ارقام متماثلة'], 'is_required' => false,
            ],
            [
                'title_en' => 'Identical Letters', 'title_ar' => 'حروف متماثلة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'identical_letters',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Identical Letters', 'label_ar' => 'حروف متماثلة'], 'is_required' => false,
            ],
            [
                'title_en' => 'Identical Letters and Numbers', 'title_ar' => 'حروف و ارقام متماثلة',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'identical_letters_and_numbers',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Identical Letters and Numbers', 'label_ar' => 'حروف و ارقام متماثلة'], 'is_required' => false,
            ],
            [
                'title_en' => 'Letters with Meaning', 'title_ar' => 'حروف لها معني',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'letters_with_meaning',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Letters with Meaning', 'label_ar' => 'حروف لها معني'], 'is_required' => false,
            ],
            [
                'title_en' => 'Number 1', 'title_ar' => 'رقم 1',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_1',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Number 1', 'label_ar' => 'رقم 1'], 'is_required' => false,
            ],
            [
                'title_en' => 'Odd Number', 'title_ar' => 'رقم فردي',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'odd_number',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Odd Number', 'label_ar' => 'رقم فردي'], 'is_required' => false,
            ],
            [
                'title_en' => 'Two Numbers', 'title_ar' => 'رقمين',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'two_numbers',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Two Numbers', 'label_ar' => 'رقمين'], 'is_required' => false,
            ],
            [
                'title_en' => 'Three Numbers', 'title_ar' => 'ثلاثة ارقام',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'three_numbers',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Three Numbers', 'label_ar' => 'ثلاثة ارقام'], 'is_required' => false,
            ],
            [
                'title_en' => 'Four Numbers', 'title_ar' => 'اربعة ارقام',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'four_numbers',
                'validation_rules' => ['nullable', 'boolean'],
                'type' => 'checkbox', 'options' => ['label_en' => 'Four Numbers', 'label_ar' => 'اربعة ارقام'], 'is_required' => false,
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
    private function inputsForCategoryFourScreen1(): array
    {
        return [
            [
                'title_en' => 'Furniture Type', 'title_ar' => 'نوع الاثاث',
                'placeholder_en' => 'Select furniture type', 'placeholder_ar' => 'حدد نوع الاثاث',
                'description_en' => null, 'description_ar' => null,
                'name' => 'furniture_type',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'bed', 'label_en' => 'Bed', 'label_ar' => 'سرير'],
                        ['value' => 'table', 'label_en' => 'Table', 'label_ar' => 'طاولة'],
                        ['value' => 'sofa', 'label_en' => 'Sofa', 'label_ar' => 'كنب'],
                        ['value' => 'desk', 'label_en' => 'Desk', 'label_ar' => 'مكتب'],
                        ['value' => 'wardrobe', 'label_en' => 'Wardrobe', 'label_ar' => 'دولاب'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Style', 'title_ar' => 'النمط',
                'placeholder_en' => 'Select style', 'placeholder_ar' => 'حدد النمط',
                'description_en' => null, 'description_ar' => null,
                'name' => 'style',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'modern', 'label_en' => 'Modern', 'label_ar' => 'مودرن'],
                        ['value' => 'classic', 'label_en' => 'Classic', 'label_ar' => 'كلاسيك'],
                        ['value' => 'authentic', 'label_en' => 'Authentic', 'label_ar' => 'وافي'],
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
                        ['value' => 'white', 'label_en' => 'White', 'label_ar' => 'أبيض'],
                        ['value' => 'black', 'label_en' => 'Black', 'label_ar' => 'أسود'],
                        ['value' => 'brown', 'label_en' => 'Brown', 'label_ar' => 'بني'],
                        ['value' => 'grey', 'label_en' => 'Grey', 'label_ar' => 'رمادي'],
                        ['value' => 'beige', 'label_en' => 'Beige', 'label_ar' => 'بيج'],
                    ],
                ], 'is_required' => true,
            ],
            [
                'title_en' => 'Material', 'title_ar' => 'الخامة',
                'placeholder_en' => 'Select material', 'placeholder_ar' => 'حدد الخامة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'material',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'glass', 'label_en' => 'Glass', 'label_ar' => 'زجاج'],
                        ['value' => 'plastic', 'label_en' => 'Plastic', 'label_ar' => 'بلاستيك'],
                        ['value' => 'fabric', 'label_en' => 'Fabric', 'label_ar' => 'قماش'],
                        ['value' => 'leather', 'label_en' => 'Leather', 'label_ar' => 'جلد'],
                        ['value' => 'wood', 'label_en' => 'Wood', 'label_ar' => 'خشب'],
                        ['value' => 'marble', 'label_en' => 'Marble', 'label_ar' => 'رخام'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Pieces', 'title_ar' => 'عدد القطع',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_pieces',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Dimensions (m²)', 'title_ar' => 'الابعاد (م²)',
                'placeholder_en' => 'Enter dimensions (m²)', 'placeholder_ar' => 'ادخل الابعاد (م²)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'dimensions_m2',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Brand', 'title_ar' => 'العلامة التجارية',
                'placeholder_en' => 'Select brand', 'placeholder_ar' => 'حدد العلامة التجارية',
                'description_en' => null, 'description_ar' => null,
                'name' => 'brand',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'text', 'options' => null, 'is_required' => false,
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
                'title_en' => 'Warranty Period', 'title_ar' => 'مدة الضمان',
                'placeholder_en' => 'Enter warranty period', 'placeholder_ar' => 'أدخل مدة الضمان',
                'description_en' => null, 'description_ar' => null,
                'name' => 'warranty_period',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Furniture Photos & Videos', 'title_ar' => 'صور و فيديو الاثاث',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'At least 3 photos must be added to display the furniture more clearly.', 'description_ar' => 'يجب إضافة ٣ صور على الأقل لعرض الأثاث بشكل أوضح',
                'name' => 'furniture_photos_videos',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'image', 'options' => null, 'is_required' => true,
            ],
        ];
    }

    /**
     * Logical form input definitions with English and Arabic.
     * Options: one value per option (same for en/ar). select/radio => { choices: [{ value, label_en, label_ar }] }; checkbox => { label_en, label_ar }.
     * Each screen gets a random subset of these inputs.
     */
    private function inputTemplates(): array
    {
        return [
            [
                'name' => 'full_name',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Full Name',
                'title_ar' => 'الاسم الكامل',
                'placeholder_en' => 'Enter your full name',
                'placeholder_ar' => 'أدخل اسمك الكامل',
                'description_en' => 'As it appears on your ID',
                'description_ar' => 'كما يظهر في هويتك',
                'type' => 'text',
                'options' => null,
                'is_required' => true,
            ],
            [
                'name' => 'email',
                'validation_rules' => ['nullable', 'email'],
                'title_en' => 'Email',
                'title_ar' => 'البريد الإلكتروني',
                'placeholder_en' => 'example@domain.com',
                'placeholder_ar' => 'example@domain.com',
                'description_en' => 'We will contact you at this email',
                'description_ar' => 'سنتواصل معك على هذا البريد',
                'type' => 'email',
                'options' => null,
                'is_required' => true,
            ],
            [
                'name' => 'phone_number',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Phone Number',
                'title_ar' => 'رقم الهاتف',
                'placeholder_en' => '05XXXXXXXX',
                'placeholder_ar' => '05XXXXXXXX',
                'description_en' => 'Mobile or landline',
                'description_ar' => 'جوال أو هاتف ثابت',
                'type' => 'phone',
                'options' => null,
                'is_required' => true,
            ],
            [
                'name' => 'date_of_birth',
                'validation_rules' => ['nullable', 'date'],
                'title_en' => 'Date of Birth',
                'title_ar' => 'تاريخ الميلاد',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'Select your birth date',
                'description_ar' => 'اختر تاريخ ميلادك',
                'type' => 'date',
                'options' => null,
                'is_required' => true,
            ],
            [
                'name' => 'gender',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Gender',
                'title_ar' => 'الجنس',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'Select your gender',
                'description_ar' => 'اختر جنسك',
                'type' => 'select',
                'options' => [
                    'choices' => [
                        ['value' => 'male', 'label_en' => 'Male', 'label_ar' => 'ذكر'],
                        ['value' => 'female', 'label_en' => 'Female', 'label_ar' => 'أنثى'],
                    ],
                ],
                'is_required' => true,
            ],
            [
                'name' => 'preferred_contact',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Preferred Contact',
                'title_ar' => 'طريقة التواصل المفضلة',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'How should we contact you?',
                'description_ar' => 'كيف نتواصل معك؟',
                'type' => 'select',
                'options' => [
                    'choices' => [
                        ['value' => 'email', 'label_en' => 'Email', 'label_ar' => 'البريد الإلكتروني'],
                        ['value' => 'phone', 'label_en' => 'Phone', 'label_ar' => 'الهاتف'],
                        ['value' => 'whatsapp', 'label_en' => 'WhatsApp', 'label_ar' => 'واتساب'],
                    ],
                ],
                'is_required' => false,
            ],
            [
                'name' => 'message',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Message',
                'title_ar' => 'الرسالة',
                'placeholder_en' => 'Write your message here...',
                'placeholder_ar' => 'اكتب رسالتك هنا...',
                'description_en' => 'Maximum 500 characters',
                'description_ar' => 'حد أقصى 500 حرف',
                'type' => 'textarea',
                'options' => null,
                'is_required' => true,
            ],
            [
                'name' => 'address',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Address',
                'title_ar' => 'العنوان',
                'placeholder_en' => 'Street, city, postal code',
                'placeholder_ar' => 'الشارع، المدينة، الرمز البريدي',
                'description_en' => null,
                'description_ar' => null,
                'type' => 'text',
                'options' => null,
                'is_required' => false,
            ],
            [
                'name' => 'national_id',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'National ID',
                'title_ar' => 'رقم الهوية الوطنية',
                'placeholder_en' => '10 digits',
                'placeholder_ar' => '10 أرقام',
                'description_en' => 'Your national ID number',
                'description_ar' => 'رقم هويتك الوطنية',
                'type' => 'number',
                'options' => null,
                'is_required' => false,
            ],
            [
                'name' => 'preferred_contact_time',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Preferred Contact Time',
                'title_ar' => 'الوقت المفضل للتواصل',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'When can we call you?',
                'description_ar' => 'متى يمكننا الاتصال بك؟',
                'type' => 'time',
                'options' => null,
                'is_required' => false,
            ],
            [
                'name' => 'agree_to_terms',
                'validation_rules' => ['nullable', 'boolean'],
                'title_en' => 'Agree to terms',
                'title_ar' => 'الموافقة على الشروط',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'I have read and accept the terms',
                'description_ar' => 'لقد قرأت وأوافق على الشروط',
                'type' => 'checkbox',
                'options' => [
                    'label_en' => 'I agree',
                    'label_ar' => 'أوافق',
                ],
                'is_required' => true,
            ],
            [
                'name' => 'website',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Website',
                'title_ar' => 'الموقع الإلكتروني',
                'placeholder_en' => 'https://',
                'placeholder_ar' => 'https://',
                'description_en' => 'Optional',
                'description_ar' => 'اختياري',
                'type' => 'url',
                'options' => null,
                'is_required' => false,
            ],
            [
                'name' => 'upload_document',
                'validation_rules' => ['nullable', 'array'],
                'title_en' => 'Upload Document',
                'title_ar' => 'رفع المستند',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'PDF or image, max 5MB',
                'description_ar' => 'PDF أو صورة، حد أقصى 5 ميجا',
                'type' => 'file',
                'options' => null,
                'is_required' => false,
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $screens = Screen::all();

        if ($screens->isEmpty()) {
            $this->command->warn('No screens found. Run ScreenSeeder first.');
            return;
        }

        $categoryOne = Category::find(1);
        if ($categoryOne) {
            $screen1 = Screen::where('category_id', 1)->where('name_en', 'Basic Property Information')->first();
            $screen2 = Screen::where('category_id', 1)->where('name_en', 'Property Details')->first();

            if ($screen1) {
                Input::where('screen_id', $screen1->id)->delete();
                foreach ($this->inputsForBasicPropertyInfo() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen1->id]));
                }
            }
            if ($screen2) {
                Input::where('screen_id', $screen2->id)->delete();
                foreach ($this->inputsForPropertyDetails() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen2->id]));
                }
            }
        }

        $categoryTwo = Category::find(2);
        if ($categoryTwo) {
            $screen1Cat2 = Screen::where('category_id', 2)->where('name_en', 'Basic Project Information')->first();
            $screen2Cat2 = Screen::where('category_id', 2)->where('name_en', 'Property Details (Project)')->first();

            if ($screen1Cat2) {
                Input::where('screen_id', $screen1Cat2->id)->delete();
                foreach ($this->inputsForBasicProjectInfo() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen1Cat2->id]));
                }
            }
            if ($screen2Cat2) {
                Input::where('screen_id', $screen2Cat2->id)->delete();
                foreach ($this->inputsForPropertyDetailsProject() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen2Cat2->id]));
                }
            }
        }

        // Category id 5: same screens and inputs as category 1 (Property for Sale)
        $categoryFive = Category::find(5);
        if ($categoryFive) {
            $screen1Cat5 = Screen::where('category_id', 5)->where('name_en', 'Basic Property Information')->first();
            $screen2Cat5 = Screen::where('category_id', 5)->where('name_en', 'Property Details')->first();

            if ($screen1Cat5) {
                Input::where('screen_id', $screen1Cat5->id)->delete();
                foreach ($this->inputsForBasicPropertyInfo() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen1Cat5->id]));
                }
            }
            if ($screen2Cat5) {
                Input::where('screen_id', $screen2Cat5->id)->delete();
                foreach ($this->inputsForPropertyDetails() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen2Cat5->id]));
                }
            }
        }

        $categoryThree = Category::find(3);
        if ($categoryThree) {
            $screen1Cat3 = Screen::where('category_id', 3)->where('name_en', 'Basic Data for Car Plates')->first();

            if ($screen1Cat3) {
                Input::where('screen_id', $screen1Cat3->id)->delete();
                foreach ($this->inputsForCategoryThreeScreen1() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen1Cat3->id]));
                }
            }
        }

        $categoryFour = Category::find(4);
        if ($categoryFour) {
            $screen1Cat4 = Screen::where('category_id', 4)->where('name_en', 'Basic Data for Furniture and Accessories')->first();

            if ($screen1Cat4) {
                Input::where('screen_id', $screen1Cat4->id)->delete();
                foreach ($this->inputsForCategoryFourScreen1() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen1Cat4->id]));
                }
            }
        }

        $categorySix = Category::find(6);
        if ($categorySix) {
            $screen1Cat6 = Screen::where('category_id', 6)->where('name_en', 'Basic Property Information')->first();
            $screen2Cat6 = Screen::where('category_id', 6)->where('name_en', 'Property Details')->first();
            $screen3Cat6 = Screen::where('category_id', 6)->where('name_en', 'Property Price')->first();

            if ($screen1Cat6) {
                Input::where('screen_id', $screen1Cat6->id)->delete();
                foreach ($this->inputsForCategorySixScreen1() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen1Cat6->id]));
                }
            }
            if ($screen2Cat6) {
                Input::where('screen_id', $screen2Cat6->id)->delete();
                foreach ($this->inputsForCategorySixScreen2() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen2Cat6->id]));
                }
            }
            if ($screen3Cat6) {
                Input::where('screen_id', $screen3Cat6->id)->delete();
                foreach ($this->inputsForCategorySixScreen3() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen3Cat6->id]));
                }
            }
        }

        $categorySeven = Category::find(7);
        if ($categorySeven) {
            $screen1Cat7 = Screen::where('category_id', 7)->where('name_en', 'Basic Car Information')->first();
            $screen2Cat7 = Screen::where('category_id', 7)->where('name_en', 'Car Details')->first();

            if ($screen1Cat7) {
                Input::where('screen_id', $screen1Cat7->id)->delete();
                foreach ($this->inputsForCategorySevenScreen1() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen1Cat7->id]));
                }
            }
            if ($screen2Cat7) {
                Input::where('screen_id', $screen2Cat7->id)->delete();
                foreach ($this->inputsForCategorySevenScreen2() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen2Cat7->id]));
                }
            }
        }

        $categoryEight = Category::find(8);
        if ($categoryEight) {
            $screen1Cat8 = Screen::where('category_id', 8)->where('name_en', 'Basic Data for Devices and Equipment')->first();

            if ($screen1Cat8) {
                Input::where('screen_id', $screen1Cat8->id)->delete();
                foreach ($this->inputsForCategoryEightScreen1() as $input) {
                    Input::create(array_merge($input, ['screen_id' => $screen1Cat8->id]));
                }
            }
        }

        $templates = $this->inputTemplates();
        $excludeScreenIds = Screen::whereIn('category_id', [1, 2, 3, 4, 5, 6, 7, 8])->pluck('id')->all();

        foreach ($screens as $screen) {
            if (in_array($screen->id, $excludeScreenIds, true)) {
                continue;
            }
            // Each other screen gets 3 to 6 inputs from templates
            $count = min(rand(3, 6), count($templates));
            $picked = array_rand(array_flip(array_keys($templates)), $count);
            $picked = is_array($picked) ? $picked : [$picked];

            foreach ($picked as $index) {
                $template = $templates[$index];
                Input::create([
                    'screen_id' => $screen->id,
                    'name' => $template['name'],
                    'validation_rules' => $template['validation_rules'],
                    'title_en' => $template['title_en'],
                    'title_ar' => $template['title_ar'],
                    'placeholder_en' => $template['placeholder_en'],
                    'placeholder_ar' => $template['placeholder_ar'],
                    'description_en' => $template['description_en'],
                    'description_ar' => $template['description_ar'],
                    'type' => $template['type'],
                    'options' => $template['options'],
                    'is_required' => $template['is_required'],
                ]);
            }
        }
    }
}
