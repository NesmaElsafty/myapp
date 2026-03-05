<?php

namespace App\Http\Requests\Items;

use Illuminate\Foundation\Http\FormRequest;

class InitItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && in_array($user->type, ['individual', 'origin'], true);
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}

