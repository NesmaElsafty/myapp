<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
        $btn_text = $lang == 'ar' ? $this->btn_text_ar : $this->btn_text_en;
        
        return [
            'id' => $this->id,
            'title' => $title,
            'description' => $description,
            'is_active' => (bool) $this->is_active,
            'btn_text' => $btn_text,
            'btn_link' => $this->btn_link,
            'btn_is_active' => (bool) $this->btn_is_active,
            'type' => $this->type,
            'image' => $image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
