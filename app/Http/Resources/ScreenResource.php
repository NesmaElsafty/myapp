<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = app()->getLocale();
        $name = $lang === 'ar' ? $this->name_ar : $this->name_en;
        $description = $lang === 'ar' ? $this->description_ar : $this->description_en;

        return [
            'id' => $this->id,
            'name' => $name,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'description' => $description,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'category_id' => $this->category_id,
            'category' => $this->whenLoaded('category', fn () => new CategoryResource($this->category)),
            'inputs' => $this->whenLoaded('inputs', fn () => InputResource::collection($this->inputs)),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
