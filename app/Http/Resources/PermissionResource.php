<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // get locale
        $locale = app()->getLocale();
        $displayName = $locale == 'ar' ? $this->display_name_ar : $this->display_name_en;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $displayName,
            'group' => $this->group,
        ];
    }
}
