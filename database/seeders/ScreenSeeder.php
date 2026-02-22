<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Screen;
use Illuminate\Database\Seeder;

class ScreenSeeder extends Seeder
{
    /**
     * Logical screens per category (keyed by category name_en).
     * Each screen has name_en, name_ar, description_en, description_ar.
     */
    private function screensByCategory(): array
    {
        return [
            'Annual Rental Property' => [
                [
                    'name_en' => 'Property Details',
                    'name_ar' => 'تفاصيل العقار',
                    'description_en' => 'Enter the main property information such as type, size, and number of rooms.',
                    'description_ar' => 'أدخل المعلومات الرئيسية للعقار مثل النوع والمساحة وعدد الغرف.',
                ],
                [
                    'name_en' => 'Location & Address',
                    'name_ar' => 'الموقع والعنوان',
                    'description_en' => 'Specify the property location, district, and nearby landmarks.',
                    'description_ar' => 'حدد موقع العقار والحي والمعالم القريبة.',
                ],
                [
                    'name_en' => 'Pricing & Payment',
                    'name_ar' => 'التسعير والدفع',
                    'description_en' => 'Set the annual rent amount and payment terms.',
                    'description_ar' => 'حدد قيمة الإيجار السنوي وشروط الدفع.',
                ],
                [
                    'name_en' => 'Contact & Availability',
                    'name_ar' => 'التواصل والتوفر',
                    'description_en' => 'When the property is available and how to contact you.',
                    'description_ar' => 'متى يتوفر العقار وكيفية التواصل معك.',
                ],
            ],
            'Projects' => [
                [
                    'name_en' => 'Project Overview',
                    'name_ar' => 'نظرة عامة على المشروع',
                    'description_en' => 'Brief description and objectives of the project.',
                    'description_ar' => 'وصف موجز وأهداف المشروع.',
                ],
                [
                    'name_en' => 'Scope & Deliverables',
                    'name_ar' => 'النطاق والمخرجات',
                    'description_en' => 'Project scope, phases, and expected deliverables.',
                    'description_ar' => 'نطاق المشروع ومراحله والمخرجات المتوقعة.',
                ],
                [
                    'name_en' => 'Timeline & Milestones',
                    'name_ar' => 'الجدول الزمني والمراحل',
                    'description_en' => 'Start date, duration, and key milestones.',
                    'description_ar' => 'تاريخ البدء والمدة والمراحل الرئيسية.',
                ],
                [
                    'name_en' => 'Budget & Funding',
                    'name_ar' => 'الميزانية والتمويل',
                    'description_en' => 'Estimated budget and funding details.',
                    'description_ar' => 'الميزانية التقديرية وتفاصيل التمويل.',
                ],
            ],
            'Car Plates' => [
                [
                    'name_en' => 'Plate Details',
                    'name_ar' => 'تفاصيل اللوحة',
                    'description_en' => 'Plate number, code, and type (personal, commercial, etc.).',
                    'description_ar' => 'رقم اللوحة والرمز والنوع (شخصي، تجاري، إلخ).',
                ],
                [
                    'name_en' => 'Vehicle Information',
                    'name_ar' => 'معلومات المركبة',
                    'description_en' => 'Vehicle linked to the plate if applicable.',
                    'description_ar' => 'المركبة المرتبطة باللوحة إن وجدت.',
                ],
                [
                    'name_en' => 'Owner & Contact',
                    'name_ar' => 'المالك والتواصل',
                    'description_en' => 'Owner details and contact information.',
                    'description_ar' => 'بيانات المالك ومعلومات التواصل.',
                ],
            ],
            'Furniture & Accessories' => [
                [
                    'name_en' => 'Item Details',
                    'name_ar' => 'تفاصيل القطعة',
                    'description_en' => 'Name, type of furniture or accessory, and brand.',
                    'description_ar' => 'الاسم ونوع الأثاث أو الكماليات والعلامة التجارية.',
                ],
                [
                    'name_en' => 'Condition & Photos',
                    'name_ar' => 'الحالة والصور',
                    'description_en' => 'Condition (new, like new, used) and images.',
                    'description_ar' => 'الحالة (جديد، كالجديد، مستعمل) والصور.',
                ],
                [
                    'name_en' => 'Price & Location',
                    'name_ar' => 'السعر والموقع',
                    'description_en' => 'Asking price and pickup/delivery location.',
                    'description_ar' => 'السعر المطلوب وموقع الاستلام أو التوصيل.',
                ],
            ],
            'Property for Sale' => [
                [
                    'name_en' => 'Property Information',
                    'name_ar' => 'معلومات العقار',
                    'description_en' => 'Type, size, rooms, and main features of the property.',
                    'description_ar' => 'النوع والمساحة والغرف وأهم مميزات العقار.',
                ],
                [
                    'name_en' => 'Features & Amenities',
                    'name_ar' => 'المميزات والمرافق',
                    'description_en' => 'Amenities such as parking, garden, finishing.',
                    'description_ar' => 'المرافق مثل المواقف والحديقة والتشطيب.',
                ],
                [
                    'name_en' => 'Price & Contact',
                    'name_ar' => 'السعر والتواصل',
                    'description_en' => 'Asking price and how to contact the seller.',
                    'description_ar' => 'السعر المطلوب وكيفية التواصل مع البائع.',
                ],
            ],
            'Property for Rent (Daily - Monthly)' => [
                [
                    'name_en' => 'Rental Details',
                    'name_ar' => 'تفاصيل الإيجار',
                    'description_en' => 'Property type, capacity, and rental type (daily/monthly).',
                    'description_ar' => 'نوع العقار والسعة ونوع الإيجار (يومي/شهري).',
                ],
                [
                    'name_en' => 'Availability & Rates',
                    'name_ar' => 'التوفر والأسعار',
                    'description_en' => 'Available dates and daily or monthly rates.',
                    'description_ar' => 'التواريخ المتاحة وأسعار اليوم أو الشهر.',
                ],
                [
                    'name_en' => 'Location & Contact',
                    'name_ar' => 'الموقع والتواصل',
                    'description_en' => 'Address and contact information for bookings.',
                    'description_ar' => 'العنوان ومعلومات التواصل للحجز.',
                ],
            ],
            'Cars' => [
                [
                    'name_en' => 'Car Details',
                    'name_ar' => 'تفاصيل السيارة',
                    'description_en' => 'Make, model, year, and mileage.',
                    'description_ar' => 'الشركة والموديل والسنة وعدد الكيلومترات.',
                ],
                [
                    'name_en' => 'Specifications & Condition',
                    'name_ar' => 'المواصفات والحالة',
                    'description_en' => 'Engine, transmission, fuel type, and condition.',
                    'description_ar' => 'المحرك وناقل الحركة ونوع الوقود والحالة.',
                ],
                [
                    'name_en' => 'Seller & Contact',
                    'name_ar' => 'البائع والتواصل',
                    'description_en' => 'Seller information and contact details.',
                    'description_ar' => 'معلومات البائع وبيانات التواصل.',
                ],
            ],
            'Devices & Equipment' => [
                [
                    'name_en' => 'Device Information',
                    'name_ar' => 'معلومات الجهاز',
                    'description_en' => 'Device type, brand, model, and basic specs.',
                    'description_ar' => 'نوع الجهاز والعلامة التجارية والموديل والمواصفات الأساسية.',
                ],
                [
                    'name_en' => 'Specifications & Warranty',
                    'name_ar' => 'المواصفات والضمان',
                    'description_en' => 'Technical specifications and warranty status.',
                    'description_ar' => 'المواصفات الفنية وحالة الضمان.',
                ],
                [
                    'name_en' => 'Price & Contact',
                    'name_ar' => 'السعر والتواصل',
                    'description_en' => 'Asking price and contact information.',
                    'description_ar' => 'السعر المطلوب ومعلومات التواصل.',
                ],
            ],
        ];
    }

