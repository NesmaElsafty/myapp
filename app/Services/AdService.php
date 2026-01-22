<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Validation\ValidationException;

class AdService
{
    public function getAll($data)
    {
        $query = Ad::query();

        if (isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_ar', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function getById($id)
    {
        return Ad::find($id);
    }

    public function create($data)
    {
        return Ad::create([
            'title_en' => $data['title_en'],
            'title_ar' => $data['title_ar'],
            'description_en' => $data['description_en'],
            'description_ar' => $data['description_ar'],
            'is_active' => $data['is_active'] ?? true,
            'btn_text_en' => $data['btn_text_en'] ?? null,
            'btn_text_ar' => $data['btn_text_ar'] ?? null,
            'btn_link' => $data['btn_link'] ?? null,
            'btn_is_active' => $data['btn_is_active'] ?? false,
            'type' => $data['type'] ?? null,
        ]);
    }

    public function update($id, $data)
    {
        $ad = Ad::find($id);
        if (!$ad) {
            throw ValidationException::withMessages(['ad' => ['Ad not found']]);
        }

        $ad->title_en = $data['title_en'] ?? $ad->title_en;
        $ad->title_ar = $data['title_ar'] ?? $ad->title_ar;
        $ad->description_en = $data['description_en'] ?? $ad->description_en;
        $ad->description_ar = $data['description_ar'] ?? $ad->description_ar;
        $ad->is_active = $data['is_active'] ?? $ad->is_active;
        $ad->btn_text_en = $data['btn_text_en'] ?? $ad->btn_text_en;
        $ad->btn_text_ar = $data['btn_text_ar'] ?? $ad->btn_text_ar;
        $ad->btn_link = $data['btn_link'] ?? $ad->btn_link;
        $ad->btn_is_active = $data['btn_is_active'] ?? $ad->btn_is_active;
        $ad->type = $data['type'] ?? $ad->type;

        return $ad;
    }

    public function delete($id)
    {
        $ad = Ad::find($id);
        if (!$ad) {
            throw ValidationException::withMessages(['ad' => ['Ad not found']]);
        }
        $ad->delete();
        return true;
    }
}
