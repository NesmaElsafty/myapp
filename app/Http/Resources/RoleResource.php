<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // get locale
        $locale = $request->header('lang');
        $name = $locale == 'ar' ? $this->name_ar : $this->name_en;
        $description = $locale == 'ar' ? $this->description_ar : $this->description_en;
        $total_admins = $this->users()->count();
        return [    
            'id' => $this->id,
            'name' => $name,
            'description' => $description,

            'permissions' => $this->whenLoaded('permissions', function () {
                return PermissionResource::collection($this->permissions);
            }),
            'total_admins' => $total_admins,
            'created_at' => $this->created_at,
        ];
    }
}
