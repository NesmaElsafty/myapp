<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Http\Resources\PromotionResource;
use Exception;
class PromotionController extends Controller
{
    //
    public function index()
    {
        try {
            $promotions = Promotion::all();
            return response()->json([
                'message' => __('messages.promotions_retrieved_success'),
                'data' => PromotionResource::collection($promotions),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => __('messages.failed_to_get_promotions'), 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $promotion = Promotion::find($id);
            if (!$promotion) {
                return response()->json(['message' => __('messages.promotion_not_found')], 404);
            }
            return response()->json([
                'message' => __('messages.promotion_retrieved_success'),
                'data' => new PromotionResource($promotion),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => __('messages.failed_to_get_promotion'), 'error' => $e->getMessage()], 500);
        }
    }
}
