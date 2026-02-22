<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Services\PlanService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Feature;
use App\Http\Resources\FeatureResource;
class PlanController extends Controller
{
    public function __construct(
        protected PlanService $planService
    ) {}
    
    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'target_user' => 'nullable|string|in:individual,origin,all',
                'is_active' => 'nullable|in:1,0,all',
                'sorted_by' => 'nullable|string|in:name,newest,oldest,all',
                'official_duration' => 'nullable|string|in:1,3,6,12,all',
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
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'official_duration' => 'nullable|string|max:255',
                'free_duration' => 'nullable|string|max:255',
                'posts_limit' => 'nullable|string|max:255',
                'target_user' => 'required|in:individual,origin',
                'is_active' => 'nullable|boolean',
                'features' => 'nullable|array',
                'features.*' => 'exists:features,id',
            ]);

            $plan = $this->planService->create($request->all());

            if($request->has('features')) {
                $plan->features()->attach($request->features);
            }

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
            $request->validate([
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'nullable|string|max:255',
                'price' => 'nullable|numeric|min:0',
                'official_duration' => 'nullable|string|max:255',
                'free_duration' => 'nullable|string|max:255',
                'posts_limit' => 'nullable|string|max:255',
                'target_user' => 'nullable|in:individual,origin',
                'is_active' => 'nullable|boolean',
                'features' => 'nullable|array',
                'features.*' => 'exists:features,id',
            ]);

            $plan = $this->planService->update((int) $id, $request->all());

            if($request->has('features')) {
                $plan->features()->sync($request->features);
            }

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
            ], 500);
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

    public function features(Request $request)
    {
        try {
            $features = Feature::all();
            return response()->json([
                'message' => __('messages.features_retrieved_success'),
                'data' => FeatureResource::collection($features),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_features'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
