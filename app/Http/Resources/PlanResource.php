<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FeatureResource;
class PlanResource extends JsonResource
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

        return [
            'id' => $this->id,
            'name' => $name,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'price' => (float) $this->price,
            'official_duration' => $this->official_duration,
            'free_duration' => $this->free_duration,
            'posts_limit' => $this->posts_limit,
            'target_user' => $this->target_user,
            'is_active' => (bool) $this->is_active,
            'features' => FeatureResource::collection($this->features),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
