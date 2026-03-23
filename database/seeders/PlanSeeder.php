<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PlanSeeder extends Seeder
{
    private ?string $targetUserColumnType = null;

    private function createPlan(array $attributes): Plan
    {
        if (!Schema::hasColumn('plans', 'plan_type')) {
            unset($attributes['plan_type']);
        }

        if (isset($attributes['target_user'])) {
            $attributes['target_user'] = $this->formatTargetUser((string) $attributes['target_user']);
        }

        return Plan::factory()->create($attributes);
    }

    private function formatTargetUser(string $value): string
    {
        if ($this->targetUserColumnType === null) {
            $column = DB::selectOne("SHOW COLUMNS FROM `plans` LIKE 'target_user'");
            $this->targetUserColumnType = $column->Type ?? '';
        }

        if (str_starts_with(strtolower($this->targetUserColumnType), 'enum(')) {
            return $value;
        }

        return json_encode([$value], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // In DatabaseSeeder, CategorySeeder currently runs after PlanSeeder.
        // Ensure categories exist so one_post plan details can be created per category.
        if (Category::count() === 0) {
            Category::create([
                'name_en' => 'Default category',
                'name_ar' => 'فئة افتراضية',
                'is_active' => true,
            ]);
        }

        $categories = Category::pluck('id');
        $allaowedCategories = [3,4,7,8];


        // 1) individual / many_posts / 30
        $individualMany30 = $this->createPlan([
            'target_user' => 'individual',
            'plan_type' => 'many_posts',
            'posts_limit' => 30,
            'is_active' => true,
        ]);

        foreach ([1, 3, 6, 12] as $duration) {
            DB::table('plan_details')->insert([
                'plan_id' => $individualMany30->id,
                'price' => fake()->randomFloat(2, 20, 500),
                'duration' => $duration,
                'free_trial_duration' => fake()->numberBetween(0, 14),
                'free_trial_duration_type' => 'days',
                'category_id' => null,
                'is_promoted' => false,
                'promotion_type' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Same again with posts_limit 60
        $individualMany60 = $this->createPlan([
            'target_user' => 'individual',
            'plan_type' => 'many_posts',
            'posts_limit' => 60,
            'is_active' => true,
        ]);

        foreach ([1, 3, 6, 12] as $duration) {
            DB::table('plan_details')->insert([
                'plan_id' => $individualMany60->id,
                'price' => fake()->randomFloat(2, 20, 500),
                'duration' => $duration,
                'free_trial_duration' => fake()->numberBetween(0, 14),
                'free_trial_duration_type' => 'days',
                'category_id' => null,
                'is_promoted' => false,
                'promotion_type' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2) individual / one_post / 1
        $individualOnePost = $this->createPlan([
            'target_user' => 'individual',
            'plan_type' => 'one_post',
            'posts_limit' => 1,
            'is_active' => true,
        ]);

        foreach ($categories as $categoryId) {
            if (!in_array($categoryId, $allaowedCategories)) {
                continue;
            }
            DB::table('plan_details')->insert([
                'plan_id' => $individualOnePost->id,
                'price' => fake()->randomFloat(2, 20, 500),
                'duration' => 30,
                'free_trial_duration' => 0,
                'free_trial_duration_type' => 'days',
                'category_id' => $categoryId,
                'is_promoted' => fake()->boolean(),
                'promotion_type' => fake()->randomElement(['gold', 'silver']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Same for origin / one_post / 1
        $originOnePost = $this->createPlan([
            'target_user' => 'origin',
            'plan_type' => 'one_post',
            'posts_limit' => 1,
            'is_active' => true,
        ]);

        foreach ($categories as $categoryId) {
            if (!in_array($categoryId, $allaowedCategories)) {
                continue;
            }
            DB::table('plan_details')->insert([
                'plan_id' => $originOnePost->id,
                'price' => fake()->randomFloat(2, 20, 500),
                'duration' => 30,
                'free_trial_duration' => 0,
                'free_trial_duration_type' => 'days',
                'category_id' => $categoryId,
                'is_promoted' => fake()->boolean(),
                'promotion_type' => fake()->randomElement(['gold', 'silver']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