    /**
     * Fixed 2 screens for category id 1 (from property listing UI).
     */
    private function screensForCategoryOne(): array
    {
        return [
            [
                'name_en' => 'Basic Property Information',
                'name_ar' => 'المعلومات الأساسية للعقار',
                'description_en' => 'Enter the basic property information: purpose, type, status, furnishing, condition, area, facade, and nearby landmarks.',
                'description_ar' => 'أدخل المعلومات الأساسية للعقار: الغرض، النوع، الحالة، التأثيث، وضع العقار، المساحة، الواجهة، والمعالم القريبة.',
            ],
            [
                'name_en' => 'Property Details',
                'name_ar' => 'تفاصيل العقار',
                'description_en' => 'Enter property details: bedrooms, halls, bathrooms, arrangement, features, AC type, warranty, and upload photos/videos and blueprint.',
                'description_ar' => 'أدخل تفاصيل العقار: غرف النوم، الصالات، دورات المياه، ترتيب الشقة، المميزات، نوع التكييف، الضمان، ورفع الصور/الفيديو والمخطط المصغر.',
            ],
        ];
    }

    /**
     * Fixed 2 screens for category id 2 (Projects - from project listing UI).
     * Screen 1: Basic Project Information (المعلومات الأساسية للمشروع)
     * Screen 2: Property Details (تفاصيل العقار)
     */
    private function screensForCategoryTwo(): array
    {
        return [
            [
                'name_en' => 'Basic Project Information',
                'name_ar' => 'المعلومات الأساسية للمشروع',
                'description_en' => 'Enter project features (anchor), project status, completion date, situation, guarantees and commission, construction date, number of units, unit area, price, facade, finishing type, master plan, company logo, and facade logo.',
                'description_ar' => 'أدخل المميزات (المرسى)، حالة المشروع، تاريخ الانتهاء، وضع المشروع، الضمانات والعمولة، تاريخ البناء، عدد الوحدات، مساحة الوحدة، السعر، الواجهة، نوع التشطيب، المخطط الرئيسي، شعار الشركة، وشعار الواجهة.',
            ],
            [
                'name_en' => 'Property Details (Project)',
                'name_ar' => 'تفاصيل العقار',
                'description_en' => 'Enter property name, address, location, description, property type, floors, rooms, bathrooms, halls, kitchens, guarantees, commission, AC type, status, rental value, unit image, addition date, city, neighborhood, street, and property number.',
                'description_ar' => 'أدخل اسم العقار، العنوان، الموقع، وصف العقار، نوع العقار، عدد الطوابق، الغرف، دورات المياه، الصالات، المطابخ، الضمانات، العمولة، نوع التكييف، الحالة، القيمة الإيجارية، صورة الوحدة، تاريخ الإضافة، المدينة، الحي، الشارع، ورقم العقار.',
            ],
        ];
    }

