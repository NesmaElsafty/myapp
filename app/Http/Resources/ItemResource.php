<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'price_after_discount' => $this->price_after_discount,
            'location' => $this->location,
            'lat' => $this->lat,
            'long' => $this->long,
            'available_datetime' => $this->available_datetime,
            'payment_platform' => $this->payment_platform,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
            'district' => $this->district,
            'street' => $this->street,
            'is_active' => (bool) $this->is_active,
            'contact_name' => $this->contact_name,
            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'contact_type' => $this->contact_type,
            'appear_in_item' => (bool) $this->appear_in_item,
            'category' => $this->whenLoaded('category', fn () => new CategoryResource($this->category)),
            'city' => $this->whenLoaded('city', fn () => new CityResource($this->city)),
            'region' => $this->whenLoaded('region', fn () => new RegionResource($this->region)),
            'inputs' => $this->data->map(function ($itemData) {
                return [
                    'input_id' => $itemData->input_id,
                    'value' => $itemData->value,
                    'input' => $itemData->relationLoaded('input') && $itemData->input
                        ? new InputResource($itemData->input)
                        : null,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

