<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\ScreenService;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected ScreenService $screenService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
            ]);

            $categories = $this->categoryService->getAll($request->search)->get();

            return response()->json([
                'message' => __('messages.categories_retrieved_success'),
                'data' => CategoryResource::collection($categories),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_categories'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            
            $category = Category::find($id);
            
            dd($category->getCategoryInputsName($id));
            if (!$category) {
                return response()->json(['message' => __('messages.category_not_found')], 404);
            }
            return response()->json([
                'message' => __('messages.category_retrieved_success'),
                'data' => new CategoryResource($category),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_category'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Get screens by category ID with inputs loaded.
     */
    public function screens($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['message' => __('messages.category_not_found')], 404);
            }
            $screens = $this->screenService->getByCategoryId((int) $id);
            return response()->json([
                'message' => __('messages.screens_retrieved_success'),
                'data' => \App\Http\Resources\ScreenResource::collection($screens),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_screens'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_en' => 'required|string|unique:categories,name_en,|max:255',
                'name_ar' => 'required|string|unique:categories,name_ar,|max:255',
                'is_active' => 'nullable|boolean',
                'types' => 'nullable|array',
                'types.*.label_en' => 'nullable|string|max:255',
                'types.*.label_ar' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'screens' => 'nullable|array',
                'screens.*.name_en' => 'required|string|max:255',
                'screens.*.name_ar' => 'required|string|max:255',
                'screens.*.description_en' => 'nullable|string',
                'screens.*.description_ar' => 'nullable|string',
            ]);

            $category = $this->categoryService->create($request->all());

            if($request->hasFile('image')) {
                $category->addMediaFromRequest('image')->toMediaCollection('image');
            }

            // create screens for the category
            if($request->has('screens')) {
                $screens = $request->screens;
                foreach($screens as $screen) {
                    $this->screenService->create([
                        'name_en' => $screen['name_en'],
                        'name_ar' => $screen['name_ar'],
                        'description_en' => $screen['description_en'] ?? null,
                        'description_ar' => $screen['description_ar'] ?? null,
                        'category_id' => $category->id,
                    ]);
                }
            }

            return response()->json([
                'message' => __('messages.category_created_success'),
                'data' => new CategoryResource($category->load('screens')),
            ], 201);    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name_en' => 'nullable|string|unique:categories,name_en,' . $id . ',id|max:255',
                'name_ar' => 'nullable|string|unique:categories,name_ar,' . $id . ',id|max:255',
                'is_active' => 'nullable|boolean',
                'types' => 'nullable|array',
                'types.*.label_en' => 'nullable|string|max:255',
                'types.*.label_ar' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'screens' => 'nullable|array',
                'screens.*.name_en' => 'nullable|string|max:255',
                'screens.*.name_ar' => 'nullable|string|max:255',
                'screens.*.description_en' => 'nullable|string',
                'screens.*.description_ar' => 'nullable|string',
            ]);

            $category = $this->categoryService->update($id, $request->all());

            if($request->hasFile('image')) {
                $category->clearMediaCollection('image');
                $category->addMediaFromRequest('image')->toMediaCollection('image');
            }

            // create screens for the category
            if($request->has('screens')) {
                $screens = $request->screens;
                
                foreach($screens as $screen) {
                    $category->screens()->updateOrCreate(
                        [
                            'name_en' => $screen['name_en'],
                            'name_ar' => $screen['name_ar'],
                        ],
                        [
                            'description_en' => $screen['description_en'] ?? null,
                            'description_ar' => $screen['description_ar'] ?? null,
                        ]
                    );
                }
            }
            return response()->json([
                'message' => __('messages.category_updated_success'),
                    'data' => new CategoryResource($category->load('screens')),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_category'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['message' => __('messages.category_not_found')], 404);
            }
            $category->clearMediaCollection('image');
            $category->delete();
            return response()->json([
                'message' => __('messages.category_deleted_success'),
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_category'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