    /**
     * Fixed 3 screens for category id 6 (Property for Rent Daily-Monthly - rental flow UI).
     */
    private function screensForCategorySix(): array
    {
        return [
            [
                'name_en' => 'Basic Property Information',
                'name_ar' => 'المعلومات الأساسية للعقار',
                'description_en' => 'Enter purpose, category, property type, area, and nearby landmarks.',
                'description_ar' => 'أدخل الغرض، الصنف، نوع العقار، المساحة، والمعالم القريبة.',
            ],
            [
                'name_en' => 'Property Details',
                'name_ar' => 'تفاصيل العقار',
                'description_en' => 'Enter rooms, halls, bathrooms, features, facilities, and property photos.',
                'description_ar' => 'أدخل الغرف، الصالات، دورات المياه، المميزات، المرافق، وصور العقار.',
            ],
            [
                'name_en' => 'Property Price',
                'name_ar' => 'سعر العقار',
                'description_en' => 'Enter financial matters, cancellation period, daily/weekly/monthly prices, and deposit.',
                'description_ar' => 'أدخل الأمور المالية، مدة الإلغاء، أسعار اليومي/الأسبوعي/الشهري، ومبلغ التأمين.',
            ],
        ];
    }

    /**
     * Fixed 2 screens for category id 7 (Cars - add car ad UI).
     */
    private function screensForCategorySeven(): array
    {
        return [
            [
                'name_en' => 'Basic Car Information',
                'name_ar' => 'البيانات الأساسية للسيارة',
                'description_en' => 'Enter car type, category, color, country of origin, odometer, condition, and photos.',
                'description_ar' => 'أدخل نوع السيارة، الفئة، اللون، البلد المنشأ، عداد الأمتار، الحالة، والصور.',
            ],
            [
                'name_en' => 'Car Details',
                'name_ar' => 'تفاصيل السيارة',
                'description_en' => 'Enter engine, horsepower, consumption, drive type, cooling, fuel type, doors, extras, and warranty.',
                'description_ar' => 'أدخل المحرك، القوة الحصانية، الاستهلاك، نوع الدفع، التبريد، نوع الوقود، الأبواب، الإضافات، والضمان.',
            ],
        ];
    }

