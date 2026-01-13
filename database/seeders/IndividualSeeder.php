<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class IndividualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'f_name' => 'Jane',
            'l_name' => 'Smith',
            'email' => 'individual@example.com',
            'phone' => '1234567892',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'type' => 'individual',
            'origin_id' => null,
            'national_id' => '12345678901234',
            'commercial_number' => null,
        ]);

        // Create additional individual users
        for ($i = 0; $i < 5; $i++) {
            User::factory()->create([
                'type' => 'individual',
                'origin_id' => null,
                'national_id' => fake()->numerify('##############'),
                'commercial_number' => null,
            ]);
        }
    }
}
