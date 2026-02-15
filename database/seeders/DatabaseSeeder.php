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
        ]);

        // Seed cities and regions
        $this->call([
            CitySeeder::class,
            RegionSeeder::class, // Must be after CitySeeder
        ]);

        // Seed contact info and social media
        $this->call([
            ContactInfoSeeder::class,
            SocialMediaSeeder::class,
        ]);

        // Seed ads, blogs, FAQs, Terms, Supports, Inquiries, Notifications, and Plans
        $this->call([
            AdSeeder::class,
            BlogSeeder::class,
            FaqSeeder::class,
            TermSeeder::class,
            SupportSeeder::class,
            InquirySeeder::class,
            NotificationSeeder::class,
            PlanSeeder::class,
        ]);

        // Seed users in order: origin first (needed for agents), then others
        $this->call([
            OriginSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            IndividualSeeder::class,
            AgentSeeder::class, // Must be after OriginSeeder
        ]);

        // Seed alerts (must be after users)
        $this->call([
            AlertSeeder::class,
        ]);

        // Seed features
        $this->call([
            FeatureSeeder::class,
        ]);

        // Seed categories
        $this->call([
            CategorySeeder::class,
        ]);

        // Seed screens (must be after categories)
        $this->call([
            ScreenSeeder::class,
        ]);

        // Seed inputs (must be after screens)
        $this->call([
            InputSeeder::class,
        ]);

        // Seed system settings
        $this->call([
            SystemSettingSeeder::class,
        ]);
    }
}
