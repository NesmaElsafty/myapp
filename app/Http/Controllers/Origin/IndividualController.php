<?php

namespace App\Http\Controllers\Origin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use App\Helpers\PaginationHelper;
use App\Http\Resources\IndividualResource;
use App\Notifications\IndividualAddedToOrigin;
use App\Services\AlertService;

class IndividualController extends Controller
{
    
    protected $alertService;
    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }
    public function addIndividual(Request $request)
    {
        try {
            $request->validate([
                'individual_id' => 'required|exists:users,id',
            ]);

            $origin = auth()->user();
            $individual = User::find($request->individual_id);

            if ($origin->type !== 'origin') {
                return response()->json([
                    'message' => __('messages.you_are_not_an_origin'),
                ], 403);
            }

            if ($individual->type !== 'individual') {
                return response()->json([
                    'message' => __('messages.individual_not_found'),
                ], 404);
            }

            $individual->origin_id = $origin->id;
            $individual->save();

            // send alert to the individual
            $data = [
                'title_en' => $origin->f_name . ' ' . $origin->l_name . ' has added you to their origin',
                'title_ar' => 'تم إضافتك إلى الشركه ' . $origin->f_name . ' ' . $origin->l_name,
                'content_en' => 'You have been added to ' . $origin->f_name . ' ' . $origin->l_name . '\'s origin',
                'content_ar' => 'تمت إضافتك إلى الشركة ' . $origin->f_name . ' ' . $origin->l_name,
                'user_id' => $individual->id,
            ];
            
            $this->alertService->create($data);

            return response()->json([
                'message' => __('messages.individual_added_to_origin'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_to_add_individual_to_origin'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // get all individuals for an origin
    public function getIndividualRequests(Request $request)
    {
        try {
            $origin = auth()->user();

            $individuals = User::where(['requested_origin_id' => $origin->id, 'origin_request_status' => 'pending'])->paginate(10);

            return response()->json([
                'message' => __('messages.individuals_retrieved_success'),
                'data' => IndividualResource::collection($individuals),
                'pagination' => PaginationHelper::paginate($individuals),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_to_get_individuals'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // approve or reject an individual request
    public function changeRequestStatus(Request $request)
    {
        try {
            $request->validate([
                'individual_id' => 'required|exists:users,id',
                'status' => 'required|in:approved,rejected',
            ]);

            $origin = auth()->user();
            $individual = User::find($request->individual_id);

            if ($individual->type !== 'individual') {
                return response()->json([
                    'message' => __('messages.individual_not_found'),
                ], 404);
            }

            
            if ((int) $individual->requested_origin_id !== $origin->id) {
                return response()->json([
                    'message' => __('messages.unauthorized_request'),
                ], 403);
            }
            
            $individual->origin_request_status = $request->status;
            $individual->requested_origin_id = null;
            $individual->origin_id = $request->status === 'approved' ? $origin->id : null;
            $individual->save();

            $status_en = $request->status === 'approved' ? 'approved' : 'rejected';
            $status_ar = $request->status === 'approved' ? 'قبول' : 'رفض';

            $data = [
                'title_en' => $origin->f_name . ' ' . $origin->l_name . ' ' . $status_en . ' your request',
                'title_ar' => 'تم ' . $status_ar . ' طلبك من قبل ' . $origin->f_name . ' ' . $origin->l_name,
                'content_en' => 'Your request has been ' . $status_en . ' by ' . $origin->f_name . ' ' . $origin->l_name,
                'content_ar' => 'تم ' . $status_ar . ' طلبك من قبل ' . $origin->f_name . ' ' . $origin->l_name,
                'user_id' => $individual->id,
            ];
            
            $this->alertService->create($data);

            return response()->json([
                'message' => __('messages.request_status_changed_success'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_to_change_request_status'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // get all individuals for an origin
    public function myIndividuals(Request $request)
    {
        try {
            $origin = auth()->user();
            $individuals = User::where('origin_id', $origin->id)->where('type', 'individual')->paginate(10);
            return response()->json([
                'message' => __('messages.individuals_retrieved_success'),
                'data' => IndividualResource::collection($individuals),
                'pagination' => PaginationHelper::paginate($individuals),
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_to_get_individuals'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // remove an individual from an origin
    public function removeIndividual(Request $request)
    {
        try {
            $request->validate([
                'individual_id' => 'required|exists:users,id',
            ]);

            $origin = auth()->user();
            $individual = User::find($request->individual_id);

            if ($individual->origin_id !== $origin->id) {
                return response()->json([
                    'message' => __('messages.unauthorized_request'),
                ], 403);
            }
            
            $individual->origin_id = null;
            $individual->requested_origin_id = null;
            $individual->origin_request_status = null;
            $individual->save();

            $data = [
                'title_en' => $origin->f_name . ' ' . $origin->l_name . ' has removed you from their origin',
                'title_ar' => 'تم إزالتك من الشركة ' . $origin->f_name . ' ' . $origin->l_name,
                'content_en' => 'You have been removed from ' . $origin->f_name . ' ' . $origin->l_name . '\'s origin',
                'content_ar' => 'تم إزالتك من الشركة ' . $origin->f_name . ' ' . $origin->l_name,
                'user_id' => $individual->id,
            ];
            
            $this->alertService->create($data);

            return response()->json([
                'message' => __('messages.individual_removed_from_origin_success'),
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_to_remove_individual'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}