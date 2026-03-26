<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = app()->getLocale();
        $title = $lang === 'ar' ? $this->title_ar : $this->title_en;
        $description = $lang === 'ar' ? $this->description_ar : $this->description_en;
        
        return [
            'id' => $this->id,
            'title' => $title,
            'description' => $description,
            'price' => (float) $this->price,

            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,



        ];
    }
}
