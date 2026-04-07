<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = app()->getLocale();
        $name = $lang == 'ar' ? $this->name_ar : $this->name_en;

        return [
            'id' => $this->id,
            'name' => $name,

            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'regions' => $this->whenLoaded('regions', function () use ($lang) {
                return $this->regions->map(function ($region) use ($lang) {
                    return [
                        'id' => $region->id,
                        'name' => $lang == 'ar' ? $region->name_ar : $region->name_en,
                        'name_en' => $region->name_en,
                        'name_ar' => $region->name_ar,
                        'districts' => $region->districts->map(function ($district) use ($lang) {
                            return [
                                'id' => $district->id,
                                'name' => $lang == 'ar' ? $district->name_ar : $district->name_en,
                                'name_en' => $district->name_en,
                                'name_ar' => $district->name_ar,
                                'region_id' => $district->region_id,
                            ];
                        }),
                    ];
                });
            }),
            'regions_count' => $this->when(isset($this->regions_count), $this->regions_count),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
