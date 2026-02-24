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
        $originIds = User::where('type', 'origin')->pluck('id')->toArray();

        User::create([
            'f_name' => 'فاطمة',
            'l_name' => 'الغامدي',
            'email' => 'individual@example.com',
            'phone' => '0501234569',
            'location' => 'جدة',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'type' => 'individual',
            'origin_id' => $originIds[array_rand($originIds)] ?? null,
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

        // Create additional individual users; assign origin_id for some
        for ($i = 0; $i < 20; $i++) {
            $originId = $originIds !== [] && fake()->boolean(60)
                ? $originIds[array_rand($originIds)]
                : null;

            User::factory()->create([
                'type' => 'individual',
                'origin_id' => $originId,
                'national_id' => fake()->numerify('##############'),
                'commercial_number' => null,
            ]);
        }
    }
}
