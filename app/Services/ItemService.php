<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Input;
use App\Models\Item;
use App\Models\ItemData;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ItemService
{

    public function getAllForUser(User $user, array $filters = []): Builder
    {
        $query = Item::with(['category', 'city', 'region', 'data.input'])
            ->where('user_id', $user->id);

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        return $query->orderByDesc('id');
    }

    public function getByIdForUser(int $id, User $user): ?Item
    {
        return Item::with(['category', 'city', 'region', 'data.input'])
            ->where('user_id', $user->id)
            ->find($id);
    }

    public function createForUser(User $user, array $data): Item
    {
        if (!in_array($user->type, ['origin', 'individual'], true)) {
            throw ValidationException::withMessages([
                'user' => ['Only origin and individual users can create items.'],
            ]);
        }

        $category = Category::find($data['category_id'] ?? null);
        if (!$category) {
            throw ValidationException::withMessages([
                'category_id' => ['Category not found.'],
            ]);
        }

        $inputsPayload = $data['inputs'] ?? [];

        // All inputs for this category (across its screens)
        $inputs = Input::whereHas('screen', function (Builder $q) use ($category) {
            $q->where('category_id', $category->id);
        })->get();

        [$validValues, $errors] = $this->validateDynamicInputs($inputs, $inputsPayload);

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }

        return DB::transaction(function () use ($user, $data, $validValues) {
            $item = Item::create([
                'user_id' => $user->id,
                'category_id' => $data['category_id'],
                'name' => $data['name'] ?? null,
                'description' => $data['description'] ?? null,
                'price' => $data['price'] ?? null,
                'price_after_discount' => $data['price_after_discount'] ?? null,
                'location' => $data['location'] ?? null,
                'lat' => $data['lat'] ?? null,
                'long' => $data['long'] ?? null,
                'available_datetime' => $data['available_datetime'] ?? null,
                'payment_platform' => $data['payment_platform'] ?? null,
                'city_id' => $data['city_id'] ?? null,
                'region_id' => $data['region_id'] ?? null,
                'district' => $data['district'] ?? null,
                'street' => $data['street'] ?? null,
                'is_active' => $data['is_active'] ?? true,
                'contact_name' => $data['contact_name'] ?? null,
                'contact_phone' => $data['contact_phone'] ?? null,
                'contact_email' => $data['contact_email'] ?? null,
                'contact_type' => $data['contact_type'] ?? null,
                'appear_in_item' => $data['appear_in_item'] ?? false,
            ]);

            foreach ($validValues as $inputId => $value) {
                ItemData::create([
                    'item_id' => $item->id,
                    'input_id' => $inputId,
                    'value' => is_array($value) ? json_encode($value) : (string) $value,
                ]);
            }

            return $item->load(['category', 'city', 'region', 'data.input']);
        });
    }


    public function updateForUser(Item $item, User $user, array $data): Item
    {
        if ($item->user_id !== $user->id) {
            throw ValidationException::withMessages([
                'item' => ['You are not allowed to update this item.'],
            ]);
        }

        $categoryId = $data['category_id'] ?? $item->category_id;
        $category = Category::find($categoryId);
        if (!$category) {
            throw ValidationException::withMessages([
                'category_id' => ['Category not found.'],
            ]);
        }

        $inputsPayload = $data['inputs'] ?? [];
        $inputs = Input::whereHas('screen', function (Builder $q) use ($category) {
            $q->where('category_id', $category->id);
        })->get();

        [$validValues, $errors] = $this->validateDynamicInputs($inputs, $inputsPayload);

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }

        return DB::transaction(function () use ($item, $data, $categoryId, $validValues) {
            $item->update([
                'category_id' => $categoryId,
                'name' => $data['name'] ?? $item->name,
                'description' => $data['description'] ?? $item->description,
                'price' => $data['price'] ?? $item->price,
                'price_after_discount' => $data['price_after_discount'] ?? $item->price_after_discount,
                'location' => $data['location'] ?? $item->location,
                'lat' => $data['lat'] ?? $item->lat,
                'long' => $data['long'] ?? $item->long,
                'available_datetime' => $data['available_datetime'] ?? $item->available_datetime,
                'payment_platform' => $data['payment_platform'] ?? $item->payment_platform,
                'city_id' => $data['city_id'] ?? $item->city_id,
                'region_id' => $data['region_id'] ?? $item->region_id,
                'district' => $data['district'] ?? $item->district,
                'street' => $data['street'] ?? $item->street,
                'is_active' => $data['is_active'] ?? $item->is_active,
                'contact_name' => $data['contact_name'] ?? $item->contact_name,
                'contact_phone' => $data['contact_phone'] ?? $item->contact_phone,
                'contact_email' => $data['contact_email'] ?? $item->contact_email,
                'contact_type' => $data['contact_type'] ?? $item->contact_type,
                'appear_in_item' => $data['appear_in_item'] ?? $item->appear_in_item,
            ]);

            // Refresh dynamic data: simple approach – delete and recreate
            ItemData::where('item_id', $item->id)->delete();
            foreach ($validValues as $inputId => $value) {
                ItemData::create([
                    'item_id' => $item->id,
                    'input_id' => $inputId,
                    'value' => is_array($value) ? json_encode($value) : (string) $value,
                ]);
            }

            return $item->load(['category', 'city', 'region', 'data.input']);
        });
    }

    public function deleteForUser(Item $item, User $user): void
    {
        if ($item->user_id !== $user->id) {
            throw ValidationException::withMessages([
                'item' => ['You are not allowed to delete this item.'],
            ]);
        }

        $item->delete();
    }

    private function validateDynamicInputs($inputs, array $payload): array
    {
        $validValues = [];
        $errors = [];

        foreach ($inputs as $input) {
            $key = (string) $input->id;
            $hasValue = array_key_exists($key, $payload);

            if ($input->is_required && !$hasValue) {
                $errors['inputs.' . $key][] = __('validation.required', ['attribute' => $input->title_en ?? 'input']);
                continue;
            }

            if (!$hasValue) {
                continue;
            }

            $value = $payload[$key];

            // Basic type-based validation
            switch ($input->type) {
                case 'number':
                    if (!is_numeric($value)) {
                        $errors['inputs.' . $key][] = __('validation.numeric', ['attribute' => $input->title_en ?? 'input']);
                        continue 2;
                    }
                    break;
                case 'select':
                case 'radio':
                    $allowed = [];
                    $options = $input->options ?? [];
                    if (isset($options['choices']) && is_array($options['choices'])) {
                        foreach ($options['choices'] as $choice) {
                            if (isset($choice['value'])) {
                                $allowed[] = $choice['value'];
                            }
                        }
                    }
                    if (!in_array($value, $allowed, true)) {
                        $errors['inputs.' . $key][] = __('validation.in', ['attribute' => $input->title_en ?? 'input']);
                        continue 2;
                    }
                    break;
                case 'checkbox':
                    if (!is_array($value) && !is_bool($value)) {
                        $errors['inputs.' . $key][] = __('validation.boolean', ['attribute' => $input->title_en ?? 'input']);
                        continue 2;
                    }
                    break;
                case 'repeatable':
                    if (!is_array($value)) {
                        $errors['inputs.' . $key][] = __('validation.array', ['attribute' => $input->title_en ?? 'input']);
                        continue 2;
                    }
                    break;
                case 'date':
                    // Accept string (Y-m-d) or already validated
                    break;
                default:
                    // Treat others as string-like
                    if (is_array($value)) {
                        $errors['inputs.' . $key][] = __('validation.string', ['attribute' => $input->title_en ?? 'input']);
                        continue 2;
                    }
            }

            $validValues[$input->id] = $value;
        }

        return [$validValues, $errors];
    }

    // dynamic validation
    public function dynamicValidation(Category $category, array $payload): array
    {
        $validator = Validator::make($payload, $inputs);
        return [$validator->validated(), $validator->errors()];
    }

    // initiate item
    public function initiateItem($userId, $categoryId): Item
    {
        $item = Item::create([
            'user_id' => $user->id,
            'category_id' => $categoryId,
        ]);

        $this->initializeItemData($item, $categoryId);
        return $item->load(['category', 'city', 'region', 'data.input']);
    }

    // initialize item data
    public function initializeItemData(Item $item, $categoryId): void
    {
        $category = Category::find($categoryId);
        $inputs = $category->getCategoryInputsNames($categoryId);
        foreach ($inputs as $input) {
            ItemData::create([
                'item_id' => $item->id,
                'name' => $input['name'],
                'value' => null,
            ]);
        }
    }
}

