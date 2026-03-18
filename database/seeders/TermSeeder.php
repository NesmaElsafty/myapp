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
        // Active "terms" entries with 1..3 target types
        Term::factory()->count(1)->forTerms()->active()->forUsers()->create();
        Term::factory()->count(1)->forTerms()->active()->forIndividuals()->create();
        Term::factory()->count(1)->forTerms()->active()->forOrigins()->create();
        Term::factory()->count(1)->forTerms()->active()->forUsersAndIndividuals()->create();
        Term::factory()->count(1)->forTerms()->active()->forAllTargets()->create();

        // Active "privacy" entries with 1..3 target types
        Term::factory()->count(1)->forPrivacy()->active()->forUsers()->create();
        Term::factory()->count(1)->forPrivacy()->active()->forIndividualsAndOrigins()->create();
        Term::factory()->count(1)->forPrivacy()->active()->forUsersAndOrigins()->create();
        Term::factory()->count(1)->forPrivacy()->active()->forAllTargets()->create();

        // Inactive "terms" example (still carries one or more targets)
        Term::factory()->count(1)->forTerms()->inactive()->forAllTargets()->create();
    }
}
