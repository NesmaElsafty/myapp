<?php

namespace App\Http\Requests\Items;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FinalizeItemRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric'],
            'price_after_discount' => ['nullable', 'numeric'],
            'location' => ['nullable', 'string', 'max:255'],
            'lat' => ['nullable', 'string', 'max:255'],
            'long' => ['nullable', 'string', 'max:255'],
            'available_datetime' => ['nullable', 'date'],
            'payment_platform' => ['nullable', 'in:cash,installment'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'district' => ['nullable', 'string', 'max:255'],
            'street' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_type' => ['nullable', 'in:whatsapp,phone,email'],
            'appear_in_item' => ['nullable', 'boolean'],
        ];
    }
}

