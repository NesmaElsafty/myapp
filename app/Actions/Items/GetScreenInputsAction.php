<?php

namespace App\Actions\Items;

use App\Models\Item;
use App\Models\Screen;
use App\Services\InputService;
use App\Services\ItemMediaService;
use App\Services\ScreenService;

class GetScreenInputsAction
{
    public function __construct(
        protected ScreenService $screenService,
        protected InputService $inputService,
        protected ItemMediaService $itemMediaService,
    ) {
    }

    public function handle(Item $item, Screen $screen): array
    {
        $this->screenService->ensureItemAndScreenMatch($item, $screen);

        $stepsCount = $this->screenService->stepsCountForCategory($item->category);

        $inputs = $this->inputService
            ->getInputsForScreen($screen)
            ->map(function ($input) use ($item) {
                $media = [];
                if (in_array($input->type, ['file', 'image', 'video', 'audio'], true)) {
                    $media = $this->itemMediaService->getMediaForInput($item, $input);
                }

                return $this->inputService->buildResponseInput($input, $item, $media);
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

