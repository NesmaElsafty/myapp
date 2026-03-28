<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed permissions and roles first
        $this->call([
            PermissionsSeeder::class,
            RoleSeeder::class,
            CitySeeder::class,
            RegionSeeder::class, // Must be after CitySeeder
            CarBrandsAndModelsSeeder::class,
            ContactInfoSeeder::class,
            SocialMediaSeeder::class,
            AdSeeder::class,
            BlogSeeder::class,
            FaqSeeder::class,
            TermSeeder::class,
            SupportSeeder::class,
            InquirySeeder::class,
            NotificationSeeder::class,
            OriginSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            IndividualSeeder::class,
            AlertSeeder::class,
            CategorySeeder::class,
            ScreenSeeder::class,
            InputAnnualRentalPropertySeeder::class,
            InputProjectsSeeder::class,
            InputCarPlatesSeeder::class,
            InputFurnitureAccessoriesSeeder::class,
            InputPropertyForSaleSeeder::class,
            InputPropertyForRentDailyMonthlySeeder::class,
            InputCarsSeeder::class,
            InputDevicesEquipmentSeeder::class,
            InputOtherCategoriesSeeder::class,
            PageSeeder::class,
            ContentSeeder::class,
            SystemSettingSeeder::class,
            ItemSeeder::class,
            PlanSeeder::class,
            SubscriptionSeeder::class,
            PromotionSeeder::class,
        ]);
    }
}
