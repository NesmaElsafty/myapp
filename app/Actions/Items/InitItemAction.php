<?php

namespace App\Actions\Items;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use App\Services\InputService;
use App\Services\ScreenService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InitItemAction
{
    public function __construct(
        protected ScreenService $screenService,
        protected InputService $inputService,
    ) {
    }

    public function handle(User $user, int $categoryId): array
    {
        $category = Category::find($categoryId);

        if (! $category) {
            throw ValidationException::withMessages([
                'category_id' => ['Category not found.'],
            ]);
        }

        $firstScreen = $this->screenService->firstForCategory($category);

        if (! $firstScreen) {
            throw ValidationException::withMessages([
                'category_id' => ['Category has no screens configured.'],
            ]);
        }

        $stepsCount = $this->screenService->stepsCountForCategory($category);

        $item = DB::transaction(function () use ($user, $category, $firstScreen) {
            return Item::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'status' => 'in_progress',
                'current_screen_id' => $firstScreen->id,
            ]);
        });

        $inputs = $this->inputService
            ->getInputsForScreen($firstScreen)
            ->map(fn ($input) => $this->inputService->buildResponseInput($input, $item))
            ->all();

        return [
            'item' => $item->fresh(),
            'steps_count' => $stepsCount,
            'current_screen' => $firstScreen,
            'inputs' => $inputs,
        ];
    }
}

