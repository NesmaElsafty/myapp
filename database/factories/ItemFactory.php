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

        $status = fake()->randomElement([
            'draft',
            'pending_approval',
            'approved',
            'rejected',
            'in_progress',
            'soldout',
            'expired',
        ]);

        $needLicence = fake()->boolean(20);
        $isPromoted = fake()->boolean(15);

        $discount = fake()->optional(0.4)->passthrough((string) fake()->numberBetween(5, 30));
        $basePrice = fake()->numberBetween(1000, 100000);
        $priceAfterDiscount = null;
        if ($discount !== null) {
            $priceAfterDiscount = (string) (int) round($basePrice * (1 - (int) $discount / 100));
        }

        return [
            'user_id' => $user?->id ?? User::factory(),
            'category_id' => $category?->id ?? Category::factory(),
            'name' => fake()->sentence(3),
            'description' => fake()->sentence(12),
            'price' => (string) $basePrice,
            'discount_percentage' => $discount,
            'price_after_discount' => $priceAfterDiscount,
            'location' => $city?->name_ar ?? 'الرياض',
            'lat' => (string) fake()->latitude(24.0, 26.0),
            'long' => (string) fake()->longitude(46.0, 50.0),
            'available_datetime' => now()->addDays(fake()->numberBetween(0, 30))->format('Y-m-d H:i:s'),
            'payment_platform' => fake()->randomElement(['cash', 'installment']),
            'city_id' => $city?->id ?? null,
            'region_id' => $region?->id ?? null,
            'payment_options' => fake()->optional(0.6)->passthrough(
                fake()->randomElement([
                    ['cash'],
                    ['installment'],
                    ['cash', 'installment'],
                ])
            ),
            'district' => fake()->streetName(),
            'street' => fake()->streetAddress(),
            'is_active' => true,
            'contact_name' => $user
                ? trim(($user->f_name ?? '').' '.($user->l_name ?? '')) ?: fake()->name()
                : fake()->name(),
            'contact_phone' => $user?->phone ?? fake()->numerify('05#######'),
            'contact_email' => $user?->email ?? fake()->safeEmail(),
            'contact_type' => fake()->randomElement([
                ['whatsapp'],
                ['phone'],
                ['email'],
                ['whatsapp', 'phone'],
            ]),
            'is_appeared_in_item' => fake()->boolean(70),
            'status' => $status,
            'published_at' => in_array($status, ['approved', 'in_progress', 'soldout', 'expired'], true)
                ? fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d H:i:s')
                : null,
            'need_licence' => $needLicence,
            'val_licence_number' => $needLicence ? fake()->numerify('VAL-########') : null,
            'tourism_licence_number' => $needLicence && fake()->boolean(40)
                ? fake()->numerify('TL-########')
                : null,
            'visit_datetimes' => fake()->optional(0.25)->passthrough([
                now()->addDays(1)->format('Y-m-d H:i:s'),
                now()->addDays(3)->format('Y-m-d H:i:s'),
            ]),
            'is_promoted' => $isPromoted,
            'promoted_until' => $isPromoted
                ? now()->addDays(fake()->numberBetween(1, 14))->format('Y-m-d H:i:s')
                : null,
            'promotion_type' => $isPromoted ? fake()->randomElement(['golden', 'silver']) : null,
        ];
    }
}
