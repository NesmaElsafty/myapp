<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = City::all();

        if ($cities->isEmpty()) {
            $this->command->warn('No cities found. Please run CitySeeder first.');
            return;
        }

        $regions = [
            ['name_en' => 'North Riyadh', 'name_ar' => 'شمال الرياض', 'city_name' => 'Riyadh'],
            ['name_en' => 'East Riyadh', 'name_ar' => 'شرق الرياض', 'city_name' => 'Riyadh'],
            ['name_en' => 'South Riyadh', 'name_ar' => 'جنوب الرياض', 'city_name' => 'Riyadh'],

            ['name_en' => 'North Jeddah', 'name_ar' => 'شمال جدة', 'city_name' => 'Jeddah'],
            ['name_en' => 'Central Jeddah', 'name_ar' => 'وسط جدة', 'city_name' => 'Jeddah'],
            ['name_en' => 'South Jeddah', 'name_ar' => 'جنوب جدة', 'city_name' => 'Jeddah'],

            ['name_en' => 'Central Mecca', 'name_ar' => 'وسط مكة', 'city_name' => 'Mecca'],
            ['name_en' => 'East Mecca', 'name_ar' => 'شرق مكة', 'city_name' => 'Mecca'],
            ['name_en' => 'West Mecca', 'name_ar' => 'غرب مكة', 'city_name' => 'Mecca'],

            ['name_en' => 'Central Medina', 'name_ar' => 'وسط المدينة', 'city_name' => 'Medina'],
            ['name_en' => 'North Medina', 'name_ar' => 'شمال المدينة', 'city_name' => 'Medina'],

            ['name_en' => 'Central Dammam', 'name_ar' => 'وسط الدمام', 'city_name' => 'Dammam'],
            ['name_en' => 'West Dammam', 'name_ar' => 'غرب الدمام', 'city_name' => 'Dammam'],

            ['name_en' => 'North Khobar', 'name_ar' => 'شمال الخبر', 'city_name' => 'Khobar'],
            ['name_en' => 'South Khobar', 'name_ar' => 'جنوب الخبر', 'city_name' => 'Khobar'],

            ['name_en' => 'Central Taif', 'name_ar' => 'وسط الطائف', 'city_name' => 'Taif'],
            ['name_en' => 'North Taif', 'name_ar' => 'شمال الطائف', 'city_name' => 'Taif'],

            ['name_en' => 'Central Abha', 'name_ar' => 'وسط أبها', 'city_name' => 'Abha'],
            ['name_en' => 'North Abha', 'name_ar' => 'شمال أبها', 'city_name' => 'Abha'],

            ['name_en' => 'Central Tabuk', 'name_ar' => 'وسط تبوك', 'city_name' => 'Tabuk'],
            ['name_en' => 'North Tabuk', 'name_ar' => 'شمال تبوك', 'city_name' => 'Tabuk'],

            ['name_en' => 'Central Buraidah', 'name_ar' => 'وسط بريدة', 'city_name' => 'Buraidah'],
            ['name_en' => 'East Buraidah', 'name_ar' => 'شرق بريدة', 'city_name' => 'Buraidah'],

            ['name_en' => 'Central Hail', 'name_ar' => 'وسط حائل', 'city_name' => 'Hail'],
            ['name_en' => 'North Hail', 'name_ar' => 'شمال حائل', 'city_name' => 'Hail'],

            ['name_en' => 'Central Jazan', 'name_ar' => 'وسط جازان', 'city_name' => 'Jazan'],
            ['name_en' => 'North Jazan', 'name_ar' => 'شمال جازان', 'city_name' => 'Jazan'],

            ['name_en' => 'Central Najran', 'name_ar' => 'وسط نجران', 'city_name' => 'Najran'],
            ['name_en' => 'North Najran', 'name_ar' => 'شمال نجران', 'city_name' => 'Najran'],
        ];

        foreach ($regions as $regionData) {
            $city = $cities->firstWhere('name_en', $regionData['city_name']);
            
            if ($city) {
                Region::updateOrCreate(
                    [
                        'name_en' => $regionData['name_en'],
                        'city_id' => $city->id,
                    ],
                    [
                        'name_ar' => $regionData['name_ar'],
                        'district_en' => null,
                        'district_ar' => null,
                    ]
                );
            }
        }
    }
}
