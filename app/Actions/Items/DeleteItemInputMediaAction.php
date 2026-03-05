<?php

namespace App\Actions\Items;

use App\Models\Input;
use App\Models\Item;
use App\Services\ItemMediaService;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeleteItemInputMediaAction
{
    public function __construct(
        protected ItemMediaService $itemMediaService,
    ) {
    }

    public function handle(Item $item, Input $input, Media $media): array
    {
        if ($item->status === 'completed') {
            throw ValidationException::withMessages([
                'item' => ['Item is already completed.'],
            ]);
        }

        if ($input->screen->category_id !== $item->category_id) {
            abort(422, 'Input does not belong to item category.');
        }

        $deletedId = $media->id;

        $this->itemMediaService->deleteMediaForInput($item, $input, $media);

        return [
            'success' => true,
            'deleted_media_id' => $deletedId,
            'input_key' => $input->key,
        ];
    }
}

