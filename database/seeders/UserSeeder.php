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
            'f_name' => 'John',
            'l_name' => 'Doe',
            'email' => 'user@example.com',
            'phone' => '1234567890',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'type' => 'user',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => null,
        ]);

        // Create additional regular users
        User::factory()->count(5)->create([
            'type' => 'user',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => null,
        ]);
    }
}
