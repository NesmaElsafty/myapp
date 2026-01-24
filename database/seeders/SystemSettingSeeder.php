<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SystemSetting;
class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $seededSettings = [
            [
                'key' => 'platform_insights',
                'value' => 'platform', //platform || app
            ],
            [
                'key' => 'platform_status',
                'value' => 'active', //active || inactive
            ],
            [
                'key' => 'required_points',
                'value' => 100, //100 points
            ],
            [
                'key' => 'app_default_logo',
                'value' => 'file'
            ],
            [
                'key' => 'post_default_image',
                'value' => 'file'
            ],
            [
                'key' => 'app_default_background',
                'value' => 'file'
            ],
            [
                'key' => 'platform_fees',
                'value' => '10'
            ],
            [
                'key' => 'earning_percentage',
                'value' => '10'
            ],
          
        ];
        foreach ($seededSettings as $setting) {
            SystemSetting::create($setting);
        }
        
    }
}
