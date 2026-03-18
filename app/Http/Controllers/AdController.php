<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use App\Services\AdService;
use Exception;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function __construct(
        protected AdService $adService
    ) {}

    public function index(Request $request)
    { 
        try {
            $request->validate([
                'type' => 'nullable|string|in:promotion,interface',
            ]);
            $ads = $this->adService->getAll()->where('is_active', true)->where('type', $request->type)->take(5);

            return response()->json([
                'message' => __('messages.ads_retrieved_success'),
                'data' => AdResource::collection($ads),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_ads'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $ad = $this->adService->getById((int) $id);

            if (!$ad) {
                return response()->json(['message' => __('messages.ad_not_found')], 404);
            }

            return response()->json([
                'message' => __('messages.ad_retrieved_success'),
                'data' => new AdResource($ad),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_ad'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}