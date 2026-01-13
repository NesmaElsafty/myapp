<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'f_name' => 'Origin',
            'l_name' => 'Company',
            'email' => 'origin@example.com',
            'phone' => '1234567893',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'type' => 'origin',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => 'CR123456789',
        ]);

        // Create additional origin users
        for ($i = 0; $i < 3; $i++) {
            User::factory()->create([
                'type' => 'origin',
                'origin_id' => null,
                'national_id' => null,
                'commercial_number' => 'CR' . fake()->numerify('#########'),
            ]);
        }
    }
}
