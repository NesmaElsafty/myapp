<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Screen;
use Database\Seeders\Concerns\SeedsInputScreens;
use Illuminate\Database\Seeder;

class InputAnnualRentalPropertySeeder extends Seeder
{
    use SeedsInputScreens;

    public function run(): void
    {
        if (!Category::find(1)) {
            return;
        }

        $this->registerInputCreatingHook();

        $screen1 = Screen::where('category_id', 1)->where('name_en', 'Basic Property Information')->first();
        $screen2 = Screen::where('category_id', 1)->where('name_en', 'Property Details')->first();

        $this->seedInputsForScreen($screen1, $this->inputsForBasicPropertyInfo());
        $this->seedInputsForScreen($screen2, $this->inputsForPropertyDetails());
    }

    protected function inputsForBasicPropertyInfo(): array
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
                'type' => 'calendar', 'options' => null, 'is_required' => false,
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
                'type' => 'nearby_landmarks_input',
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
                        [
                            'key' => 'image',
                            'label_en' => 'Image',
                            'label_ar' => 'الصورة',
                            'placeholder_en' => 'Enter distance',
                            'placeholder_ar' => 'أرفق صورةالمعلم',
                            'type' => 'file',
                            'name' => 'image',
                            'validation_rules' => ['nullable', 'file'],
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

    protected function inputsForPropertyDetails(): array
    {
        return [
            [
                'title_en' => 'Bedrooms', 'title_ar' => 'غرف النوم',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'bedrooms',
                'validation_rules' => ['required', 'numeric'],
                'type' => 'counter', 'options' => null, 'is_required' => true,
            ],
            [
                'title_en' => 'Number of Halls', 'title_ar' => 'عدد الصالات',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_halls',
                'validation_rules' => ['required', 'numeric'],
                'type' => 'counter', 'options' => null, 'is_required' => true,
            ],
            [
                'title_en' => 'Number of Bathrooms', 'title_ar' => 'عدد دورات المياه',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_bathrooms',
                'validation_rules' => ['required', 'numeric'],
                'type' => 'counter', 'options' => null, 'is_required' => true,
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
                        ['value' => '4', 'label_en' => '4', 'label_ar' => '4'],
                        ['value' => '5', 'label_en' => '5', 'label_ar' => '5'],
                        ['value' => '6', 'label_en' => '6', 'label_ar' => '6'],
                        ['value' => '7', 'label_en' => '7', 'label_ar' => '7'],
                        ['value' => '8', 'label_en' => '8', 'label_ar' => '8'],
                        ['value' => '9', 'label_en' => '9', 'label_ar' => '9'],
                        ['value' => '10', 'label_en' => '10+', 'label_ar' => '10 وأكثر'],
                    ],
                ], 'is_required' => true,
            ],
            [
                'title_en' => 'Benefits', 'title_ar' => 'المميزات',
                'placeholder_en' => 'Select benefits', 'placeholder_ar' => 'حدد المميزات',
                'description_en' => 'Multi-select.', 'description_ar' => 'اختيار متعدد.',
                'name' => 'benefits',
                'validation_rules' => ['required', 'array'],
                'type' => 'multi_select',
                'options' => [
                    'choices' => [
                        ['value' => 'water', 'label_en' => 'Water', 'label_ar' => 'ماء'],
                        ['value' => 'electricity', 'label_en' => 'Electricity', 'label_ar' => 'كهرباء'],
                        ['value' => 'sewage', 'label_en' => 'Sewage', 'label_ar' => 'صرف صحي'],
                        ['value' => 'fiber_optics', 'label_en' => 'Fiber optics', 'label_ar' => 'الياف بصرية'],
                        ['value' => 'near_a_mosque', 'label_en' => 'Near a mosque', 'label_ar' => 'قرب مسجد'],
                        ['value' => 'maid_s_room', 'label_en' => "Maid's room", 'label_ar' => 'غرفة خادمة'],
                        ['value' => 'driver_s_room', 'label_en' => "Driver's room", 'label_ar' => 'غرفة سائق'],
                        ['value' => 'near_a_garden', 'label_en' => 'Near a garden', 'label_ar' => 'قرب حديقة'],
                        ['value' => 'near_a_train_station', 'label_en' => 'Near a train station', 'label_ar' => 'قرب محطة قطار'],
                        ['value' => 'independent_electricity_meter', 'label_en' => 'Independent electricity meter', 'label_ar' => 'عداد كهرباء مستقل'],
                        ['value' => 'independent_water_meter', 'label_en' => 'Independent water meter', 'label_ar' => 'عداد ماء مستقل'],
                        ['value' => 'balcony', 'label_en' => 'Balcony', 'label_ar' => 'شرفه'],
                        ['value' => 'surveillance_camera_system', 'label_en' => 'Surveillance camera system', 'label_ar' => 'نظام كاميرات مراقبة'],
                        ['value' => 'private_entrance', 'label_en' => 'Private entrance', 'label_ar' => 'مدخل خاص'],
                        ['value' => 'private_garden', 'label_en' => 'Private garden', 'label_ar' => 'حديقة خاصة'],
                        ['value' => 'central_water_heater', 'label_en' => 'Central water heater', 'label_ar' => 'سخان مركزي'],
                        ['value' => 'private_rooftop', 'label_en' => 'Private rooftop', 'label_ar' => 'سطح خاص'],
                        ['value' => 'upper_annex', 'label_en' => 'Upper annex', 'label_ar' => 'ملحق علوي'],
                        ['value' => 'ground_floor_annex', 'label_en' => 'Ground floor annex', 'label_ar' => 'ملحق أرضي'],
                        ['value' => 'tent_poetic_house', 'label_en' => 'Tent / poetic house', 'label_ar' => 'بيت شعر'],
                        ['value' => 'laundry_room', 'label_en' => 'Laundry room', 'label_ar' => 'غرفة غسيل'],
                        ['value' => 'hallway_stairs', 'label_en' => 'Hallway stairs', 'label_ar' => 'درج صالة'],
                        ['value' => 'side_stairs', 'label_en' => 'Side stairs', 'label_ar' => 'درج جانبي'],
                        ['value' => 'emergency_backup_electrical_system', 'label_en' => 'Emergency backup electrical system', 'label_ar' => 'نظام كهربائي احتياطي للطوارئ'],
                        ['value' => 'central_heating_and_air_conditioning', 'label_en' => 'Central heating and air conditioning', 'label_ar' => 'تدفئة وتكييف مركزي'],
                    ],
                ],
                'is_required' => true,
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
                'validation_rules' => ['required', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => true,
            ],
            [
                'title_en' => 'Property Photos & Video', 'title_ar' => 'صور و فيديو العقار',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'At least 4 photos recommended for a clearer listing.', 'description_ar' => 'يجب إضافة ٤ صور على الأقل لكي يظهر اعلانك بشكل أوضح',
                'name' => 'property_photos_video',
                'validation_rules' => ['required', 'array'],
                'type' => 'file', 'options' => null, 'is_required' => true,
            ],
            [
                'title_en' => 'Miniature Plan / Blueprint', 'title_ar' => 'مخطط مصغر',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'Upload blueprint or floor plan.', 'description_ar' => 'ارفع المخطط أو المسقط الأفقي.',
                'name' => 'miniature_plan_blueprint',
                'validation_rules' => ['required', 'file'],
                'type' => 'file', 'options' => null, 'is_required' => true,
            ],
        ];
    }
    /**
     * Fixed inputs for Screen 1: Basic Project Information (category id 2).
     * Spec: الغرض، نوع المشروع، حالة المشروع، التأثيث، وضع المشروع، تاريخ البناء، عدد الوحدات، عدد العمارات، المساحة (من/إلى)، السعر (من/إلى)، الواجهة، عرض الشارع، المميزات (25)، تاريخ التسليم، صور وفيديو، كتيب المشروع، شعار الشركة، المعالم القريبة.
     */
}
