<?php

namespace App\Services;

use App\Models\Input;
use App\Models\Item;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ItemMediaService
{
    public function syncSingleForInput(Item $item, Input $input, string $fieldName = 'value'): void
    {
        $collection = $input->key;

        $item->clearMediaCollection($collection);

        if (request()->hasFile($fieldName)) {
            $item
                ->addMediaFromRequest($fieldName)
                ->toMediaCollection($collection);
        }
    }

    public function appendMultipleForInput(Item $item, Input $input, string $fieldName = 'value'): void
    {
        $collection = $input->key;

        $files = request()->file($fieldName) ?? [];

        if (! is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if (! $file) {
                continue;
            }

            $item
                ->addMedia($file)
                ->toMediaCollection($collection);
        }
    }

    public function deleteMediaForInput(Item $item, Input $input, Media $media): void
    {
        if (
            $media->model_type !== Item::class ||
            (int) $media->model_id !== (int) $item->id ||
            $media->collection_name !== $input->key
        ) {
            abort(404, 'Media not found for this item/input.');
        }

        $media->delete();
    }

    public function getMediaForInput(Item $item, Input $input): array
    {
        $collection = $input->key;
        return $item->getMedia($collection)->map(function ($media) {
            return [
                'id' => $media->id,
                'file_name' => $media->file_name,
                'mime_type' => $media->mime_type,
                'size' => $media->size,
                'url' => $media->getFullUrl(),
            ];
        })->all();
    }
}

