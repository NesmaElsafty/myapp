<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\City;
use App\Models\Item;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        $user = User::whereIn('type', ['individual', 'origin'])->inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();
        $city = City::inRandomOrder()->first();
        $region = Region::inRandomOrder()->first();

        return [
            'user_id' => $user?->id ?? User::factory(),
            'category_id' => $category?->id ?? Category::factory(),
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'price' => (string) fake()->numberBetween(1000, 100000),
            'price_after_discount' => null,
            'location' => $city?->name_ar ?? 'الرياض',
            'lat' => fake()->latitude(24.0, 26.0),
            'long' => fake()->longitude(46.0, 50.0),
            'available_datetime' => now()->addDays(fake()->numberBetween(0, 30)),
            'payment_platform' => fake()->randomElement(['cash', 'installment']),
            'city_id' => $city?->id ?? null,
            'region_id' => $region?->id ?? null,
            'district' => fake()->streetName(),
            'street' => fake()->streetAddress(),
            'is_active' => true,
            'contact_name' => $user?->f_name . ' ' . $user?->l_name,
            'contact_phone' => $user?->phone ?? fake()->numerify('05#######'),
            'contact_email' => $user?->email ?? fake()->safeEmail(),
            'contact_type' => fake()->randomElement(['whatsapp', 'phone', 'email']),
            'appear_in_item' => true,
        ];
    }
}

