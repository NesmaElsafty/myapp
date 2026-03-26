<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InputSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            InputAnnualRentalPropertySeeder::class,
            InputProjectsSeeder::class,
            InputCarPlatesSeeder::class,
            InputFurnitureAccessoriesSeeder::class,
            InputPropertyForSaleSeeder::class,
            InputPropertyForRentDailyMonthlySeeder::class,
            InputCarsSeeder::class,
            InputDevicesEquipmentSeeder::class,
            InputOtherCategoriesSeeder::class,
        ]);
    }
}
