<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['name_en' => 'Unlimited posts', 'name_ar' => 'منشورات غير محدودة'],
            ['name_en' => 'Priority support', 'name_ar' => 'دعم ذو أولوية'],
            ['name_en' => 'Analytics dashboard', 'name_ar' => 'لوحة تحليلات'],
            ['name_en' => 'Custom branding', 'name_ar' => 'علامة تجارية مخصصة'],
            ['name_en' => 'API access', 'name_ar' => 'وصول API'],
            ['name_en' => 'Export data', 'name_ar' => 'تصدير البيانات'],
            ['name_en' => 'Multi-user accounts', 'name_ar' => 'حسابات متعددة المستخدمين'],
            ['name_en' => 'Advanced filters', 'name_ar' => 'فلاتر متقدمة'],
        ];

        foreach ($features as $feature) {
            Feature::firstOrCreate(
                ['name_en' => $feature['name_en']],
                ['name_ar' => $feature['name_ar']]
            );
        }
    }
}
