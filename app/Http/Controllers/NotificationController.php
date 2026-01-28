<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\NotificationResource;
use App\Services\AlertService;
use App\Services\NotificationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Notification;

class NotificationController extends Controller
{
    protected $notificationService;
    protected $alertService;
    public function __construct(NotificationService $notificationService, AlertService $alertService)
    {
        $this->notificationService = $notificationService;
        $this->alertService = $alertService;
    }

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'type' => 'nullable|string|in:reminder,alert,notification,all',
                'target_type' => 'nullable|array|in:user,individual,origin,all',
                'status' => 'nullable|string|in:sent,scheduled,unsent,all',
                'sorted_by' => 'nullable|string|in:title,newest,oldest,all',
            ]);

            $notifications = $this->notificationService->getAll($request->all(), $request->header('lang'))->paginate(10);

            return response()->json([
                'message' => 'Notifications retrieved successfully',
                'data' => NotificationResource::collection($notifications),
                'pagination' => PaginationHelper::paginate($notifications),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve notifications',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_en' => 'required|string',
                'title_ar' => 'required|string',
                'content_en' => 'required|string',
                'content_ar' => 'required|string',
                'type' => 'required|in:reminder,alert,notification',
                'target_type' => 'required|array|min:1|max:3',
                'target_type.*' => 'required|in:user,individual,origin,admin',
                'status' => 'required|in:sent,scheduled,unsent',
            ]);

            $notification = $this->notificationService->create($request->all());

            if($notification->status == 'sent') {
                $this->alertService->create($request->all(), $notification->id);
            }
            return response()->json([
                'message' => 'Notification created successfully',
                'data' => new NotificationResource($notification),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create notification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $notification = Notification::find($id);
            if (!$notification) {
                return response()->json([
                    'message' => 'Notification not found',
                ], 404);
            }
            return response()->json([
                'data' => new NotificationResource($notification),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Notification not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title_en' => 'nullable|string',
                'title_ar' => 'nullable|string',
                'content_en' => 'nullable|string',
                'content_ar' => 'nullable|string',
                'type' => 'nullable|in:reminder,alert,notification',
                'target_type' => 'nullable|array|min:1|max:3',
                'target_type.*' => 'nullable|in:user,individual,origin',
                'status' => 'nullable|in:sent,scheduled,unsent',
            ]);

            $notification = $this->notificationService->update($id, $request->all());

            return response()->json([
                'message' => 'Notification updated successfully',
                'data' => new NotificationResource($notification),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update notification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->notificationService->delete($id);
            return response()->json([
                'message' => 'Notification deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete notification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:sent,scheduled,unsent',
            ]);

            $notification = $this->notificationService->updateStatus($id, $request->status);

            return response()->json([
                'message' => 'Notification status updated successfully',
                'data' => new NotificationResource($notification),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update notification status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function bulkActions(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'action' => 'required|in:delete',
                'ids' => 'required|array',
                'ids.*' => 'exists:notifications,id',
            ]);

            $deleted = $this->notificationService->bulkDelete($request->ids);

            return response()->json([
                'message' => 'Notifications deleted successfully',
                'deleted' => $deleted,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to perform bulk action',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // notify
    public function notify(Request $request)
    {
        try {
            $request->validate([
                'notification_id' => 'required|integer|exists:notifications,id',
            ]);

            $notification = $this->notificationService->getById($request->notification_id);
            $alert = $this->alertService->create([], $request->notification_id);

            return response()->json([
                'message' => 'Alert created successfully',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }
}

