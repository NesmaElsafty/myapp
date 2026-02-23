<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\PaginationHelper;
use App\Http\Resources\PageResource;
use App\Services\PageService;
use Exception;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(
        protected PageService $pageService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
            ]);

            $pages = $this->pageService->getAll($request->all())->paginate(10);

            return response()->json([
                'message' => __('messages.pages_retrieved_success'),
                'data' => PageResource::collection($pages),
                'pagination' => PaginationHelper::paginate($pages),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_pages'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_en' => 'nullable|string|max:255',
                'title_ar' => 'nullable|string|max:255',
                'content_en' => 'nullable|string',
                'content_ar' => 'nullable|string',
            ]);

            $page = $this->pageService->create($request->all());

            return response()->json([
                'message' => __('messages.page_created_success'),
                'data' => new PageResource($page->load('contents')),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_page'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $page = $this->pageService->getById((int) $id);

            if (!$page) {
                return response()->json(['message' => __('messages.page_not_found')], 404);
            }

            return response()->json([
                'message' => __('messages.page_retrieved_success'),
                'data' => new PageResource($page),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_page'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'title_en' => 'nullable|string|max:255',
                'title_ar' => 'nullable|string|max:255',
                'content_en' => 'nullable|string',
                'content_ar' => 'nullable|string',
            ]);

            $page = $this->pageService->update($id, $request->all());

            return response()->json([
                'message' => __('messages.page_updated_success'),
                'data' => new PageResource($page->load('contents')),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_page'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->pageService->delete((int) $id);

            return response()->json([
                'message' => __('messages.page_deleted_success'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_page'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
