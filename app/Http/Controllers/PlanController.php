<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use App\Http\Resources\PlanResource;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;
use App\Models\Plan;
class PlanController extends Controller
{
    //

    public function __construct(
        protected PlanService $planService
    ) {}


    public function index(Request $request)
    {
        $request->validate([
            'target_user' => 'nullable|string|in:individual,origin',
            'plan_type' => 'nullable|string|in:one_post,many_posts',
        ]);

        // add is_active filter
        $request->merge(['is_active' => true]);

        try {
            $plans = $this->planService->getAll($request->all(), app()->getLocale())->paginate(10);
            return response()->json([
                'message' => __('messages.plans_retrieved_success'),
                'data' => PlanResource::collection($plans),
                'pagination' => PaginationHelper::paginate($plans),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_to_get_plans'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json(['message' => __('messages.plan_not_found')], 404);
        }

        return response()->json([
            'message' => __('messages.plan_retrieved_success'),
            'data' => new PlanResource($plan),
        ], 200);
        
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_to_get_plan'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
