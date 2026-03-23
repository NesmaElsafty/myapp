<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\PaginationHelper;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Services\PlanService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlanController extends Controller
{
    public function __construct(
        protected PlanService $planService
    ) {}
    
    public function index(Request $request)
    {
        try {
            $request->validate([
                'target_user' => 'nullable|string|in:individual,origin,all',
                'is_active' => 'nullable|in:1,0,all',
                'plan_type' => 'nullable|string|in:one_post,many_posts,all',
                'sorted_by' => 'nullable|string|in:newest,oldest,all',
            ]);

            $plans = $this->planService->getAll($request->all(), app()->getLocale())->paginate(10);

            return response()->json([
                'message' => __('messages.plans_retrieved_success'),
                'data' => PlanResource::collection($plans),
                'pagination' => PaginationHelper::paginate($plans),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_plans'),
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
                'plan' => new PlanResource($plan),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_plan'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request)
    {
        // dd($request->details[0]['duration']);
        try {
            $request->validate([
                'target_user' => 'required|in:individual,origin',
                'plan_type' => 'required|in:one_post,many_posts',
                'posts_limit' => 'required|integer|min:1',
                'is_active' => 'required|boolean',
                'details' => 'required|array',
            ]);

            $onePostData = [
                'details.*.price' => 'required|numeric|min:0',
                'details.*.duration' => 'required|integer|min:0',
                'details.*.category_id' => 'required|exists:categories,id',
                'details.*.is_promoted' => 'required|boolean',
                'details.*.promotion_type' => 'nullable|in:gold,silver',
            ];

            $manyPostsData = [
                'details.*.price' => 'required|numeric|min:0',
                'details.*.duration' => 'required|integer|min:0',
                'details.*.free_trial_duration' => 'required|integer|min:0',
                'details.*.free_trial_duration_type' => 'required|in:days,months,years',
            ];

            
            if($request->plan_type === 'one_post') {
                $request->validate($onePostData);
            } else {
                $request->validate($manyPostsData);
            }

            $plan = $this->planService->create($request->all());

            return response()->json([
                'message' => __('messages.plan_created_success'),
                'data' => new PlanResource($plan),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_plan'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $plan = Plan::find($id);
            if (!$plan) {
                return response()->json(['message' => __('messages.plan_not_found')], 404);
            }
            $request->validate([
                'target_user' => 'required|in:individual,origin',
                'plan_type' => 'required|in:one_post,many_posts',
                'posts_limit' => 'required|integer|min:1',
                'is_active' => 'required|boolean',
                'details' => 'required|array',
            ]);

            $onePostData = [
                'details.*.price' => 'required|numeric|min:0',
                'details.*.duration' => 'required|integer|min:0',
                'details.*.category_id' => 'required|exists:categories,id',
                'details.*.is_promoted' => 'required|boolean',
                'details.*.promotion_type' => 'nullable|in:gold,silver',
            ];

            $manyPostsData = [
                'details.*.price' => 'required|numeric|min:0',
                'details.*.duration' => 'required|integer|min:0',
                'details.*.free_trial_duration' => 'required|integer|min:0',
                'details.*.free_trial_duration_type' => 'required|in:days,months,years',
            ];

            
            if($request->plan_type === 'one_post') {
                $request->validate($onePostData);
            } else {
                $request->validate($manyPostsData);
            }

            $plan = $this->planService->update($plan, $request->all());

            return response()->json([
                'message' => __('messages.plan_updated_success'),
                'data' => new PlanResource($plan),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_plan'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $plan = Plan::find($id);
            
            if (!$plan) {
                return response()->json(['message' => __('messages.plan_not_found')], 404);
            }
            $plan->delete();

            return response()->json([
                'message' => __('messages.plan_deleted_success'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_plan'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function bulkActions(Request $request)
    {
        try {
            $request->validate([
                'action' => 'required|in:toggleActive,delete,export',
                'plan_ids' => 'nullable|array',
                'plan_ids.*' => 'exists:plans,id',
            ]);

            $planIds = $request->plan_ids;

            if (!$planIds || count($planIds) === 0) {
                $planIds = Plan::pluck('id')->toArray();
            }

            switch ($request->action) {
                case 'toggleActive':
                    $this->planService->toggleActive($planIds);
                    $result = ['toggled' => count($planIds)];
                    break;
                case 'delete':
                    $this->planService->bulkDelete($planIds);
                    $result = ['deleted' => count($planIds)];
                    break;
                case 'export':
                    $result = $this->planService->export($planIds, app()->getLocale());
                    break;
                default:
                    $result = [];
            }

            return response()->json([
                'message' => __('messages.bulk_action_success'),
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_bulk_action'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
