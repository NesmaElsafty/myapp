<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = null;
        if ($this->hasMedia('image')) {
            $image = str_replace('public/', '', $this->getFirstMediaUrl('image'));
        }

        $lang = $request->header('lang') ?? 'ar';
        $title = $lang == 'ar' ? $this->title_ar : $this->title_en;
        $description = $lang == 'ar' ? $this->description_ar : $this->description_en;

        return [
            'id' => $this->id,
            'title' => $title,
            'description' => $description,

            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,

            
            'is_active' => (bool) $this->is_active,
            'image' => $image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
