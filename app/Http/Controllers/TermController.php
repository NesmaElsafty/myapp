<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\TermResource;
use App\Services\TermService;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;

class TermController extends Controller
{

    public function __construct(
        protected TermService $termService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'type' => 'nullable|string|in:terms,privacy',
                'is_active' => 'nullable|boolean',
                'sorted_by' => 'nullable|string|in:newest,oldest,all,name',
            ]);

            $terms = $this->termService->getAll($request->all(), $request->header('lang'))->paginate(10);

            return response()->json([
                'message' => 'Terms retrieved successfully',
                'data' => TermResource::collection($terms),
                'pagination' => PaginationHelper::paginate($terms),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve terms',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'content_en' => 'required|string',
                'content_ar' => 'required|string',
                'type' => 'nullable|string|in:terms,privacy',
                'is_active' => 'nullable|boolean',
            ]);

            $term = $this->termService->create($request->all());

            return response()->json([
                'message' => 'Term created successfully',
                'data' => new TermResource($term),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create term',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $term = $this->termService->getById((int) $id);

            if (!$term) {
                return response()->json(['message' => 'Term not found'], 404);
            }

            return response()->json([
                'message' => 'Term retrieved successfully',
                'data' => new TermResource($term),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve term',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'title_en' => 'nullable|string|max:255',
                'title_ar' => 'nullable|string|max:255',
                'content_en' => 'nullable|string',
                'content_ar' => 'nullable|string',
                'type' => 'nullable|string|in:terms,privacy',
                'is_active' => 'nullable|boolean',
            ]);

            $term = $this->termService->update($id, $request->all());

            return response()->json([
                'message' => 'Term updated successfully',
                'data' => new TermResource($term),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update term',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->termService->delete((int) $id);

            return response()->json([
                'message' => 'Term deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete term',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // bulk actions
    public function bulkActions(Request $request)
    {
        try {
            $request->validate([
                'action' => 'required|in:toggleActive,delete,export',
                'term_ids' => 'nullable|array|exists:terms,id',
            ]);

            $term_ids = $request->term_ids;

            if(!$term_ids || count($term_ids) === 0) {
                $term_ids = Term::pluck('id')->toArray();
            }
            
            switch ($request->action) {
                case 'toggleActive':
                    $result = $this->termService->toggleActive($term_ids);
                    break;
                case 'delete':
                    $result = $this->termService->bulkDelete($term_ids);
                    break;
                case 'export':
                    $result = $this->termService->export($term_ids, $request->header('lang'));
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
