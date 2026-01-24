<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = null;
        if ($this->hasMedia('image')) {
            $image = str_replace('public/', '', $this->getFirstMediaUrl('image'));
        }
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
            'image' => $image,
        ];
    }
}
