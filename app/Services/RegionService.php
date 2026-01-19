<?php

namespace App\Services;

use App\Models\Region;
use Illuminate\Validation\ValidationException;

class RegionService
{
    public function getAll($data)
    {
        $query = Region::with('city');
        
        // Search by name_en, name_ar, district_en, or district_ar
        if(isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_ar', 'like', "%{$search}%")
                    ->orWhere('district_en', 'like', "%{$search}%")
                    ->orWhere('district_ar', 'like', "%{$search}%");
            });
        }

        // Filter by city_id
        if(isset($data['city_id']) && $data['city_id'] !== 'all') {
            $query->where('city_id', $data['city_id']);
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

    public function getById($id): ?Region
    {
        return Region::with('city')->find($id);
    }

    public function create($data)
    {
        $regionData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'district_en' => $data['district_en'] ?? null,
            'district_ar' => $data['district_ar'] ?? null,
            'city_id' => $data['city_id'],
        ];

        return Region::create($regionData);
    }

    public function update($id, $data)
    {
        $region = Region::find($id);
        if (!$region) {
            throw ValidationException::withMessages([
                'region' => ['Region not found'],
            ]);
        }

        $updateData = [];

        if (isset($data['name_en'])) {
            $updateData['name_en'] = $data['name_en'];
        }

        if (isset($data['name_ar'])) {
            $updateData['name_ar'] = $data['name_ar'];
        }

        if (isset($data['district_en'])) {
            $updateData['district_en'] = $data['district_en'];
        }

        if (isset($data['district_ar'])) {
            $updateData['district_ar'] = $data['district_ar'];
        }

        if (isset($data['city_id'])) {
            $updateData['city_id'] = $data['city_id'];
        }

        $region->update($updateData);

        return $region;
    }

    public function delete($id)
    {
        $region = Region::find($id);
        if (!$region) {
            throw ValidationException::withMessages([
                'region' => ['Region not found'],
            ]);
        }

        $region->delete();
        return true;
    }
}
