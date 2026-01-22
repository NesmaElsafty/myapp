<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Terms for different types
        Term::factory()
            ->count(3)
            ->forTerms()
            ->active()
            ->create();

        Term::factory()
            ->count(2)
            ->forPrivacy()
            ->active()
            ->create();

        // Create some inactive Terms
        Term::factory()
            ->count(1)
            ->inactive()
            ->create();
    }
}
