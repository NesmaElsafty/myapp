<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Region;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districtMap = [
            'North Riyadh' => [
                ['name_en' => 'Al Yasmin', 'name_ar' => 'الياسمين'],
                ['name_en' => 'Al Aqiq', 'name_ar' => 'العقيق'],
                ['name_en' => 'Al Sahafah', 'name_ar' => 'الصحافة'],
            ],
            'East Riyadh' => [
                ['name_en' => 'Al Rawdah', 'name_ar' => 'الروضة'],
                ['name_en' => 'Al Nahdah', 'name_ar' => 'النهضة'],
                ['name_en' => 'Ishbiliyah', 'name_ar' => 'إشبيلية'],
            ],
            'South Riyadh' => [
                ['name_en' => 'Al Shifa', 'name_ar' => 'الشفا'],
                ['name_en' => 'Namar', 'name_ar' => 'نمار'],
                ['name_en' => 'Al Aziziyah', 'name_ar' => 'العزيزية'],
            ],
            'North Jeddah' => [
                ['name_en' => 'Al Zahra', 'name_ar' => 'الزهراء'],
                ['name_en' => 'Al Shati', 'name_ar' => 'الشاطئ'],
                ['name_en' => 'Obhur', 'name_ar' => 'أبحر'],
            ],
            'Central Jeddah' => [
                ['name_en' => 'Al Rawdah', 'name_ar' => 'الروضة'],
                ['name_en' => 'Al Faisaliyah', 'name_ar' => 'الفيصلية'],
            ],
            'South Jeddah' => [
                ['name_en' => 'Al Waziriyah', 'name_ar' => 'الوزيرية'],
                ['name_en' => 'Al Kandrah', 'name_ar' => 'الكندرة'],
            ],
        ];

        foreach ($districtMap as $regionName => $districts) {
            $region = Region::where('name_en', $regionName)->first();
            if (!$region) {
                continue;
            }

            foreach ($districts as $districtData) {
                District::updateOrCreate(
                    [
                        'region_id' => $region->id,
                        'name_en' => $districtData['name_en'],
                    ],
                    [
                        'name_ar' => $districtData['name_ar'],
                    ]
                );
            }
        }
    }
}
