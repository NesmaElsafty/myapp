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
            'f_name' => 'شركة',
            'l_name' => 'النجاح',
            'email' => 'origin@example.com',
            'phone' => '0501234570',
            'location' => 'الدمام',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'type' => 'origin',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => 'CR123456789',
        ]);

        // Create additional origin users
        for ($i = 0; $i < 20; $i++) {
            User::factory()->create([
                'type' => 'origin',
                'origin_id' => null,
                'national_id' => null,
                'commercial_number' => 'CR' . fake()->numerify('#########'),
            ]);
        }
    }
}
