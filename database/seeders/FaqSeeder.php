<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create FAQs for different segments
        Faq::factory()
            ->count(5)
            ->forUser()
            ->active()
            ->create();

        Faq::factory()
            ->count(3)
            ->forOrigin()
            ->active()
            ->create();

        Faq::factory()
            ->count(4)
            ->forIndividual()
            ->active()
            ->create();

        // Create some inactive FAQs
        Faq::factory()
            ->count(2)
            ->inactive()
            ->create();
    }
}
