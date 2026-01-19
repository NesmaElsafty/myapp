<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $roles = Role::all();
        
        User::create([
            'f_name' => 'أحمد',
            'l_name' => 'السالم',
            'email' => 'admin@example.com',
            'phone' => '0501234568',
            'location' => 'الرياض',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'type' => 'admin',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => null,
            'role_id' => $roles->isNotEmpty() ? $roles->random()->id : null,
        ]);

        // Create additional admin users
        $adminUsers = User::factory()->count(20)->create([
            'type' => 'admin',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => null,
        ]);

        // Assign random roles to admin users
        if ($roles->isNotEmpty()) {
            foreach ($adminUsers as $adminUser) {
                $adminUser->update([
                    'role_id' => $roles->random()->id,
                ]);
            }
        }
    }
}
