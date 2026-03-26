<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use App\Http\Resources\PlanResource;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;
use App\Models\Plan;
use App\Http\Resources\PlanDetailsResource;
class PlanController extends Controller
{
    //

    public function __construct(
        protected PlanService $planService
    ) {}


    public function index(Request $request)
    {
        try {
            $request->validate([
                'target_user' => 'required|string|in:individual,origin',
                'plan_type' => 'required|string|in:one_post,many_posts',
            ]);
            
            if($request->plan_type === 'one_post') {

                $request->validate([
                    'target_user' => 'required|string|in:individual,origin',
                    'plan_type' => 'required|string|in:one_post,many_posts',
                    'is_promoted' => 'required|boolean',
                ]);

                $plans = $this->planService->advertisedPlansOnePost($request->all(), app()->getLocale());
                
                return response()->json([
                    'message' => __('messages.plans_retrieved_success'),
                    'data' => PlanDetailsResource::collection($plans),
                ], 200);    
            
            } else {
            
                $plans = $this->planService->advertisedPlansManyPosts($request->all(), app()->getLocale())->get();
            
                return response()->json([
                    'message' => __('messages.plans_retrieved_success'),
                    'data' => PlanResource::collection($plans),
                ], 200);
            }
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
