<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\District;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\District>
 */
class DistrictFactory extends Factory
{
    protected $model = District::class;

    public function definition(): array
    {
        $regionId = Region::query()->inRandomOrder()->value('id');

        if (!$regionId) {
            $cityId = City::query()->inRandomOrder()->value('id');

            if (!$cityId) {
                $cityId = City::create([
                    'name_en' => fake()->city(),
                    'name_ar' => fake()->city(),
                ])->id;
            }

            $regionId = Region::create([
                'name_en' => fake()->streetName(),
                'name_ar' => fake()->streetName(),
                'city_id' => $cityId,
            ])->id;
        }

        return [
            'name_en' => fake()->streetName(),
            'name_ar' => fake()->streetName(),
            'region_id' => $regionId,
        ];
    }
}
