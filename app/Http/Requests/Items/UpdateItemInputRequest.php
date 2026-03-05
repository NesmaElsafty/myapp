<?php

namespace App\Http\Requests\Items;

use App\Models\Item;
use App\Models\Input;
use App\Services\InputService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateItemInputRequest extends FormRequest
{
    public function authorize(): bool
    {
        $itemId = $this->route('item');
        $item = $itemId ? Item::find($itemId) : null;
        $user = $this->user();

        if (! $user) {
            return false;
        }

        if (! $item) {
            throw new HttpResponseException(
                response()->json(['message' => 'Item not found.'], 404)
            );
        }

        if ($item->status === 'completed') {
            throw new HttpResponseException(
                response()->json(['message' => 'Item is already completed.'], 422)
            );
        }

        if ($item->user_id !== $user->id) {
            throw new HttpResponseException(
                response()->json(['message' => 'You are not allowed to access this item.'], 403)
            );
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'item_id' => 'required|exists:items,id',
            'input_ids' => 'required|array',
            'input_ids.*' => 'required|exists:inputs,id',
            'values' => 'required|array',
            'values.*' => 'required|string',
        ];
    }
}

