<?php

namespace App\Services;

use App\Models\City;
use App\Models\District;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CityService
{
    public function getAll($data)
    {
        $query = City::with('regions.districts');
        
        // Search by name_en or name_ar
        if(isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_ar', 'like', "%{$search}%");
            });
        }

        if(isset($data['sorted_by']) && $data['sorted_by'] !== 'all') {
            switch($data['sorted_by']) {
                case 'name':
                    $query->orderBy('name_en', 'asc');
                    break;
                case 'newest':
                    $query->orderBy('id', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }

    public function getById($id): ?City
    {
        return City::with('regions.districts')->find($id);
    }

    public function create($data)
    {
        return DB::transaction(function () use ($data) {
            $city = City::create([
                'name_en' => $data['name_en'],
                'name_ar' => $data['name_ar'],
            ]);

            $this->syncRegionsAndDistricts($city, $data['regions'] ?? []);

            return $city->load('regions.districts');
        });
    }

    public function update($id, $data)
    {
        $city = City::with('regions.districts')->find($id);
        if (!$city) {
            throw ValidationException::withMessages([
                'city' => ['City not found'],
            ]);
        }

        $updateData = [];

        if (isset($data['name_en'])) {
            $updateData['name_en'] = $data['name_en'];
        }

        if (isset($data['name_ar'])) {
            $updateData['name_ar'] = $data['name_ar'];
        }

        return DB::transaction(function () use ($city, $updateData, $data) {
            if (!empty($updateData)) {
                $city->update($updateData);
            }

            if (isset($data['regions'])) {
                $regionIds = $city->regions->pluck('id');
                if ($regionIds->isNotEmpty()) {
                    District::whereIn('region_id', $regionIds)->delete();
                }
                Region::where('city_id', $city->id)->delete();

                $this->syncRegionsAndDistricts($city, $data['regions']);
            }

            return $city->fresh()->load('regions.districts');
        });
    }

    public function delete($id)
    {
        $city = City::find($id);
        if (!$city) {
            throw ValidationException::withMessages([
                'city' => ['City not found'],
            ]);
        }

        // Check if city has regions
        if ($city->regions()->count() > 0) {
            throw ValidationException::withMessages([
                'city' => ['Cannot delete city with existing regions'],
            ]);
        }

        $city->delete();
        return true;
    }

    private function syncRegionsAndDistricts(City $city, array $regions): void
    {
        foreach ($regions as $regionData) {
            $region = Region::create([
                'name_en' => $regionData['name_en'],
                'name_ar' => $regionData['name_ar'],
                'district_en' => null,
                'district_ar' => null,
                'city_id' => $city->id,
            ]);

            $districts = $regionData['districts'] ?? [];

            // Backward compatibility for old payloads that sent one district on region fields.
            if (empty($districts) && (!empty($regionData['district_en']) || !empty($regionData['district_ar']))) {
                $districts[] = [
                    'name_en' => $regionData['district_en'] ?? '',
                    'name_ar' => $regionData['district_ar'] ?? '',
                ];
            }

            foreach ($districts as $districtData) {
                District::create([
                    'name_en' => $districtData['name_en'],
                    'name_ar' => $districtData['name_ar'],
                    'region_id' => $region->id,
                ]);
            }
        }
    }

    public function getRegionsByCityId($cityId)
    {
        return Region::where('city_id', $cityId)->get();
    }

    public function getDistrictsByRegionId($regionId)
    {
        return District::where('region_id', $regionId)->get();
    }   
}
