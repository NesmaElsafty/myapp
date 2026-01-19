<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Validation\ValidationException;

class CityService
{
    public function getAll($data)
    {
        $query = City::query();
        
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
        return City::with('regions')->find($id);
    }

    public function create($data)
    {
        $cityData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
        ];

        return City::create($cityData);
    }

    public function update($id, $data)
    {
        $city = City::find($id);
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

        $city->update($updateData);

        return $city;
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
}
