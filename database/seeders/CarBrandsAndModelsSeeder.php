<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarBrandsAndModelsSeeder extends Seeder
{
    public function run(): void
    {
        $brands = require __DIR__.'/Data/car_brands_models.php';

        foreach ($brands as $brandData) {
            $brand = CarBrand::query()->firstOrCreate(
                ['name_en' => $brandData['name_en']],
                ['name_ar' => $brandData['name_ar']]
            );

            foreach ($brandData['models'] as $modelData) {
                CarModel::query()->firstOrCreate(
                    [
                        'car_brand_id' => $brand->id,
                        'name_en' => $modelData['name_en'],
                    ],
                    ['name_ar' => $modelData['name_ar']]
                );
            }
        }
    }
}
