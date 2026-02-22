<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Project types (النوع) for category 2 - English and Arabic.
     */
    private function projectTypes(): array
    {
        return [
            ['label_en' => 'Apartments', 'label_ar' => 'شقق'],
            ['label_en' => 'Villas', 'label_ar' => 'فلل'],
            ['label_en' => 'Buildings', 'label_ar' => 'عمارات'],
            ['label_en' => 'Chalets', 'label_ar' => 'شاليهات'],
            ['label_en' => 'Lands', 'label_ar' => 'أراضي'],
            ['label_en' => 'Duplexes', 'label_ar' => 'دبلوكسات'],
            ['label_en' => 'Townhouses', 'label_ar' => 'تاون هاوس'],
            ['label_en' => 'Showrooms', 'label_ar' => 'صالات عرض'],
            ['label_en' => 'Offices', 'label_ar' => 'مكاتب'],
            ['label_en' => 'Floors', 'label_ar' => 'أدوار'],
        ];
    }

    /**
     * Property types (المميزات) for categories 1 and 5 - English and Arabic.
     */
    private function propertyTypes(): array
    {
        return [
            ['label_en' => 'Residential land', 'label_ar' => 'أرض سكنية'],
            ['label_en' => 'Commercial land', 'label_ar' => 'أرض تجارية'],
            ['label_en' => 'Agricultural land', 'label_ar' => 'أرض زراعية'],
            ['label_en' => 'Apartment', 'label_ar' => 'شقة'],
            ['label_en' => 'Premium apartment', 'label_ar' => 'شقة مميزة'],
            ['label_en' => 'Luxury apartment', 'label_ar' => 'شقة فخمة'],
            ['label_en' => 'Duplex apartment', 'label_ar' => 'شقة دورين'],
            ['label_en' => 'Villa', 'label_ar' => 'فيلا'],
            ['label_en' => 'Premium villa', 'label_ar' => 'فيلا مميزة'],
            ['label_en' => 'Luxury villa', 'label_ar' => 'فيلا فخمة'],
            ['label_en' => 'Townhouse', 'label_ar' => 'تاون هاوس'],
            ['label_en' => 'Studio', 'label_ar' => 'استديو'],
            ['label_en' => 'Floor unit', 'label_ar' => 'دور'],
            ['label_en' => 'Duplex', 'label_ar' => 'دبلكس'],
            ['label_en' => 'Residential building', 'label_ar' => 'عمارة سكنية'],
            ['label_en' => 'Commercial building', 'label_ar' => 'عمارة تجارية'],
            ['label_en' => 'Palace', 'label_ar' => 'قصر'],
            ['label_en' => 'Room', 'label_ar' => 'غرفة'],
            ['label_en' => 'Rest house', 'label_ar' => 'استراحة'],
            ['label_en' => 'Premium rest house', 'label_ar' => 'استراحة مميزة'],
            ['label_en' => 'Traditional house', 'label_ar' => 'بيت شعبي'],
            ['label_en' => 'Office', 'label_ar' => 'مكتب'],
            ['label_en' => 'Warehouse', 'label_ar' => 'مستودع'],
            ['label_en' => 'Farm', 'label_ar' => 'مزرعة'],
            ['label_en' => 'Chalet', 'label_ar' => 'شاليه'],
            ['label_en' => 'Workshop', 'label_ar' => 'ورشة'],
            ['label_en' => 'Shop', 'label_ar' => 'محل'],
            ['label_en' => 'Showroom', 'label_ar' => 'معرض'],
            ['label_en' => 'Exhibition hall', 'label_ar' => 'صالة عرض'],
            ['label_en' => 'Corner plot', 'label_ar' => 'رأس بلك'],
            ['label_en' => 'Factory', 'label_ar' => 'مصنع'],
            ['label_en' => 'Hotel', 'label_ar' => 'فندق'],
            ['label_en' => 'Private school', 'label_ar' => 'مدرسة أهلية'],
            ['label_en' => 'Private health center', 'label_ar' => 'مركز صحي أهلي'],
            ['label_en' => 'Gas station', 'label_ar' => 'محطة بنزين'],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_en' => 'Annual Rental Property',
                'name_ar' => 'عقار للايجار السنوي',
                'is_active' => true,
            ],
            [
                'name_en' => 'Projects',
                'name_ar' => 'المشاريع',
                'is_active' => true,
            ],
            [
                'name_en' => 'Car Plates',
                'name_ar' => 'لوحات السيارات',
                'is_active' => true,
            ],
            [
                'name_en' => 'Furniture & Accessories',
                'name_ar' => 'أثاث و كماليات',
                'is_active' => true,
            ],
            [
                'name_en' => 'Property for Sale',
                'name_ar' => 'عقار للبيع',
                'is_active' => true,
            ],
            [
                'name_en' => 'Property for Rent (Daily - Monthly)',
                'name_ar' => 'عقار للإيجار (يومي - شهري)',
                'is_active' => true,
            ],
            [
                'name_en' => 'Cars',
                'name_ar' => 'السيارات',
                'is_active' => true,
            ],
            [
                'name_en' => 'Devices & Equipment',
                'name_ar' => 'أجهزة و معدات',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name_en' => $category['name_en']],
                [
                    'name_ar' => $category['name_ar'],
                    'is_active' => $category['is_active'],
                ]
            );
        }

        $propertyTypes = $this->propertyTypes();
        Category::whereIn('name_en', ['Annual Rental Property', 'Property for Sale'])->update(['types' => $propertyTypes]);

        $projectTypes = $this->projectTypes();
        Category::where('name_en', 'Projects')->update(['types' => $projectTypes]);
    }
}
