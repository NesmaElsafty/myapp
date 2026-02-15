<?php

namespace App\Services;

use App\Models\Input;
use Illuminate\Validation\ValidationException;

class InputService
{
    public function getAll(array $data, string $lang = 'ar')
    {
        $query = Input::with('screen');

        if (isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search, $lang) {
                $q->where('title_' . $lang, 'like', "%{$search}%")
                    ->orWhere('placeholder_' . $lang, 'like', "%{$search}%")
                    ->orWhere('description_' . $lang, 'like', "%{$search}%");
            });
        }

        if (isset($data['screen_id'])) {
            $query->where('screen_id', $data['screen_id']);
        }

        if (isset($data['type'])) {
            $query->where('type', $data['type']);
        }

        return $query;
    }

    public function getById(int $id): ?Input
    {
        return Input::with('screen')->find($id);
    }

    public function create(array $data): Input
    {
        $input = new Input();
        $input->screen_id = $data['screen_id'];
        $input->title_en = $data['title_en'] ?? null;
        $input->title_ar = $data['title_ar'] ?? null;
        $input->placeholder_en = $data['placeholder_en'] ?? null;
        $input->placeholder_ar = $data['placeholder_ar'] ?? null;
        $input->description_en = $data['description_en'] ?? null;
        $input->description_ar = $data['description_ar'] ?? null;
        $input->type = $data['type'] ?? null;
        $input->options = $data['options'] ?? null;
        $input->is_required = $data['is_required'] ?? false;
        $input->save();

        return $input;
    }

    public function update(int $id, array $data): Input
    {
        $input = Input::find($id);
        if (!$input) {
            throw ValidationException::withMessages(['input' => ['Input not found']]);
        }

        if (array_key_exists('screen_id', $data)) {
            $input->screen_id = $data['screen_id'];
        }
        if (array_key_exists('title_en', $data)) {
            $input->title_en = $data['title_en'];
        }
        if (array_key_exists('title_ar', $data)) {
            $input->title_ar = $data['title_ar'];
        }
        if (array_key_exists('placeholder_en', $data)) {
            $input->placeholder_en = $data['placeholder_en'];
        }
        if (array_key_exists('placeholder_ar', $data)) {
            $input->placeholder_ar = $data['placeholder_ar'];
        }
        if (array_key_exists('description_en', $data)) {
            $input->description_en = $data['description_en'];
        }
        if (array_key_exists('description_ar', $data)) {
            $input->description_ar = $data['description_ar'];
        }
        if (array_key_exists('type', $data)) {
            $input->type = $data['type'];
        }
        if (array_key_exists('options', $data)) {
            $input->options = $data['options'];
        }
        if (array_key_exists('is_required', $data)) {
            $input->is_required = $data['is_required'];
        }
        $input->save();

        return $input;
    }

    public function delete(int $id): Input
    {
        $input = Input::find($id);
        if (!$input) {
            throw ValidationException::withMessages(['input' => ['Input not found']]);
        }
        $input->forceDelete();
        return $input;
    }
}
