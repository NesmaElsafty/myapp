<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create replied inquiries
        Inquiry::factory()
            ->count(5)
            ->replied()
            ->create();

        // Create not replied inquiries
        Inquiry::factory()
            ->count(8)
            ->notReplied()
            ->create();
    }
}
