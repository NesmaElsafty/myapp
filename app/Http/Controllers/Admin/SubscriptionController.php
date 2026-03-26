<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SubscriptionService;
use App\Http\Resources\SubscriptionResource;
use App\Helpers\PaginationHelper;
use App\Helpers\ExportHelper;
use App\Models\Subscription;
use Exception;

class SubscriptionController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'sorted_by' => 'nullable|string|in:newest,oldest,all',
                'status' => 'nullable|string|in:active,expired,all',
                'user_type' => 'nullable|string|in:user,individual,origin,all',
                'plan_type' => 'nullable|string|in:one_post,many_posts,all',
            ]);

            $result = $this->subscriptionService->getAll($request->all())->paginate(10);

            return response()->json([
                'message' => __('messages.subscriptions_retrieved_success'),
                'data' => SubscriptionResource::collection($result),
                'pagination' => PaginationHelper::paginate($result),
                'stats' => $this->subscriptionService->stats(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_subscriptions'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // export subscriptions
    public function export(Request $request)
    {
        try {
        $ids = $this->subscriptionService->getAll($request->all())->pluck('id');
        $csvData = [];
        foreach ($ids as $id) {
            $subscription = Subscription::find($id);
            $csvData[] = [
                'id' => $subscription->id,
                'user_name' => $subscription->user->f_name . ' ' . $subscription->user->l_name,
                'user_type' => $subscription->user->type,
                'plan_name' => $subscription->plan->plan_type === 'one_post' ? $subscription->planDetail->category->name_en : $subscription->plan->posts_limit . ' posts',
                'posts_limit' => $subscription->plan->posts_limit,
                'available_posts_limit' => $subscription->available_posts_limit,
                'used_posts' => $subscription->plan_posts_limit - $subscription->available_posts_limit,
                'status' => $subscription->status,
                'start_date' => $subscription->start_date,
                'end_date' => $subscription->end_date,
                'created_at' => $subscription->created_at,
            ];
        }

        $filename = 'subscriptions_export_' . now()->format('Ymd_His') . '.csv';
        $media = ExportHelper::exportToMedia($csvData, auth()->user(), 'exports', $filename);
        
        return response()->json([
            'message' => __('messages.subscriptions_exported_success'),
            'data' => $media->getUrl(),
        ], 200);
        
    } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_export_subscriptions'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
