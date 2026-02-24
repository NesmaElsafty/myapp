<?php

namespace App\Http\Controllers\Individual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AlertService;
use App\Models\User;

class OriginController extends Controller
{
    protected $alertService;
    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    // request to join an origin
    public function requestToJoinOrigin(Request $request)
    {
        try {
            $request->validate([
                'origin_id' => 'required|exists:users,id',
            ]);

            $individual = auth()->user();
            $origin = User::find($request->origin_id);

            if ($origin->type !== 'origin') {
                return response()->json([
                    'message' => __('messages.origin_not_found'),
                ], 404);
            }
            if ($individual->origin_id === $origin->id) {
                return response()->json([
                    'message' => __('messages.you_are_already_in_this_origin'),
                ], 400);
            }

            $individual->requested_origin_id = $origin->id;
            $individual->origin_request_status = 'pending';
            $individual->save();

            $data = [
                'title_en' => $individual->f_name . ' ' . $individual->l_name . ' has requested to join your origin',
                'title_ar' => 'تم طلب الانضمام إلى الشركة ' . $individual->f_name . ' ' . $individual->l_name,
                'content_en' => 'You have requested to join ' . $individual->f_name . ' ' . $individual->l_name . '\'s origin',
                'content_ar' => 'تم طلب الانضمام إلى الشركة ' . $individual->f_name . ' ' . $individual->l_name,
                'user_id' => $origin->id,
            ];

            $this->alertService->create($data);

        return response()->json([
            'message' => __('messages.request_to_join_origin_success'),
        ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_to_request_to_join_origin'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // signout from an origin
    public function signoutFromOrigin(Request $request)
    {
        try {
            $request->validate([
                'origin_id' => 'required|exists:users,id',
            ]);

            $individual = auth()->user();
            $origin = User::find($request->origin_id);

            if ($individual->origin_id !== $origin->id) {
                return response()->json([
                    'message' => __('messages.you_are_not_in_this_origin'),
                ], 403);
            }

            $individual->origin_id = null;
            $individual->requested_origin_id = null;
            $individual->origin_request_status = null;
            $individual->save();
            
            $data = [
                'title_en' => $individual->f_name . ' ' . $individual->l_name . ' has signed you out from your origin',
                'title_ar' => 'تم إنهاء الانضمام إلى شركتك من قبل ' . $individual->f_name . ' ' . $individual->l_name,
                'content_en' => 'You have been signed out from your origin by ' . $individual->f_name . ' ' . $individual->l_name,
                'content_ar' => 'تم إنهاء الانضمام إلى شركتك من قبل ' . $individual->f_name . ' ' . $individual->l_name,
                'user_id' => $origin->id,
            ];
            
            $this->alertService->create($data);
        
        return response()->json([
            'message' => __('messages.signout_from_origin_success'),
        ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_to_signout_from_origin'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
