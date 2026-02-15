<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\ScreenResource;
use App\Models\Screen;
use App\Services\ScreenService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScreenController extends Controller
{
    public function __construct(
        protected ScreenService $screenService
    ) {}

    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang') ?? 'ar';
            $screens = $this->screenService->getAll($request->all(), $lang)->paginate(10);

            return response()->json([
                'message' => 'Screens retrieved successfully',
                'data' => ScreenResource::collection($screens),
                'pagination' => PaginationHelper::paginate($screens),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve screens',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $screen = $this->screenService->getById((int) $id);
            if (!$screen) {
                return response()->json(['message' => 'Screen not found'], 404);
            }
            return response()->json([
                'message' => 'Screen retrieved successfully',
                'data' => new ScreenResource($screen),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve screen',
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
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
            ]);

            $screen = $this->screenService->create($request->all());

            return response()->json([
                'message' => 'Screen created successfully',
                'data' => new ScreenResource($screen->load('category')),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create screen',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'nullable|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'category_id' => 'nullable|exists:categories,id',
            ]);

            $screen = $this->screenService->update((int) $id, $request->all());

            return response()->json([
                'message' => 'Screen updated successfully',
                'data' => new ScreenResource($screen),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update screen',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->screenService->delete((int) $id);
            return response()->json([
                'message' => 'Screen deleted successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Screen not found'], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete screen',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function bulkActions(Request $request)
    {
        try {
            $request->validate([
                'action' => 'required|in:delete,export',
                'screen_ids' => 'nullable|array',
                'screen_ids.*' => 'exists:screens,id',
            ]);

            $screenIds = $request->screen_ids;

            if (!$screenIds || count($screenIds) === 0) {
                $screenIds = Screen::pluck('id')->toArray();
            }

            switch ($request->action) {
                case 'delete':
                    $this->screenService->bulkDelete($screenIds);
                    $result = ['deleted' => count($screenIds)];
                    break;
                case 'export':
                    $result = ScreenResource::collection($this->screenService->export($screenIds));
                    break;
                default:
                    $result = [];
            }

            return response()->json([
                'message' => 'Bulk action performed successfully',
                'data' => $result,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to perform bulk action',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
