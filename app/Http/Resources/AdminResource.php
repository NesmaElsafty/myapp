<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = null;
        if($this->hasMedia('profile')) {
            $image = str_replace('public/', '', $this->getFirstMediaUrl('profile'));
        }

        return [
            'id' => $this->id,
            'f_name' => $this->f_name,
            'l_name' => $this->l_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
            'image' => $image,
            'email_verified_at' => $this->email_verified_at,
            'alerts' => AlertResource::collection($this->alerts),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
