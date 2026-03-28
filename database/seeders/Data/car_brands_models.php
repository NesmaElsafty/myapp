<?php

/**
 * Merged car brand + model definitions for {@see CarBrandsAndModelsSeeder}.
 *
 * @return array<int, array{name_en: string, name_ar: string, models: list<array{name_en: string, name_ar: string}>}>
 */
return array_merge(
    require __DIR__.'/car_brands_models_1.php',
    require __DIR__.'/car_brands_models_2.php',
    require __DIR__.'/car_brands_models_3.php',
);
