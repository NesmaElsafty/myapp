<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegionResource;
use App\Services\RegionService;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;
use Exception;

class RegionController extends Controller
{
    protected RegionService $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'city_id' => 'nullable|exists:cities,id',
                'sorted_by' => 'nullable|string|in:name,newest,oldest,all',
            ]);

            $regions = $this->regionService->getAll($request->all())->paginate(10);

            return response()->json([
                'message' => 'Regions retrieved successfully',
                'data' => RegionResource::collection($regions),
                'pagination' => PaginationHelper::paginate($regions),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve regions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'district_en' => 'nullable|string|max:255',
            'district_ar' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        try {
            $region = $this->regionService->create($request->all());

            return response()->json([
                'message' => 'Region created successfully',
                'data' => new RegionResource($region),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create region',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $region = $this->regionService->getById($id);

            if (!$region) {
                return response()->json([
                    'message' => 'Region not found',
                ], 404);
            }

            return response()->json([
                'message' => 'Region retrieved successfully',
                'data' => new RegionResource($region),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve region',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'nullable|string|max:255',
                'district_en' => 'nullable|string|max:255',
                'district_ar' => 'nullable|string|max:255',
                'city_id' => 'nullable|exists:cities,id',
            ]);

            $region = $this->regionService->update($id, $request->all());

            return response()->json([
                'message' => 'Region updated successfully',
                'data' => new RegionResource($region),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update region',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->regionService->delete($id);

            return response()->json([
                'message' => 'Region deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete region',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
