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

        foreach ($categories as $category) {
            $screens = $screensByCategory[$category->name_en] ?? null;

            if (empty($screens)) {
                // Fallback: one generic screen per category if name_en not in map
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
