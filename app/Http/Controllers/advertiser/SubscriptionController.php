<?php

namespace App\Http\Controllers\advertiser;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubscriptionController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService
    ) {}

    public function mySubscriptions(Request $request)
    {
        try {
            $request->validate([
                'type' => 'nullable|string|in:current,history',
            ]);

            $result = $this->subscriptionService->mySubscriptions(auth()->user(), $request->input('type', 'current'));

            return response()->json([
                'message' => __('messages.subscriptions_retrieved_success'),
                'data' => SubscriptionResource::collection($result),
                'pagination' => PaginationHelper::paginate($result),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_subscriptions'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'plan_id' => 'required|exists:plans,id',
                'plan_detail_id' => 'required|exists:plan_details,id',
                'golden_posts' => 'nullable|integer|min:0',
                'silver_posts' => 'nullable|integer|min:0',
            ]);

            $subscription = $this->subscriptionService->createSubscription(auth()->user(), $request->all());

            return response()->json([
                'message' => __('messages.subscription_created_success'),
                'data' => new SubscriptionResource($subscription),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_subscription'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function cancel($id)
    {
        try {
            $subscription = Subscription::find($id);

            if(!$subscription) {
                return response()->json([
                    'message' => __('messages.subscription_not_found'),
                ], 404);
            }

            if($subscription->user_id !== auth()->user()->id) {
                return response()->json([
                    'message' => __('messages.unauthorized_cancel_subscription'),
                ], 404);
            }

            $subscription->status = 'cancelled';
            $subscription->end_date = Carbon::today();
            $subscription->save();

            return response()->json([
                'message' => __('messages.subscription_cancelled_success'),
                'data' => new SubscriptionResource($subscription),
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_cancel_subscription'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
