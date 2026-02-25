<?php

namespace App\Services;

use App\Models\Category;
use Exception;
use Illuminate\Validation\ValidationException;

class CategoryService
{

    public function getAll($search)
    {
        $query = Category::query();

        if (isset($search) && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_ar', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function create($data)
    {
        $category = Category::create([
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'is_active' => $data['is_active'] ?? true,
            'types' => $data['types'] ?? null,
        ]);

        return $category;
    }

    public function update($id, $data)
    {
        $category = Category::find($id);
        if (!$category) {
            throw ValidationException::withMessages(['category' => ['Category not found']]);
        }
        $update = [
            'name_en' => $data['name_en'] ?? $category->name_en,
            'name_ar' => $data['name_ar'] ?? $category->name_ar,
            'is_active' => $data['is_active'] ?? $category->is_active,
        ];
        if (array_key_exists('types', $data)) {
            $update['types'] = $data['types'];
        }
        $category->update($update);
        return $category;
    }

    public function getCategoryInputsName(int $categoryId)
    {
        $category = Category::find($categoryId);
        return $category->getCategoryInputsName($categoryId);
    }

    // 


}
