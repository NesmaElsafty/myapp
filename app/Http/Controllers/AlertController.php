<?php

namespace App\Http\Controllers;

use App\Http\Resources\AlertResource;
use App\Services\AlertService;
use Exception;
use Illuminate\Http\Request;
class AlertController extends Controller
{
    protected $alertService;
    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }
    // mark as read
    public function markAsRead(Request $request)
    {
        try {
            dd($request->all());
            $request->validate([
                'id' => 'required|integer|exists:alerts,id',
            ]);
            $user = $request->user();
            if($user->id != $request->id) {
                return response()->json([
                    'message' => __('messages.not_authorized_mark_alert_read'),
                ], 403);
            }
            $alert = $this->alertService->markAsRead($request->id);
            
            return response()->json([
                'message' => __('messages.alert_marked_read_success'),
                'data' => new AlertResource($alert),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_mark_alert_read'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
