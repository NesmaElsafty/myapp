<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Services\CityService;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;
use App\Models\Region;
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
                'regions' => 'required|array',
                'regions.*.name_en' => 'required|string|max:255',
                'regions.*.name_ar' => 'required|string|max:255',
                'regions.*.district_en' => 'required|string|max:255',
                'regions.*.district_ar' => 'required|string|max:255',
            ]);
            $city = $this->cityService->create($request->all());

            foreach ($request->regions as $region) {
                $region = Region::create([
                    'name_en' => $region['name_en'],
                    'name_ar' => $region['name_ar'],
                    'district_en' => $region['district_en'],
                    'district_ar' => $region['district_ar'],
                    'city_id' => $city->id,
                ]);
            }

            return response()->json([
                'message' => __('messages.city_created_success'),
                'data' => new CityResource($city->load('regions')),
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
            ]);

            $city = $this->cityService->update($id, $request->all());   
            // delete all regions
            if($request->has('regions')) {
                foreach ($city->regions as $region) {
                    $region->delete();
                }

                // create new regions
                foreach ($request->regions as $region) {
                    $region = Region::create([
                        'name_en' => $region['name_en'],
                        'name_ar' => $region['name_ar'],
                        'district_en' => $region['district_en'],
                        'district_ar' => $region['district_ar'],
                        'city_id' => $city->id,
                    ]);
                }
            }
            return response()->json([
                'message' => __('messages.city_updated_success'),
                'data' => new CityResource($city->load('regions')),
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
}
