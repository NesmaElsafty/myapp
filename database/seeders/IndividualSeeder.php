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
            'f_name' => 'فاطمة',
            'l_name' => 'الغامدي',
            'email' => 'individual@example.com',
            'phone' => '0501234569',
            'location' => 'جدة',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'type' => 'individual',
            'origin_id' => null,
            'national_id' => '12345678901234',
            'commercial_number' => null,
            'specialty_areas' => ['عقارات', 'أثاث'],
            'major' => 'هندسة',
            'summary' => 'مهندسة معمارية مهتمة بالعقارات والتأثيث. أبحث عن فرص استثمارية مناسبة.',
            'bank_name' => 'البنك السعودي الفرنسي',
            'bank_account_number' => '555566667777',
            'bank_account_iban' => 'SA0330000000608010167519',
            'bank_account_address' => 'جدة، حي الروضة',
            'language' => 'ar',
        ]);

        // Create additional individual users
        for ($i = 0; $i < 20; $i++) {
            User::factory()->create([
                'type' => 'individual',
                'origin_id' => null,
                'national_id' => fake()->numerify('##############'),
                'commercial_number' => null,
            ]);
        }
    }
}
