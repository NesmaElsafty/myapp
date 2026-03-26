<?php

namespace App\Http\Controllers\advertiser;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Services\SubscriptionService;
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

            $result = $this->subscriptionService->mySubscriptions(auth()->user(), $request->type);

            return response()->json([
                'message' => 'Subscriptions retrieved successfully.',
                'data' => SubscriptionResource::collection($result),
                'pagination' => PaginationHelper::paginate($result),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve subscriptions.',
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
                'gold_posts' => 'required|integer|min:0',
                'silver_posts' => 'required|integer|min:0',
            ]);

            $subscription = $this->subscriptionService->createSubscription(auth()->user(), $request->all());

            return response()->json([
                'message' => 'Subscription created successfully.',
                'data' => new SubscriptionResource($subscription),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create subscription.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'action' => 'required|in:renew,cancel',
                'plan_id' => 'nullable|exists:plans,id',
                'plan_detail_id' => 'nullable|exists:plan_details,id',
            ]);

            $subscription = Subscription::find($id);
            if (!$subscription) {
                return response()->json([
                    'message' => 'Subscription not found.',
                ], 404);
            }

            $updatedSubscription = $this->subscriptionService->updateSubscription(
                $request->user(),
                $subscription,
                $request->all()
            );

            return response()->json([
                'message' => 'Subscription updated successfully.',
                'data' => new SubscriptionResource($updatedSubscription),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update subscription.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
