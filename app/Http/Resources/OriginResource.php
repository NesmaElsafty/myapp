<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OriginResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        $alerts = [];
        $individuals = $this->individuals;


        $image = null;
        if ($this->hasMedia('profile')) {
            $image = str_replace('public/', '', $this->getFirstMediaUrl('profile'));
        }

        $isSubscribed = $this->isSubscribed() ? true : false;
        $subscription = $this->activeSubscription();

        return [
            'id' => $this->id,
            'f_name' => $this->f_name,
            'l_name' => $this->l_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
            'commercial_number' => $this->commercial_number,
            'specialty_areas' => $this->specialty_areas ?? [],
            'major' => $this->major,
            'summary' => $this->summary,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_account_iban' => $this->bank_account_iban,
            'bank_account_address' => $this->bank_account_address,
            'language' => $this->language ?? 'ar',
            'email_verified_at' => $this->email_verified_at,
            'image' => $image,
            'individuals' => $this->whenLoaded('individuals', function () {
                return IndividualResource::collection($this->individuals);
            }),
            'is_subscribed' => $isSubscribed,
            'subscription' => $isSubscribed ? [
                'id' => $subscription->id,
                'plan_posts_limit' => $subscription->plan_posts_limit,
                'available_posts_limit' => $subscription->available_posts_limit,
                'golden_posts' => $subscription->golden_posts,
                'silver_posts' => $subscription->silver_posts,
                'expiry_date' => $subscription->end_date,
            ] : null,
            'items_count' => 0,
            'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
            'individuals_count' => $individuals->count(),
            'location' => $this->location,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