    /**
     * Fixed 1 screen for category id 3 (Car Plates).
     */
    private function screensForCategoryThree(): array
    {
        return [
            [
                'name_en' => 'Basic Data for Car Plates',
                'name_ar' => 'البيانات الأساسية للوحات السيارات',
                'description_en' => 'Enter plate type, features, status, and plate number.',
                'description_ar' => 'أدخل نوع اللوحة، المميزات، الحالة، ورقم اللوحة.',
            ],
        ];
    }

    /**
     * Fixed 1 screen for category id 4 (Furniture & Accessories).
     */
    private function screensForCategoryFour(): array
    {
        return [
            [
                'name_en' => 'Basic Data for Furniture and Accessories',
                'name_ar' => 'البيانات الأساسية للأثاث و كماليات',
                'description_en' => 'Enter furniture type, style, color, material, dimensions, condition, warranty, and photos.',
                'description_ar' => 'أدخل نوع الأثاث، النمط، اللون، الخامة، الأبعاد، الحالة، الضمان، والصور.',
            ],
        ];
    }

    /**
     * Fixed 1 screen for category id 8 (Devices & Equipment).
     */
    private function screensForCategoryEight(): array
    {
        return [
            [
                'name_en' => 'Basic Data for Devices and Equipment',
                'name_ar' => 'البيانات الأساسية للأجهزة والمعدات',
                'description_en' => 'Enter device type, brand, storage capacity, RAM, size (inches), color, condition, warranty period, and photos/video (min 4 images).',
                'description_ar' => 'أدخل الجهاز (نوع الجهاز)، الماركة، سعة التخزين، الرام، الحجم بالبوصة، اللون، الحالة، مدة الضمان، وصور وفيديو الإلكترونيات (4 صور على الأقل).',
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Run CategorySeeder first.');
            return;
        }

        $screensByCategory = $this->screensByCategory();

        // Category id 1: exactly 2 screens (from property listing UI)
        $categoryOne = Category::find(1);
        if ($categoryOne) {
            Screen::where('category_id', 1)->delete();
            foreach ($this->screensForCategoryOne() as $screenData) {
                Screen::create([
                    'category_id' => 1,
                    'name_en' => $screenData['name_en'],
                    'name_ar' => $screenData['name_ar'],
                    'description_en' => $screenData['description_en'],
                    'description_ar' => $screenData['description_ar'],
                ]);
            }
        }

        // Category id 5: same 2 screens as category 1 (Property for Sale - same property listing UI)
        $categoryFive = Category::find(5);
        if ($categoryFive) {
            Screen::where('category_id', 5)->delete();
            foreach ($this->screensForCategoryOne() as $screenData) {
                Screen::create([
                    'category_id' => 5,
                    'name_en' => $screenData['name_en'],
                    'name_ar' => $screenData['name_ar'],
                    'description_en' => $screenData['description_en'],
                    'description_ar' => $screenData['description_ar'],
                ]);
            }
        }

        // Category id 2: exactly 2 screens (from project listing UI)
        $categoryTwo = Category::find(2);
        if ($categoryTwo) {
            Screen::where('category_id', 2)->delete();
            foreach ($this->screensForCategoryTwo() as $screenData) {
                Screen::create([
                    'category_id' => 2,
                    'name_en' => $screenData['name_en'],
                    'name_ar' => $screenData['name_ar'],
                    'description_en' => $screenData['description_en'],
                    'description_ar' => $screenData['description_ar'],
                ]);
            }
        }

        // Category id 3: exactly 1 screen (Car Plates)
        $categoryThree = Category::find(3);
        if ($categoryThree) {
            Screen::where('category_id', 3)->delete();
            foreach ($this->screensForCategoryThree() as $screenData) {
                Screen::create([
                    'category_id' => 3,
                    'name_en' => $screenData['name_en'],
                    'name_ar' => $screenData['name_ar'],
                    'description_en' => $screenData['description_en'],
                    'description_ar' => $screenData['description_ar'],
                ]);
            }
        }

        // Category id 4: exactly 1 screen (Furniture & Accessories)
        $categoryFour = Category::find(4);
        if ($categoryFour) {
            Screen::where('category_id', 4)->delete();
            foreach ($this->screensForCategoryFour() as $screenData) {
                Screen::create([
                    'category_id' => 4,
                    'name_en' => $screenData['name_en'],
                    'name_ar' => $screenData['name_ar'],
                    'description_en' => $screenData['description_en'],
                    'description_ar' => $screenData['description_ar'],
                ]);
            }
        }

        // Category id 6: exactly 3 screens (daily/monthly rental flow UI)
        $categorySix = Category::find(6);
        if ($categorySix) {
            Screen::where('category_id', 6)->delete();
            foreach ($this->screensForCategorySix() as $screenData) {
                Screen::create([
                    'category_id' => 6,
                    'name_en' => $screenData['name_en'],
                    'name_ar' => $screenData['name_ar'],
                    'description_en' => $screenData['description_en'],
                    'description_ar' => $screenData['description_ar'],
                ]);
            }
        }

        // Category id 7: exactly 2 screens (Cars - add car ad UI)
        $categorySeven = Category::find(7);
        if ($categorySeven) {
            Screen::where('category_id', 7)->delete();
            foreach ($this->screensForCategorySeven() as $screenData) {
                Screen::create([
                    'category_id' => 7,
                    'name_en' => $screenData['name_en'],
                    'name_ar' => $screenData['name_ar'],
                    'description_en' => $screenData['description_en'],
                    'description_ar' => $screenData['description_ar'],
                ]);
            }
        }

        // Category id 8: exactly 1 screen (Devices & Equipment)
        $categoryEight = Category::find(8);
        if ($categoryEight) {
            Screen::where('category_id', 8)->delete();
            foreach ($this->screensForCategoryEight() as $screenData) {
                Screen::create([
                    'category_id' => 8,
                    'name_en' => $screenData['name_en'],
                    'name_ar' => $screenData['name_ar'],
                    'description_en' => $screenData['description_en'],
                    'description_ar' => $screenData['description_ar'],
                ]);
            }
        }

        // Other categories: use existing screen map
        foreach ($categories as $category) {
            if (in_array($category->id, [1, 2, 3, 4, 5, 6, 7, 8], true)) {
                continue;
            }

            $screens = $screensByCategory[$category->name_en] ?? null;

            if (empty($screens)) {
                $screens = [
                    [
                        'name_en' => $category->name_en . ' - Main',
                        'name_ar' => $category->name_ar . ' - رئيسي',
                        'description_en' => 'Main screen for this category.',
                        'description_ar' => 'الشاشة الرئيسية لهذا التصنيف.',
                    ],
                ];
            }

            foreach ($screens as $screenData) {
                Screen::firstOrCreate(
                    [
                        'category_id' => $category->id,
                        'name_en' => $screenData['name_en'],
                    ],
                    [
                        'name_ar' => $screenData['name_ar'],
                        'description_en' => $screenData['description_en'],
                        'description_ar' => $screenData['description_ar'],
                    ]
                );
            }
        }
    }
}
