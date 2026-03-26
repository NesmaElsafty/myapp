<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Screen;
use Database\Seeders\Concerns\SeedsInputScreens;
use Illuminate\Database\Seeder;

class InputProjectsSeeder extends Seeder
{
    use SeedsInputScreens;

    public function run(): void
    {
        if (!Category::find(2)) {
            return;
        }

        $this->registerInputCreatingHook();

        $screen1 = Screen::where('category_id', 2)->where('name_en', 'Basic Project Information')->first();
        $screen2 = Screen::where('category_id', 2)->where('name_en', 'Property Details (Project)')->first();

        $this->seedInputsForScreen($screen1, $this->inputsForBasicProjectInfo());
        $this->seedInputsForScreen($screen2, $this->inputsForPropertyDetailsProject());
    }

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

}
