<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\ItemResource;
use App\Services\ItemService;
use Exception;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function __construct(
        protected ItemService $itemService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'nullable|exists:categories,id',
                'search' => 'nullable|string|max:255',
            ]);

            $user = $request->user();

            $items = $this->itemService
                ->getAllForUser($user, $request->only('category_id', 'search'))
                ->paginate(10);

            return response()->json([
                'message' => __('messages.items_retrieved_success'),
                'data' => ItemResource::collection($items),
                'pagination' => PaginationHelper::paginate($items),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_items'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // general item data
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|string|max:255',
                'price_after_discount' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'lat' => 'nullable|string|max:255',
                'long' => 'nullable|string|max:255',
                'available_datetime' => 'nullable|date',
                'payment_platform' => 'nullable|in:cash,installment',
                'city_id' => 'nullable|exists:cities,id',
                'region_id' => 'nullable|exists:regions,id',
                'district' => 'nullable|string|max:255',
                'street' => 'nullable|string|max:255',
                'is_active' => 'nullable|boolean',
                'contact_name' => 'nullable|string|max:255',
                'contact_phone' => 'nullable|string|max:50',
                'contact_email' => 'nullable|email|max:255',
                'contact_type' => 'nullable|in:whatsapp,phone,email',
                'appear_in_item' => 'nullable|boolean',
            ]);

            // get all inputs for this category
            $category = Category::find($request->category_id);
            $input_names = $category->getCategoryInputsNames($request->category_id);
            // validate dynamic validation rules
            $validator = Validator::make($request->all(), $input_names);
            
            if ($validator->fails()) {
                return response()->json([
                    'message' => __('messages.invalid_inputs'),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = $request->user();

            $item = $this->itemService->createForUser($user, $request->all());

            return response()->json([
                'message' => __('messages.item_created_success'),
                'data' => new ItemResource($item),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_item'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, int $id)
    {
        try {
            $user = $request->user();
            $item = $this->itemService->getByIdForUser($id, $user);

            if (!$item) {
                return response()->json([
                    'message' => __('messages.item_not_found'),
                ], 404);
            }

            return response()->json([
                'message' => __('messages.item_retrieved_success'),
                'data' => new ItemResource($item),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_item'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'category_id' => 'nullable|exists:categories,id',
                'name' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|string|max:255',
                'price_after_discount' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'lat' => 'nullable|string|max:255',
                'long' => 'nullable|string|max:255',
                'available_datetime' => 'nullable|date',
                'payment_platform' => 'nullable|in:cash,installment',
                'city_id' => 'nullable|exists:cities,id',
                'region_id' => 'nullable|exists:regions,id',
                'district' => 'nullable|string|max:255',
                'street' => 'nullable|string|max:255',
                'is_active' => 'nullable|boolean',
                'contact_name' => 'nullable|string|max:255',
                'contact_phone' => 'nullable|string|max:50',
                'contact_email' => 'nullable|email|max:255',
                'contact_type' => 'nullable|in:whatsapp,phone,email',
                'appear_in_item' => 'nullable|boolean',
                'inputs' => 'nullable|array',
            ]);

            $user = $request->user();
            $item = $this->itemService->getByIdForUser($id, $user);

            if (!$item) {
                return response()->json([
                    'message' => __('messages.item_not_found'),
                ], 404);
            }

            $item = $this->itemService->updateForUser($item, $user, $request->all());

            return response()->json([
                'message' => __('messages.item_updated_success'),
                'data' => new ItemResource($item),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_item'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $user = $request->user();
            $item = $this->itemService->getByIdForUser($id, $user);

            if (!$item) {
                return response()->json([
                    'message' => __('messages.item_not_found'),
                ], 404);
            }

            $this->itemService->deleteForUser($item, $user);

            return response()->json([
                'message' => __('messages.item_deleted_success'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_item'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

