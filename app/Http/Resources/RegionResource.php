<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('lang') ?? 'ar';
        $name = $lang == 'ar' ? $this->name_ar : $this->name_en;
        $district = $lang == 'ar' ? $this->district_ar : $this->district_en;

        return [
            'id' => $this->id,
            'name' => $name,
            'district' => $district,

            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'district_en' => $this->district_en,
            'district_ar' => $this->district_ar,
            
            'city_id' => $this->city_id,
            'city' => $this->whenLoaded('city', function () {
                return new CityResource($this->city);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
