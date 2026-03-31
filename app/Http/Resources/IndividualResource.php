<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;            
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Subscription;
class IndividualResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       

        $image = null;
        if ($this->hasMedia('profile')) {
            $image = str_replace('public/', '', $this->getFirstMediaUrl('profile'));
        }

        $isSubscribed = $this->isSubscribed() ? true : false;
        $subscription = $this->activeSubscription();

        if($this->origin_id != null) {
            $isSubscribed = $this->origin?->isSubscribed() ? true : false;
            $subscription = $this->origin?->activeSubscription();
        }


        return [
            'id' => $this->id,
            'f_name' => $this->f_name,
            'l_name' => $this->l_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
            'origin_id' => $this->origin_id,
            
            'origin' => $this->origin_id ? [
                'id' => $this->origin?->id,
                'f_name' => $this->origin?->f_name,
                'l_name' => $this->origin?->l_name,
                'email' => $this->origin?->email,
                'phone' => $this->origin?->phone,
                'commercial_number' => $this->origin?->commercial_number,
                'specialty_areas' => $this->origin?->specialty_areas ?? [],
                'major' => $this->origin?->major,
            ] : null,
            'is_subscribed' => $isSubscribed,
            'subscription' => $isSubscribed ? [
                'id' => $subscription->id,
                'plan_posts_limit' => $subscription->plan_posts_limit,
                'available_posts_limit' => $subscription->available_posts_limit,
                'golden_posts' => $subscription->golden_posts,
                'silver_posts' => $subscription->silver_posts,
                'expiry_date' => $subscription->end_date,
            ] : null,

            'national_id' => $this->national_id,
            'specialty_areas' => $this->specialty_areas ?? [],
            'major' => $this->major,
            'summary' => $this->summary,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_account_iban' => $this->bank_account_iban,
            'bank_account_address' => $this->bank_account_address,
            'location' => $this->location,
            'language' => $this->language ?? 'ar',
            'email_verified_at' => $this->email_verified_at,
            'image' => $image,
            'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
            'items_count' => 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            ];
        }
    }
