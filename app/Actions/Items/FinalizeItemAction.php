<?php

namespace App\Actions\Items;

use App\Events\ItemCompleted;
use App\Models\Item;
use App\Services\ItemCompletionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FinalizeItemAction
{
    public function __construct(
        protected ItemCompletionService $itemCompletionService,
    ) {
    }

    public function handle(Item $item, array $staticData): Item
    {
        if ($item->status === 'completed') {
            throw ValidationException::withMessages([
                'item' => ['Item is already completed.'],
            ]);
        }

        $missing = $this->itemCompletionService->getMissingRequiredInputs($item);

        if (! empty($missing)) {
            throw ValidationException::withMessages([
                'inputs' => ['Missing required inputs: ' . implode(', ', $missing)],
                'missing_keys' => $missing,
            ]);
        }

        $item = DB::transaction(function () use ($item, $staticData) {
            $item->update(array_merge(
                $staticData,
                [
                    'status' => 'completed',
                    'completed_at' => now(),
                    'current_screen_id' => null,
                ]
            ));

            event(new ItemCompleted($item));

            return $item->fresh();
        });

        return $item;
    }
}

