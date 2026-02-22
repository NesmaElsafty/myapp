<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('lang') ?? 'en';
        $name = $lang === 'ar' ? $this->name_ar : $this->name_en;

        // string replace public/ from the url
        $image = $this->getMedia('image')->first() ? str_replace('public/', '', $this->getMedia('image')->first()->getUrl()) : null;

        $types = $this->types;
        if (is_array($types)) {
            $types = array_map(function ($item) use ($lang) {
                $label = ($lang === 'ar' && !empty($item['label_ar'])) ? $item['label_ar'] : ($item['label_en'] ?? null);
                return array_merge($item, ['label' => $label]);
            }, $types);
        }

        return [
            'id' => $this->id,
            'name' => $name,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'is_active' => $this->is_active,
            'types' => $types,
            'image' => $image,
            'screens' => ScreenResource::collection($this->screens),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
