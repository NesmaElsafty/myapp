<?php

namespace Database\Seeders;

use App\Models\Role;
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
            'specialty_areas' => [],
            'major' => null,
            'summary' => null,
            'bank_name' => null,
            'bank_account_number' => null,
            'bank_account_iban' => null,
            'bank_account_address' => null,
            'language' => 'ar',
        ]);

        // Create additional regular users
        User::factory()->count(20)->create([
            'type' => 'user',
            'origin_id' => null,
            'national_id' => null,
            'commercial_number' => null,
        ]);

        // Assign random roles to admin users
        $roles = Role::all();
        if ($roles->isNotEmpty()) {
            $adminUsers = User::where('type', 'admin')->get();
            foreach ($adminUsers as $adminUser) {
                $adminUser->update([
                    'role_id' => $roles->random()->id,
                ]);
            }
        }
    }
}
