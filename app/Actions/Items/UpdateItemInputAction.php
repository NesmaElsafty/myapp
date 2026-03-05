<?php

namespace App\Actions\Items;

use App\Models\Input;
use App\Models\Item;
use App\Models\ItemInputValue;
use App\Services\InputService;
use App\Services\ItemMediaService;
use App\Services\ScreenService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdateItemInputAction
{
    public function __construct(
        protected ScreenService $screenService,
        protected InputService $inputService,
        protected ItemMediaService $itemMediaService,
    ) {
    }

    public function handle(mixed $value, Item $item, Input $input): array
    {
        if ($item->status === 'completed') {
            throw ValidationException::withMessages([
                'item' => ['Item is already completed.'],
            ]);
        }

        $screen = $input->screen;
        $this->screenService->ensureItemAndScreenMatch($item, $screen);

        $singleFileTypes = ['file', 'image', 'video', 'audio'];
        $isSingleFile = in_array($input->type, $singleFileTypes, true);
        $isMultiFile = $input->type === 'multi_file';

        DB::transaction(function () use ($value, $item, $input, $screen, $isSingleFile, $isMultiFile) {
            if ($isSingleFile) {
                $this->itemMediaService->syncSingleForInput($item, $input, 'value');

                ItemInputValue::updateOrCreate(
                    ['item_id' => $item->id, 'input_id' => $input->id],
                    ['value' => null]
                );
            } elseif ($isMultiFile) {
                $this->itemMediaService->appendMultipleForInput($item, $input, 'value');

                ItemInputValue::updateOrCreate(
                    ['item_id' => $item->id, 'input_id' => $input->id],
                    ['value' => null]
                );
            } else {
                $storedValue = $value;

                if (is_array($storedValue)) {
                    $storedValue = json_encode($storedValue);
                }

                ItemInputValue::updateOrCreate(
                    ['item_id' => $item->id, 'input_id' => $input->id],
                    ['value' => $storedValue]
                );
            }

            $item->update([
                'current_screen_id' => $screen->id,
                'status' => $item->status === 'draft' ? 'in_progress' : $item->status,
            ]);
        });

        $screen = $screen->fresh();
        $item = $item->fresh();

        $stepsCount = $this->screenService->stepsCountForCategory($item->category);

        $inputs = $this->inputService
            ->getInputsForScreen($screen)
            ->map(function ($screenInput) use ($item) {
                $media = [];
                if (in_array($screenInput->type, ['file', 'image', 'video', 'audio', 'multi_file'], true)) {
                    $media = $this->itemMediaService->getMediaForInput($item, $screenInput);
                }

                return $this->inputService->buildResponseInput($screenInput, $item, $media);
            })
            ->all();

        return [
            'item_id' => $item->id,
            'screen_id' => $screen->id,
            'steps_count' => $stepsCount,
            'inputs' => $inputs,
        ];
    }
}

