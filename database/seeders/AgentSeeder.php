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
                'f_name' => 'خالد',
                'l_name' => 'العتيبي',
                'email' => 'agent@example.com',
                'phone' => '0501234571',
                'location' => 'الخبر',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'type' => 'agent',
                'origin_id' => $origin->id,
                'national_id' => null,
                'commercial_number' => null,
                'specialty_areas' => ['عقارات سكنية', 'سيارات'],
                'major' => 'تسويق',
                'summary' => 'وكيل عقاري معتمد مع خبرة في المبيعات والتسويق. متخصص في العقارات السكنية والمركبات.',
                'bank_name' => 'بنك الراجحي',
                'bank_account_number' => '987654321098',
                'bank_account_iban' => 'SA0390000000608010167519',
                'bank_account_address' => 'الخبر، حي الشاطئ',
                'language' => 'ar',
            ]);

            // Create additional agent users
            $origins = User::where('type', 'origin')->pluck('id');
            for ($i = 0; $i < 20; $i++) {
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
