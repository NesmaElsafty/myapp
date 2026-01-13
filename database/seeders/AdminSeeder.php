<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'f_name' => 'Admin',
            'l_name' => 'User',
            'email' => 'admin@example.com',
            'phone' => '1234567891',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'type' => 'admin',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => null,
        ]);

        // Create additional admin users
        User::factory()->count(2)->create([
            'type' => 'admin',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => null,
        ]);
    }
}
