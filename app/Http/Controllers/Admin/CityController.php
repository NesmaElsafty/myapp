<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\DistrictResource;
use App\Services\CityService;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;
use Exception;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'sorted_by' => 'nullable|string|in:name,newest,oldest,all',
            ]);

            $cities = $this->cityService->getAll($request->all())->paginate(10);

            return response()->json([
                'message' => __('messages.cities_retrieved_success'),
                'data' => CityResource::collection($cities),
                'pagination' => PaginationHelper::paginate($cities),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_cities'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        
        try {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'regions' => 'required|array|min:1',
                'regions.*.name_en' => 'required|string|max:255',
                'regions.*.name_ar' => 'required|string|max:255',
                'regions.*.district_en' => 'nullable|string|max:255',
                'regions.*.district_ar' => 'nullable|string|max:255',
                'regions.*.districts' => 'nullable|array',
                'regions.*.districts.*.name_en' => 'required_with:regions.*.districts|string|max:255',
                'regions.*.districts.*.name_ar' => 'required_with:regions.*.districts|string|max:255',
            ]);
            $city = $this->cityService->create($request->all());

            return response()->json([
                'message' => __('messages.city_created_success'),
                'data' => new CityResource($city),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_city'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $city = $this->cityService->getById($id);

            if (!$city) {
                return response()->json([
                    'message' => __('messages.city_not_found'),
                ], 404);
            }

            return response()->json([
                'message' => __('messages.city_retrieved_success'),
                'data' => new CityResource($city),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_city'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'nullable|string|max:255',
                'regions' => 'nullable|array',
                'regions.*.name_en' => 'nullable|string|max:255',
                'regions.*.name_ar' => 'nullable|string|max:255',
                'regions.*.district_en' => 'nullable|string|max:255',
                'regions.*.district_ar' => 'nullable|string|max:255',
                'regions.*.districts' => 'nullable|array',
                'regions.*.districts.*.name_en' => 'required_with:regions.*.districts|string|max:255',
                'regions.*.districts.*.name_ar' => 'required_with:regions.*.districts|string|max:255',
            ]);

            $city = $this->cityService->update($id, $request->all());
            return response()->json([
                'message' => __('messages.city_updated_success'),
                'data' => new CityResource($city),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_city'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->cityService->delete($id);

            return response()->json([
                'message' => __('messages.city_deleted_success'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_city'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // get regions by city id
    public function getRegionsByCityId($cityId)
    {
        try {
            $regions = $this->cityService->getRegionsByCityId($cityId);
            return response()->json([
                'message' => __('messages.regions_retrieved_success'),
                'data' => RegionResource::collection($regions),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_regions'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // get districts by region id
    public function getDistrictsByRegionId($regionId)
    {
        try {
        $districts = $this->cityService->getDistrictsByRegionId($regionId);
        return response()->json([
            'message' => __('messages.districts_retrieved_success'),
            'data' => DistrictResource::collection($districts),
        ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => __('messages.failed_retrieve_districts'),
            ], 500);
        }
    }
}
