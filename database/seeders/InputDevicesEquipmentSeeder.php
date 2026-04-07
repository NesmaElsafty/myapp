<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class InputDevicesEquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::find(8);
        if (! $category) {
            return;
        }

        // create sub categories for the category
        $subCategories = [
            [
                'name_en' => 'Mobile Phones',
                'name_ar' => 'جوال',
            ],
            [
                'name_en' => 'Computers',
                'name_ar' => 'كمبيوتر',
            ],
            [
                'name_en' => 'Televisions',
                'name_ar' => 'تلفزيون',
            ],
            [
                'name_en' => 'Screens',
                'name_ar' => 'شاشة',
            ],
            [
                'name_en' => 'Printers',
                'name_ar' => 'طابعة',
            ],
            [
                'name_en' => 'Mobile Accessories',
                'name_ar' => 'اكسسوار جوال',
            ],
            [
                'name_en' => 'Headphones',
                'name_ar' => 'سماعة',
            ],
            [
                'name_en' => 'Hair Dryer',
                'name_ar' => 'استشوار',
            ],
            [
                'name_en' => 'Chargers',
                'name_ar' => 'شاحن',
            ],
            [
                'name_en' => 'Sports Devices',
                'name_ar' => 'جهاز رياضي',
            ],
            [
                'name_en' => 'Ovens and Cooking Devices',
                'name_ar' => 'فرن وجهاز طبخ',
            ],
            [
                'name_en' => 'Window AC',
                'name_ar' => 'مكيف شباك',
            ],
            [
                'name_en' => 'Split AC',
                'name_ar' => 'مكيف سبليت',
            ],
            [
                'name_en' => 'Heaters',
                'name_ar' => 'دفايه',
            ],
            [
                'name_en' => 'Irons',
                'name_ar' => 'مكواه',
            ],
            [
                'name_en' => 'Washing Machines',
                'name_ar' => 'غسالة ملابس',
            ],
            [
                'name_en' => 'Dishwashers',
                'name_ar' => 'غسالة صحون',
            ],
            [
                'name_en' => 'Refrigerators',
                'name_ar' => 'ثلاجة',
            ],
            [
                'name_en' => 'Freezers',
                'name_ar' => 'فريزر',
            ],
            [
                'name_en' => 'Water Dispensers',
                'name_ar' => 'برادة',
            ],
            [
                'name_en' => 'Personal Care Devices',
                'name_ar' => 'جهاز عناية شخصية',
            ],
            [
                'name_en' => 'Lighting',
                'name_ar' => 'إنارة',
            ],
            [
                'name_en' => 'Bicycles',
                'name_ar' => 'دراجة هوائية',
            ],
            [
                'name_en' => 'Motorcycles',
                'name_ar' => 'دباب',
            ],
            [
                'name_en' => 'Home Cleaning Devices',
                'name_ar' => 'جهاز تنظيف منزلي',
            ],
            [
                'name_en' => 'Home Cleaning Equipment',
                'name_ar' => 'معدة تنظيف منزلي',
            ],
            [
                'name_en' => 'Car Accessories',
                'name_ar' => 'اكسسوار سيارة',
            ],
            [
                'name_en' => 'Tools and Equipment',
                'name_ar' => 'عدد والات',
            ],
            [
                'name_en' => 'Other',
                'name_ar' => 'اخرى',
            ],
        ];

        foreach ($subCategories as $subCategory) {
            $existing = Category::where('parent_id', 8)
                ->where(function ($query) use ($subCategory) {
                    $query->where('name_en', $subCategory['name_en'])
                        ->orWhere('name_ar', $subCategory['name_ar']);
                })
                ->first();

            if ($existing) {
                $existing->update([
                    'name_en' => $existing->name_en ?: $subCategory['name_en'],
                    'name_ar' => $existing->name_ar ?: $subCategory['name_ar'],
                    'is_active' => true,
                ]);
                continue;
            }

            Category::create([
                'name_en' => $subCategory['name_en'],
                'name_ar' => $subCategory['name_ar'],
                'parent_id' => 8,
                'is_active' => true,
            ]);
        }
    }
}
