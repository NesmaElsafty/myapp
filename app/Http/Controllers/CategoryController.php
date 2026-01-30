<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
            ]);

            $categories = $this->categoryService->getAll($request->search)->get();

            return response()->json([
                'message' => 'Categories retrieved successfully',
                'data' => CategoryResource::collection($categories),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['message' => 'Category not found'], 404);
            }
            return response()->json([
                'message' => 'Category retrieved successfully',
                'data' => new CategoryResource($category),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve category',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_en' => 'required|string|unique:categories,name_en,|max:255',
                'name_ar' => 'required|string|unique:categories,name_ar,|max:255',
                'is_active' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $category = $this->categoryService->create($request->all());

            if($request->hasFile('image')) {
                $category->addMediaFromRequest('image')->toMediaCollection('image');
            }

            return response()->json([
                'message' => 'Category created successfully',
                'data' => new CategoryResource($category),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $category = $this->categoryService->update($id, $request->all());

            if($request->hasFile('image')) {
                $category->clearMediaCollection('image');
                $category->addMediaFromRequest('image')->toMediaCollection('image');
            }

            return response()->json([
                'message' => 'Category updated successfully',
                'data' => new CategoryResource($category),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update category',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['message' => 'Category not found'], 404);
            }
            $category->clearMediaCollection('image');
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully',
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete category',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
