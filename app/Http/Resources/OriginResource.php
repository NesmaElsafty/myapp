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
            'individuals' => IndividualResource::collection($individuals),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
