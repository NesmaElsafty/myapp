<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name_en' => 'Riyadh', 'name_ar' => 'الرياض'],
            ['name_en' => 'Jeddah', 'name_ar' => 'جدة'],
            ['name_en' => 'Mecca', 'name_ar' => 'مكة المكرمة'],
            ['name_en' => 'Medina', 'name_ar' => 'المدينة المنورة'],
            ['name_en' => 'Dammam', 'name_ar' => 'الدمام'],
            ['name_en' => 'Khobar', 'name_ar' => 'الخبر'],
            ['name_en' => 'Taif', 'name_ar' => 'الطائف'],
            ['name_en' => 'Abha', 'name_ar' => 'أبها'],
            ['name_en' => 'Tabuk', 'name_ar' => 'تبوك'],
            ['name_en' => 'Buraidah', 'name_ar' => 'بريدة'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
