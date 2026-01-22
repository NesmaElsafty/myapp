<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\SupportResource;
use App\Services\SupportService;
use App\Models\Support;
use Exception;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function __construct(
        protected SupportService $supportService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'account_type' => 'nullable|string|in:user,individual,origin',
                'sorted_by' => 'nullable|string|in:newest,oldest,all,name',
            ]);

            $supports = $this->supportService->getAll($request->all(), $request->header('lang'))->paginate(10);

            return response()->json([
                'message' => 'Support tickets retrieved successfully',
                'data' => SupportResource::collection($supports),
                'pagination' => PaginationHelper::paginate($supports),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve support tickets',
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

            $support = $this->supportService->create($request->all());

            if($request->hasFile('files')) {
                foreach($request->file('files') as $file) {
                    $support->addMedia($file)->toMediaCollection('files');
                }
            }

            return response()->json([
                'message' => 'Support ticket created successfully',
                'data' => new SupportResource($support),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create support ticket',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $support = $this->supportService->getById((int) $id);

            if (!$support) {
                return response()->json(['message' => 'Support ticket not found'], 404);
            }

            return response()->json([
                'message' => 'Support ticket retrieved successfully',
                'data' => new SupportResource($support),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve support ticket',
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
                'account_type' => 'nullable|string|in:user,individual,agent,origin',
                'is_replied' => 'nullable|boolean',
                'reply_message' => 'nullable|string',
            ]);

            $support = $this->supportService->update($id, $request->all());

            if($request->hasFile('files')) {
                $support->clearMediaCollection('files');
                foreach($request->file('files') as $file) {
                    $support->addMedia($file)->toMediaCollection('files');
                }
            }

            return response()->json([
                'message' => 'Support ticket updated successfully',
                'data' => new SupportResource($support),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update support ticket',
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

            $support = $this->supportService->reply($id, $request->reply_message);

            return response()->json([
                'message' => 'Reply sent successfully',
                'data' => new SupportResource($support),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to send reply',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->supportService->delete((int) $id);

            return response()->json([
                'message' => 'Support ticket deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete support ticket',
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
                'support_ids' => 'nullable|array|exists:supports,id',
            ]);

            $support_ids = $request->support_ids;

            if(!$support_ids || count($support_ids) === 0) {
                $support_ids = Support::pluck('id')->toArray();
            }
            
            switch ($request->action) {
                case 'delete':
                    $result = $this->supportService->bulkDelete($support_ids);
                    break;
                case 'export':
                    $result = $this->supportService->export($support_ids, $request->header('lang'));
                    break;
            }

            return response()->json([
                'message' => 'Bulk actions performed successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to perform bulk actions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
