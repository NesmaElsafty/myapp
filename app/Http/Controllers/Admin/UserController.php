<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helpers\PaginationHelper;
use Exception;
use App\Models\User;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|in:user,admin,individual,origin',
                'search' => 'nullable|string|max:255',
                'role_id' => 'nullable|exists:roles,id',
                'sorted_by' => 'nullable|string|in:name,newest,oldest,all',
                'is_active' => 'nullable|string|in:1,0,all',
            ]);

            $users = $this->userService->getAll($request->all(), $request->type)->paginate(10);
            $stats = $this->userService->stats($request->type);

            return response()->json([
                'message' => __('messages.users_retrieved_success'),
                'users' => UserResource::collection($users),
                'pagination' => PaginationHelper::paginate($users),
                'stats' => $request->type !== 'admin' ? $stats : null,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_users'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                })
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                })
            ],
            'type' => 'required|in:user,admin',
            'location' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean|in:1,0',
            'specialty_areas' => 'nullable|array',
            'specialty_areas.*' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_iban' => 'nullable|string|max:34',
            'bank_account_address' => 'nullable|string|max:255',
            'language' => 'nullable|in:ar,en',
        ]);

        try {
            $user = $this->userService->create($request->all());

            return response()->json([
                'message' => __('messages.user_created_success'),
                'data' => new UserResource($user),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_user'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getById($id);

            if (!$user) {
                return response()->json([
                    'message' => __('messages.user_not_found'),
                ], 404);
            }

            return response()->json([
                'message' => __('messages.user_retrieved_success'),
                'data' => new UserResource($user),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_user'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'f_name' => 'string|max:255',
                'l_name' => 'string|max:255',
                'email' => [
                    'string',
                    'email',
                    'unique:users,email,' . $id . ',id,type,' . $request->type,
                ],
                'phone' => [
                    'string',
                    'max:20',
                    'unique:users,phone,' . $id . ',id,type,' . $request->type,
                ],
                'role_id' => 'exists:roles,id',
                'type' => 'in:user,admin',
                'location' => 'string|max:255',
                'is_active' => 'boolean|in:1,0',
                'specialty_areas' => 'nullable|array',
                'specialty_areas.*' => 'nullable|string|max:255',
                'major' => 'nullable|string|max:255',
                'summary' => 'nullable|string',
                'bank_name' => 'nullable|string|max:255',
                'bank_account_number' => 'nullable|string|max:255',
                'bank_account_iban' => 'nullable|string|max:34',
                'bank_account_address' => 'nullable|string|max:255',
                'language' => 'nullable|in:ar,en',
            ]);

            $user = $this->userService->update($id, $request->all());

            return response()->json([
                'message' => __('messages.user_updated_success'),
                'data' => new UserResource($user),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_user'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->delete($id);

            return response()->json([
                'message' => __('messages.user_deleted_success'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_user'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function bulkActions(Request $request)
    {
        try {
            $request->validate([
                'action' => 'required|in:block,unblock,toggleActive,export',
                'type' => 'required|in:user,admin,individual,origin',
                'user_ids' => 'nullable|array|exists:users,id',
            ]);

            $user_ids = $request->user_ids;

            if (!$user_ids || count($user_ids) === 0) {
                $user_ids = User::where('type', $request->type)->pluck('id')->toArray();
            }

            $result = null;
            switch ($request->action) {
                case 'block':
                    $this->userService->block($user_ids);
                    $result = 'Users blocked successfully';
                    break;
                case 'unblock':
                    $this->userService->unblock($user_ids);
                    $result = 'Users unblocked successfully';
                    break;
                case 'toggleActive':
                    $this->userService->toggleActive($user_ids);
                    $result = 'Users active status toggled successfully';
                    break;
                case 'export':
                    $result = $this->userService->export($user_ids);
                    break;
            }

            return response()->json([
                'message' => __('messages.bulk_actions_success'),
                'data' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.failed_bulk_actions'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function blocklist(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'user_type' => 'nullable|string|in:user,admin,individual,origin',
            ]);
            $users = $this->userService->blocklist($request->all())->paginate(10);

            return response()->json([
                'message' => __('messages.blocklist_retrieved_success'),
                'data' => UserResource::collection($users),
                'pagination' => PaginationHelper::paginate($users),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_blocklist'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
