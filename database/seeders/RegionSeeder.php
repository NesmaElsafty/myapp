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
            // Riyadh regions
            [
                'name_en' => 'Al Olaya',
                'name_ar' => 'العليا',
                'district_en' => 'Central',
                'district_ar' => 'وسط',
                'city_name' => 'Riyadh',
            ],
            [
                'name_en' => 'Al Malaz',
                'name_ar' => 'الملك فهد',
                'district_en' => 'Central',
                'district_ar' => 'وسط',
                'city_name' => 'Riyadh',
            ],
            [
                'name_en' => 'Al Naseem',
                'name_ar' => 'النسيم',
                'district_en' => 'East',
                'district_ar' => 'شرق',
                'city_name' => 'Riyadh',
            ],
            // Jeddah regions
            [
                'name_en' => 'Al Balad',
                'name_ar' => 'البلد',
                'district_en' => 'Historic',
                'district_ar' => 'تاريخي',
                'city_name' => 'Jeddah',
            ],
            [
                'name_en' => 'Al Hamra',
                'name_ar' => 'الحمراء',
                'district_en' => 'North',
                'district_ar' => 'شمال',
                'city_name' => 'Jeddah',
            ],
            [
                'name_en' => 'Al Rawdah',
                'name_ar' => 'الروضة',
                'district_en' => 'South',
                'district_ar' => 'جنوب',
                'city_name' => 'Jeddah',
            ],
            // Mecca regions
            [
                'name_en' => 'Al Haram',
                'name_ar' => 'الحرم',
                'district_en' => 'Central',
                'district_ar' => 'وسط',
                'city_name' => 'Mecca',
            ],
            [
                'name_en' => 'Al Aziziyah',
                'name_ar' => 'العزيزية',
                'district_en' => 'East',
                'district_ar' => 'شرق',
                'city_name' => 'Mecca',
            ],
            // Dammam regions
            [
                'name_en' => 'Al Faisaliyah',
                'name_ar' => 'الفيصلية',
                'district_en' => 'Central',
                'district_ar' => 'وسط',
                'city_name' => 'Dammam',
            ],
            [
                'name_en' => 'Al Corniche',
                'name_ar' => 'الكورنيش',
                'district_en' => 'Coastal',
                'district_ar' => 'ساحلي',
                'city_name' => 'Dammam',
            ],
        ];

        foreach ($regions as $regionData) {
            $city = $cities->firstWhere('name_en', $regionData['city_name']);
            
            if ($city) {
                Region::create([
                    'name_en' => $regionData['name_en'],
                    'name_ar' => $regionData['name_ar'],
                    'district_en' => $regionData['district_en'],
                    'district_ar' => $regionData['district_ar'],
                    'city_id' => $city->id,
                ]);
            }
        }
    }
}
