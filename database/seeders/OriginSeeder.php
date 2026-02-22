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
        // Backfill existing origin user if specialty_areas/major/summary are empty
        $existingOrigin = User::where('email', 'origin@example.com')->where('type', 'origin')->first();
        if ($existingOrigin && (empty($existingOrigin->specialty_areas) || $existingOrigin->major === null || $existingOrigin->summary === null || $existingOrigin->bank_name === null)) {
            $existingOrigin->update([
                'specialty_areas' => ['عقارات', 'عقارات تجارية'],
                'major' => 'إدارة أعمال',
                'summary' => 'شركة متخصصة في التسويق العقاري والتطوير. نقدم خدمات شاملة للأفراد والشركات في مجال العقارات التجارية والسكنية.',
                'bank_name' => 'البنك الأهلي',
                'bank_account_number' => '123456789012',
                'bank_account_iban' => 'SA0380000000608010167519',
                'bank_account_address' => 'الدمام، شارع الملك فهد',
                'language' => 'ar',
            ]);
        }

        if ($existingOrigin) {
            return; // already have the main origin user
        }

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
            'specialty_areas' => ['عقارات', 'عقارات تجارية'],
            'major' => 'إدارة أعمال',
            'summary' => 'شركة متخصصة في التسويق العقاري والتطوير. نقدم خدمات شاملة للأفراد والشركات في مجال العقارات التجارية والسكنية.',
            'bank_name' => 'البنك الأهلي',
            'bank_account_number' => '123456789012',
            'bank_account_iban' => 'SA0380000000608010167519',
            'bank_account_address' => 'الدمام، شارع الملك فهد',
            'language' => 'ar',
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
