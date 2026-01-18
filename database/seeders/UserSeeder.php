<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'f_name' => 'محمد',
            'l_name' => 'الخالدي',
            'email' => 'user@example.com',
            'phone' => '0501234567',
            'location' => 'الرياض',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'type' => 'user',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => null,
        ]);

        // Create additional regular users
        User::factory()->count(20)->create([
            'type' => 'user',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => null,
        ]);
    }
}
