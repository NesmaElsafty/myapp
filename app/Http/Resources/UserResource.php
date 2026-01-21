<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $role = null;
        if($this->type == 'admin') {
            $role = $this->role;
        }

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
            'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
            'origin_id' => $this->origin_id,
            'national_id' => $this->national_id,
            'commercial_number' => $this->commercial_number,
            'role' => $role ? new RoleResource($role) : null,
            'email_verified_at' => $this->email_verified_at?->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'image' => $image,
        ];
    }
}
