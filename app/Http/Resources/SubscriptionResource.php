<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $planName = $this->planDetail?->plan?->posts_limit;
        $planNameAr = $this->planDetail?->plan?->posts_limit;

        if($this->planDetail?->plan?->plan_type === 'one_post') {
            $planName = $this->planDetail?->category?->name_en;
            $planNameAr = $this->planDetail?->category?->name_ar;
        }      

        // get lang
        $lang = app()->getLocale();
        $planName = $lang === 'ar' ? $planNameAr : $planName;

        return [
            'id' => $this->id,
            'user_id' => [
                'id' => $this->user->id,
                'name' => $this->user->f_name . ' ' . $this->user->l_name,
                'type' => $this->user->type,
            ],
            'plan_id' => $this->plan_id,
            'plan_detail_id' => $this->plan_detail_id,
            'plan_name' => $planName,
            'status' => $this->status,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'price' => (float) $this->price,
            'available_posts_limit' => $this->available_posts_limit,
            'plan_posts_limit' => $this->plan_posts_limit,
            'used_posts' => $this->plan_posts_limit - $this->available_posts_limit,
            'golden_posts' => $this->golden_posts,
            'silver_posts' => $this->silver_posts,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
