<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            $lang = app()->getLocale();
            $screens = $this->screenService->getAll($request->all(), $lang)->paginate(10);

            return response()->json([
                'message' => __('messages.screens_retrieved_success'),
                'data' => ScreenResource::collection($screens),
                'pagination' => PaginationHelper::paginate($screens),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_screens'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $screen = $this->screenService->getById((int) $id);
            if (!$screen) {
                return response()->json(['message' => __('messages.screen_not_found')], 404);
            }
            return response()->json([
                'message' => __('messages.screen_retrieved_success'),
                'data' => new ScreenResource($screen),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_screen'),
                'error' => $e->getMessage(),
            ], 404);
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
                'message' => __('messages.screen_created_success'),
                'data' => new ScreenResource($screen->load('category')),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_screen'),
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
                'message' => __('messages.screen_updated_success'),
                'data' => new ScreenResource($screen),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_screen'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->screenService->delete((int) $id);
            return response()->json([
                'message' => __('messages.screen_deleted_success'),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => __('messages.screen_not_found')], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_screen'),
                'error' => $e->getMessage(),
            ], 404);
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
                'message' => __('messages.bulk_action_success'),
                'data' => $result,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_bulk_action'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
