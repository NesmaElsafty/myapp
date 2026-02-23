<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\PaginationHelper;
use App\Http\Resources\BlogResource;
use App\Services\BlogService;
use Exception;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(
        protected BlogService $blogService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
            ]);

            $blogs = $this->blogService->getAll($request->all())->paginate(10);

            return response()->json([
                'message' => __('messages.blogs_retrieved_success'),
                'data' => BlogResource::collection($blogs),
                'pagination' => PaginationHelper::paginate($blogs),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_blogs'),
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $blog = $this->blogService->create($request->except('image'));

            $blog->addMediaFromRequest('image')->toMediaCollection('image');

            return response()->json([
                'message' => __('messages.blog_created_success'),
                'data' => new BlogResource($blog),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_blog'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $blog = $this->blogService->getById((int) $id);

            if (!$blog) {
                return response()->json(['message' => __('messages.blog_not_found')], 404);
            }

            return response()->json([
                'message' => __('messages.blog_retrieved_success'),
                'data' => new BlogResource($blog),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_blog'),
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
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'is_active' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $blog = $this->blogService->update($id, $request->except('image'));

            if ($request->hasFile('image')) {
                $blog->clearMediaCollection('image');
                $blog->addMediaFromRequest('image')->toMediaCollection('image');
            }

            return response()->json([
                'message' => __('messages.blog_updated_success'),
                'data' => new BlogResource($blog),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_blog'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->blogService->delete((int) $id);

            return response()->json([
                'message' => __('messages.blog_deleted_success'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_blog'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
