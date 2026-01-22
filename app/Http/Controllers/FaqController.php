<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Resources\FaqResource;
use App\Services\FaqService;
use Exception;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct(
        protected FaqService $faqService
    ) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'segment' => 'nullable|string|in:user,origin,individual',
                'is_active' => 'nullable|boolean',
                'sorted_by' => 'nullable|string|in:newest,oldest,all,name',
            ]);

            $faqs = $this->faqService->getAll($request->all(), $request->header('lang'))->paginate(10);

            return response()->json([
                'message' => 'FAQs retrieved successfully',
                'data' => FaqResource::collection($faqs),
                'pagination' => PaginationHelper::paginate($faqs),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve FAQs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'question_en' => 'required|string|max:255',
                'question_ar' => 'required|string|max:255',
                'answer_en' => 'required|string',
                'answer_ar' => 'required|string',
                'segment' => 'nullable|string|in:user,origin,individual',
                'is_active' => 'nullable|boolean',
            ]);

            $faq = $this->faqService->create($request->all());

            return response()->json([
                'message' => 'FAQ created successfully',
                'data' => new FaqResource($faq),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create FAQ',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $faq = $this->faqService->getById((int) $id);

            if (!$faq) {
                return response()->json(['message' => 'FAQ not found'], 404);
            }

            return response()->json([
                'message' => 'FAQ retrieved successfully',
                'data' => new FaqResource($faq),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve FAQ',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'question_en' => 'nullable|string|max:255',
                'question_ar' => 'nullable|string|max:255',
                'answer_en' => 'nullable|string',
                'answer_ar' => 'nullable|string',
                'segment' => 'nullable|string|in:user,origin,individual',
                'is_active' => 'nullable|boolean',
            ]);

            $faq = $this->faqService->update($id, $request->all());

            return response()->json([
                'message' => 'FAQ updated successfully',
                'data' => new FaqResource($faq),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update FAQ',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->faqService->delete((int) $id);

            return response()->json([
                'message' => 'FAQ deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete FAQ',
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
                'faq_ids' => 'nullable|array|exists:faqs,id',
            ]);

            $faq_ids = $request->faq_ids;

            if(!$faq_ids || count($faq_ids) === 0) {
                $faq_ids = Faq::pluck('id')->toArray();
            }
            
            switch ($request->action) {
                case 'toggleActive':
                    $result = $this->faqService->toggleActive($faq_ids);
                    break;
                case 'delete':
                    $result = $this->faqService->bulkDelete($faq_ids);
                    break;
                case 'export':
                    $result = $this->faqService->export($faq_ids, $request->header('lang'));
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
