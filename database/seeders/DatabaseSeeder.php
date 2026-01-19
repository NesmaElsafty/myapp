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
