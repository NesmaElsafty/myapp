<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\AdResource;
use App\Services\AdService;
use Exception;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function __construct(
        protected AdService $adService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'type' => 'nullable|string|in:promotion,interface',
                'is_active' => 'nullable|boolean',
                'sorted_by' => 'nullable|string|in:title,newest,oldest,all',
            ]);

            $ads = $this->adService->getAll($request->all())->paginate(10);

            return response()->json([
                'message' => 'Ads retrieved successfully',
                'data' => AdResource::collection($ads),
                'pagination' => PaginationHelper::paginate($ads),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve ads',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'is_active' => 'nullable|boolean',
                'btn_text_en' => 'nullable|string|max:255',
                'btn_text_ar' => 'nullable|string|max:255',
                'btn_link' => 'nullable|string|max:500',
                'btn_is_active' => 'nullable|boolean',
                'type' => 'nullable|string|in:promotion,interface',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $ad = $this->adService->create($request->except('image'));

            $ad->addMediaFromRequest('image')->toMediaCollection('image');

            return response()->json([
                'message' => 'Ad created successfully',
                'data' => new AdResource($ad),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create ad',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $ad = $this->adService->getById((int) $id);

            if (!$ad) {
                return response()->json(['message' => 'Ad not found'], 404);
            }

            return response()->json([
                'message' => 'Ad retrieved successfully',
                'data' => new AdResource($ad),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve ad',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'title_en' => 'nullable|string|max:255',
                'title_ar' => 'nullable|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'is_active' => 'nullable|boolean',
                'btn_text_en' => 'nullable|string|max:255',
                'btn_text_ar' => 'nullable|string|max:255',
                'btn_link' => 'nullable|string|max:500',
                'btn_is_active' => 'nullable|boolean',
                'type' => 'nullable|string|in:promotion,interface',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $ad = $this->adService->update($id, $request->except('image'));

            if ($request->hasFile('image')) {
                $ad->clearMediaCollection('image');
                $ad->addMediaFromRequest('image')->toMediaCollection('image');
            }

            return response()->json([
                'message' => 'Ad updated successfully',
                'data' => new AdResource($ad),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update ad',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->adService->delete((int) $id);

            return response()->json([
                'message' => 'Ad deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete ad',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
