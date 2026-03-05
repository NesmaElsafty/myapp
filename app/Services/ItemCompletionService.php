<?php

namespace App\Services;

use App\Models\Input;
use App\Models\Item;
use App\Models\ItemInputValue;

class ItemCompletionService
{
    /**
     * Returns an array of missing required input keys.
     */
    public function getMissingRequiredInputs(Item $item): array
    {
        $inputs = Input::whereHas('screen', function ($q) use ($item) {
            $q->where('category_id', $item->category_id);
        })
            ->where('is_required', true)
            ->where('is_active', true)
            ->get();

        $missing = [];

        foreach ($inputs as $input) {
            if ($this->isFileType($input->type)) {
                if ($item->getMedia($input->key)->isEmpty()) {
                    $missing[] = $input->key;
                }
                continue;
            }

            $valueRow = ItemInputValue::where('item_id', $item->id)
                ->where('input_id', $input->id)
                ->first();

            $value = $valueRow?->value;

            if ($value === null) {
                $missing[] = $input->key;
                continue;
            }

            if (is_string($value) && trim($value) === '') {
                $missing[] = $input->key;
            }
        }

        return $missing;
    }

    protected function isFileType(?string $type): bool
    {
        return in_array($type, ['file', 'image', 'video', 'audio'], true);
    }
}

