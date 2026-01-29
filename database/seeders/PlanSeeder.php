<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Individual plans
        Plan::factory()->count(4)->forIndividual()->active()->create();
        Plan::factory()->count(1)->forIndividual()->inactive()->create();

        // Origin plans
        Plan::factory()->count(4)->forOrigin()->active()->create();
        Plan::factory()->count(1)->forOrigin()->inactive()->create();
    }
}
