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

        // Seed ads
        $this->call([
            AdSeeder::class,
        ]);

        // Seed users in order: origin first (needed for agents), then others
        $this->call([
            OriginSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            IndividualSeeder::class,
            AgentSeeder::class, // Must be after OriginSeeder
        ]);
    }
}
