<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Screen;
use Illuminate\Database\Seeder;

class ScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Run CategorySeeder first.');
            return;
        }

        foreach ($categories as $category) {
            Screen::factory()
                ->count(rand(2, 4))
                ->forCategory($category)
                ->create();
        }
    }
}
