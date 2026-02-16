<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\ContentResource;
use App\Services\ContentService;
use Exception;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __construct(
        protected ContentService $contentService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'page_id' => 'nullable|integer|exists:pages,id',
                'type' => 'nullable|string|in:img_text,card,list',
            ]);

            $contents = $this->contentService->getAll($request->all())->paginate(10);

            return response()->json([
                'message' => __('messages.contents_retrieved_success'),
                'data' => ContentResource::collection($contents),
                'pagination' => PaginationHelper::paginate($contents),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_contents'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'page_id' => 'required|integer|exists:pages,id',
                'type' => 'nullable|string|in:img_text,card,list',
                'title_en' => 'nullable|string|max:255',
                'title_ar' => 'nullable|string|max:255',
                'content_en' => 'nullable|string',
                'content_ar' => 'nullable|string',
            ];
            if ($request->input('type') === 'img_text') {
                $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            }
            $request->validate($rules);

            $content = $this->contentService->create($request->except('image'));

            if ($request->input('type') === 'img_text' && $request->hasFile('image')) {
                $content->addMediaFromRequest('image')->toMediaCollection('image');
            }

            return response()->json([
                'message' => __('messages.content_created_success'),
                'data' => new ContentResource($content->load('page')),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_content'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $content = $this->contentService->getById((int) $id);

            if (!$content) {
                return response()->json(['message' => __('messages.content_not_found')], 404);
            }

            return response()->json([
                'message' => __('messages.content_retrieved_success'),
                'data' => new ContentResource($content),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_content'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $content = $this->contentService->getById((int) $id);
            if (!$content) {
                return response()->json(['message' => __('messages.content_not_found')], 404);
            }

            $rules = [
                'page_id' => 'nullable|integer|exists:pages,id',
                'type' => 'nullable|string|in:img_text,card,list',
                'title_en' => 'nullable|string|max:255',
                'title_ar' => 'nullable|string|max:255',
                'content_en' => 'nullable|string',
                'content_ar' => 'nullable|string',
            ];
            if ($content->type === 'img_text' || $request->input('type') === 'img_text') {
                $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            }
            $request->validate($rules);

            $content = $this->contentService->update($id, $request->except('image'));

            if (($content->type === 'img_text') && $request->hasFile('image')) {
                $content->clearMediaCollection('image');
                $content->addMediaFromRequest('image')->toMediaCollection('image');
            }

            return response()->json([
                'message' => __('messages.content_updated_success'),
                'data' => new ContentResource($content->load('page')),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_content'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->contentService->delete((int) $id);

            return response()->json([
                'message' => __('messages.content_deleted_success'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_content'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
