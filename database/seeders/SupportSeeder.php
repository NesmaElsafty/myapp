<?php

namespace Database\Seeders;

use App\Models\Support;
use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create replied support tickets
        Support::factory()
            ->count(5)
            ->replied()
            ->create();

        // Create not replied support tickets
        Support::factory()
            ->count(8)
            ->notReplied()
            ->create();
    }
}
