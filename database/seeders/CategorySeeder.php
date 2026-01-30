<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
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
    }
}
