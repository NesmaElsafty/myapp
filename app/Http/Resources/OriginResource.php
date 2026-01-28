<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OriginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $alerts = [];
        if($this->id == auth()->user()->id) {
            $alerts = AlertResource::collection($this->alerts);
        }
        return [
            'id' => $this->id,
            'f_name' => $this->f_name,
            'l_name' => $this->l_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
            'commercial_number' => $this->commercial_number,
            'email_verified_at' => $this->email_verified_at,
            'alerts' => $alerts,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
