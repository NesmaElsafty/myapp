<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get an origin user to reference
        $origin = User::where('type', 'origin')->first();

        if ($origin) {
            User::create([
                'f_name' => 'Agent',
                'l_name' => 'One',
                'email' => 'agent@example.com',
                'phone' => '1234567894',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'type' => 'agent',
                'origin_id' => $origin->id,
                'national_id' => null,
                'commercial_number' => null,
            ]);

            // Create additional agent users
            $origins = User::where('type', 'origin')->pluck('id');
            for ($i = 0; $i < 5; $i++) {
                User::factory()->create([
                    'type' => 'agent',
                    'origin_id' => $origins->random(),
                    'national_id' => null,
                    'commercial_number' => null,
                ]);
            }
        }
    }
}
