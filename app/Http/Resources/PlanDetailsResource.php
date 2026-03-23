<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $lang = app()->getLocale();
        $name = $lang === 'ar' ? $this->category?->name_ar : $this->category?->name_en;
        $onePostData = [
            'id' => $this->id,
            'price' => (float) $this->price,
            'duration' => (int) $this->duration,
            'category' => [
                'id' => $this->category?->id,
                'name' => $name,
            ],
            'is_promoted' => (bool) $this->is_promoted,
            'promotion_type' => $this->promotion_type,
        ];

        $manyPostsData = [
            'id' => $this->id,
            'price' => (float) $this->price,
            'duration' => (int) $this->duration,
            'free_trial_duration' => (int) $this->free_trial_duration,
            'free_trial_duration_type' => $this->free_trial_duration_type,
        ];
        return $this->plan->plan_type === 'one_post' ? $onePostData : $manyPostsData;
    }
}
