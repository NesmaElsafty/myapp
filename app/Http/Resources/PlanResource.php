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
            'target_user' => $this->target_user,
            'plan_type' => $this->plan_type,
            'posts_count' => 0,
            'subscription_count' => 0,
            'is_active' => (bool) $this->is_active,          
            'details' => PlanDetailsResource::collection($this->details),            
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
