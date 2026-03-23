<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $promotions = [
            [
                'title_en' => 'Gold',
                'title_ar' => 'ذهبي',
                'description_en' => 'Gold promotion',
                'description_ar' => 'الترويج الذهبي',
                'price' => 100,
            ],
            [
                'title_en' => 'Silver',
                'title_ar' => 'فضي',
                'description_en' => 'Silver promotion',
                'description_ar' => 'الترويج الفضي',
                'price' => 50,
            ],
        ];
        foreach ($promotions as $promotion) {
            Promotion::create($promotion);
        }
    }
}
