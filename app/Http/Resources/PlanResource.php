<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
            'duration' => (int) $this->duration,
            'duration_type' => $this->duration_type,
            'free_trial_duration' => (int) $this->free_trial_duration,
            'free_trial_duration_type' => $this->free_trial_duration_type,
            'posts_limit' => (int) $this->posts_limit,
            'target_user' => $this->target_user,
            'is_active' => (bool) $this->is_active,
            'users_count' => 0,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
