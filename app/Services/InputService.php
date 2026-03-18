<?php

namespace App\Services;

use App\Models\Input;
use App\Models\Item;
use App\Models\Screen;
use App\Models\ItemInputValue;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InputService
{
    public function getInputsForScreen(Screen $screen): Collection
    {
        return $screen->inputs()
            ->where('is_active', true)
            ->orderBy('id')
            ->get();
    }

    public function buildValidationRulesForInput(Input $input): array
    {
        // If explicit validation rules are defined for file-like inputs
        if (is_array($input->validation_rules) && !empty($input->validation_rules)) {
            if ($this->isMultiFile($input)) {
                return [
                    'value' => ['required', 'array', 'min:1'],
                    'value.*' => $input->validation_rules,
                ];
            }

            return ['value' => $input->validation_rules];
        }

        // Default rules when validation_rules is null
        if ($this->isMultiFile($input)) {
            return [
                'value' => ['required', 'array', 'min:1'],
                'value.*' => ['file', 'max:10240'],
            ];
        }

        $rules = ['nullable'];

        switch ($input->type) {
            case 'text':
            case 'textarea':
            case 'email':
            case 'phone':
            case 'url':
            case 'link':
                $rules[] = 'string';
                break;
            case 'number':
                $rules[] = 'numeric';
                break;
            case 'date':
                $rules[] = 'date';
                break;
            case 'time':
                $rules[] = 'date_format:H:i';
                break;
            case 'checkbox':
                $rules[] = 'boolean';
                break;
            case 'select':
            case 'radio':
                $rules[] = $this->buildInRuleFromOptions($input);
                break;
            case 'file':
            case 'image':
            case 'video':
            case 'audio':
                $rules[] = 'file';
                $rules[] = 'max:10240';
                break;
            default:
                break;
        }

        return ['value' => $rules];
    }

    protected function isMultiFile(Input $input): bool
    {
        return $input->type === 'multi_file';
    }

    protected function buildInRuleFromOptions(Input $input): Rule
    {
        $values = [];
        $options = $input->options ?? [];
        if (isset($options['choices']) && is_array($options['choices'])) {
            foreach ($options['choices'] as $choice) {
                if (isset($choice['value'])) {
                    $values[] = $choice['value'];
                }
            }
        }

        return Rule::in($values);
    }

    public function buildResponseInput(Input $input, Item $item, array $media = []): array
    {
        $valueRow = ItemInputValue::where('item_id', $item->id)
            ->where('input_id', $input->id)
            ->first();

        return [
            'id' => $input->id,
            'key' => $input->key,
            'type' => $input->type,
            'is_required' => (bool) $input->is_required,
            'validation_rules' => $input->validation_rules,
            'options' => $input->options,
            'value' => $valueRow?->value,
            'media' => $media,
        ];
    }

    /**
     * Existing admin-facing methods (preserved).
     */
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

        // generate key depending on the title_en
        $key = strtolower(str_replace(' ', '_', $data['title_en']));
        // check if key is already exists throw validation exception
        if (Input::where('key', $key)->exists()) {
        throw ValidationException::withMessages(['key' => [__('messages.input_key_already_exists_in_screen')]]);
        }

        $input = new Input();
        $input->screen_id = $data['screen_id'];
        $input->key = $key;
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
