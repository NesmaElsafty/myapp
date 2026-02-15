<?php

namespace App\Services;

use App\Models\Screen;
use Illuminate\Validation\ValidationException;

class ScreenService
{
    /**
     * Get all screens with optional filters.
     */
    public function getAll($data, $lang = 'ar')
    {
        $query = Screen::with('category');

        if (isset($data['search'])) {
            $search = $data['search'];

            $query->where(function ($q) use ($search, $lang) {
                $q->where('name_' . $lang, 'like', "%{$search}%")
                    ->orWhere('description_' . $lang, 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function create($data)
    {
        $screen = new Screen();
        $screen->name_en = $data['name_en'];
        $screen->name_ar = $data['name_ar'];
        $screen->description_en = $data['description_en'];
        $screen->description_ar = $data['description_ar'];
        $screen->category_id = $data['category_id'];
        $screen->save();

        return $screen;
    }

    public function update($id, $data)
    {
        $screen = Screen::find($id);
        if (!$screen) {
            throw ValidationException::withMessages(['screen' => ['Screen not found']]);
        }
        $screen->name_en = $data['name_en'];
        $screen->name_ar = $data['name_ar'];
        $screen->description_en = $data['description_en'];
        $screen->description_ar = $data['description_ar'];
        $screen->category_id = $data['category_id'];
        $screen->save();

        return $screen;
    }

    public function delete($id)
    {
        $screen = Screen::find($id);
        if (!$screen) {
            throw ValidationException::withMessages(['screen' => ['Screen not found']]);
        }
        $screen->forceDelete();
        return $screen;
    }

}
