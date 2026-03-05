<?php

namespace App\Http\Requests\Items;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteItemInputMediaRequest extends FormRequest
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
        return [];
    }
}

