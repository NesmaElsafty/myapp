<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $origin = User::where('type', 'origin')->first();
        $individual = User::where('type', 'individual')->first();
        $category = Category::first();

        if ($origin && $category) {
            Item::factory()->count(5)->create([
                'user_id' => $origin->id,
                'category_id' => $category->id,
            ]);
        }

        if ($individual && $category) {
            Item::factory()->count(5)->create([
                'user_id' => $individual->id,
                'category_id' => $category->id,
            ]);
        }
    }
}

