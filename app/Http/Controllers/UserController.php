<?php

namespace App\Http\Controllers;

use App\Http\Resources\IndividualResource;
use App\Http\Resources\OriginResource;
use App\Services\UserService;
use App\Helpers\PaginationHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * List individuals and origins for guests (no auth).
     * Query: type = individual|origin.
     */
    public function index(Request $request): JsonResponse
    {
        try {
        $request->validate([
            'type' => 'required|string|in:individual,origin',
        ]);

        $users = $this->userService->getPublicIndividualsAndOrigins($request->all())->paginate(10);

        $users_resource = $request->type === 'individual' ? IndividualResource::collection($users) : OriginResource::collection($users);

        return response()->json([
            'message' => __('messages.users_retrieved_success'),
            'data' => $users_resource,
            'pagination' => PaginationHelper::paginate($users),
        ], 200);
    
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_users'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show a single individual or origin for guests (no auth).
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getPublicById($id);
        if (! $user) {
            return response()->json([
                'message' => __('messages.user_not_found'),
            ], 404);
        }
        $resource = $user->type === 'individual'
            ? new IndividualResource($user)
            : new OriginResource($user);
        return response()->json([
            'message' => __('messages.user_retrieved_success'),
            'data' => $resource,
        ], 200);
    }
}
