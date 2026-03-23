<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Resources\PromotionResource;
use Exception;

class PromotionController extends Controller
{
    //
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'id' => 'required|exists:promotions,id',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
            ]);
            $promotion = Promotion::find($id);
            if (!$promotion) {
                return response()->json(['message' => __('messages.promotion_not_found')], 404);
            }
            $promotion->update([
                'description_en' => $request->description_en ?? $promotion->description_en,
                'description_ar' => $request->description_ar ?? $promotion->description_ar,
                'price' => $request->price ?? $promotion->price,
            ]);
            return response()->json(['message' => __('messages.promotion_updated_success'), 'data' => new PromotionResource($promotion)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => __('messages.failed_to_update_promotion'), 'error' => $e->getMessage()], 500);
        }
    }
}
