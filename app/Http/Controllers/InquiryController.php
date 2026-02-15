<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\InquiryResource;
use App\Services\InquiryService;
use App\Models\Inquiry;
use Exception;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function __construct(
        protected InquiryService $inquiryService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'account_type' => 'nullable|string|in:user,individual,origin',
                'sorted_by' => 'nullable|string|in:newest,oldest,all,name',
            ]);

            $inquiries = $this->inquiryService->getAll($request->all(), $request->header('lang'))->paginate(10);

            return response()->json([
                'message' => __('messages.inquiries_retrieved_success'),
                'data' => InquiryResource::collection($inquiries),
                'pagination' => PaginationHelper::paginate($inquiries),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_inquiries'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:255',
                'message' => 'required|string',
                'account_type' => 'required|string|in:user,individual,origin',
                'files' => 'nullable|array',
            ]);

            $inquiry = $this->inquiryService->create($request->all());

            if($request->hasFile('files')) {
                foreach($request->file('files') as $file) {
                    $inquiry->addMedia($file)->toMediaCollection('files');
                }
            }

            return response()->json([
                'message' => __('messages.inquiry_created_success'),
                'data' => new InquiryResource($inquiry),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_inquiry'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $inquiry = $this->inquiryService->getById((int) $id);

            if (!$inquiry) {
                return response()->json(['message' => __('messages.inquiry_not_found')], 404);
            }

            return response()->json([
                'message' => __('messages.inquiry_retrieved_success'),
                'data' => new InquiryResource($inquiry),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_inquiry'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:255',
                'message' => 'nullable|string',
                'account_type' => 'nullable|string|in:user,individual,origin',
                'is_replied' => 'nullable|boolean',
                'reply_message' => 'nullable|string',
            ]);

            $inquiry = $this->inquiryService->update($id, $request->all());

            if($request->hasFile('files')) {
                $inquiry->clearMediaCollection('files');
                foreach($request->file('files') as $file) {
                    $inquiry->addMedia($file)->toMediaCollection('files');
                }
            }

            return response()->json([
                'message' => __('messages.inquiry_updated_success'),
                'data' => new InquiryResource($inquiry),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_inquiry'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function reply(Request $request, string $id)
    {
        try {
            $request->validate([
                'reply_message' => 'required|string',
            ]);

            $inquiry = $this->inquiryService->reply($id, $request->reply_message);

            return response()->json([
                'message' => __('messages.reply_sent_success'),
                'data' => new InquiryResource($inquiry),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_send_reply'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->inquiryService->delete((int) $id);

            return response()->json([
                'message' => __('messages.inquiry_deleted_success'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_inquiry'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // bulk actions
    public function bulkActions(Request $request)
    {
        try {
            $request->validate([
                'action' => 'required|in:delete,export',
                'inquiry_ids' => 'nullable|array|exists:inquiries,id',
            ]);

            $inquiry_ids = $request->inquiry_ids;

            if(!$inquiry_ids || count($inquiry_ids) === 0) {
                $inquiry_ids = Inquiry::pluck('id')->toArray();
            }
            
            switch ($request->action) {
                case 'delete':
                    $result = $this->inquiryService->bulkDelete($inquiry_ids);
                    break;
                case 'export':
                    $result = $this->inquiryService->export($inquiry_ids, $request->header('lang'));
                    break;
            }

            return response()->json([
                'message' => __('messages.bulk_actions_success'),
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_bulk_actions'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
