<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    protected $model = Plan::class;
    private static ?string $targetUserColumnType = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $targetUser = fake()->randomElement(['individual', 'origin']);
        $planType = fake()->randomElement(['one_post', 'many_posts']);

        $data = [
            'posts_limit' => $planType === 'one_post'
                ? fake()->randomElement([1, 2, 3])
                : fake()->randomElement([30, 60, 90, 120]),
            'target_user' => $this->formatTargetUser($targetUser),
            'is_active' => fake()->boolean(80),
        ];

        // Backward compatibility: some environments still have these columns on plans.
        if (Schema::hasColumn('plans', 'price')) {
            $data['price'] = fake()->randomFloat(2, 20, 500);
        }
        if (Schema::hasColumn('plans', 'duration')) {
            $data['duration'] = fake()->randomElement([1, 3, 6, 12, 30]);
        }
        if (Schema::hasColumn('plans', 'duration_type')) {
            $data['duration_type'] = fake()->randomElement(['days', 'months', 'years']);
        }
        if (Schema::hasColumn('plans', 'free_trial_duration')) {
            $data['free_trial_duration'] = fake()->numberBetween(0, 14);
        }
        if (Schema::hasColumn('plans', 'free_trial_duration_type')) {
            $data['free_trial_duration_type'] = 'days';
        }
        if (Schema::hasColumn('plans', 'is_gold')) {
            $data['is_gold'] = fake()->boolean(20);
        }

        if (Schema::hasColumn('plans', 'plan_type')) {
            $data['plan_type'] = $planType;
        }

        return $data;
    }

    private function formatTargetUser(string $value): string
    {
        // Some environments have target_user as ENUM, others as JSON-valid text.
        if (self::$targetUserColumnType === null) {
            $column = DB::selectOne("SHOW COLUMNS FROM `plans` LIKE 'target_user'");
            self::$targetUserColumnType = $column->Type ?? '';
        }

        if (str_starts_with(strtolower(self::$targetUserColumnType), 'enum(')) {
            return $value;
        }

        return json_encode([$value], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Indicate that the plan is for individuals.
     */
    public function forIndividual(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_user' => 'individual',
        ]);
    }

    /**
     * Indicate that the plan is for origins.
     */
    public function forOrigin(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_user' => 'origin',
        ]);
    }

    /**
     * Indicate that the plan is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the plan is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function forOnePost(): static
    {
        return $this->state(fn () => array_filter([
            'plan_type' => Schema::hasColumn('plans', 'plan_type') ? 'one_post' : null,
            'posts_limit' => fake()->randomElement([1, 2, 3]),
        ], fn ($value) => $value !== null));
    }

    public function forManyPosts(): static
    {
        return $this->state(fn () => array_filter([
            'plan_type' => Schema::hasColumn('plans', 'plan_type') ? 'many_posts' : null,
            'posts_limit' => fake()->randomElement([30, 60, 90, 120]),
        ], fn ($value) => $value !== null));
    }
}
