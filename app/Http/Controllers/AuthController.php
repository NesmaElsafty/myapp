<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\AdminResource;
use App\Http\Resources\IndividualResource;
use App\Http\Resources\OriginResource;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected AuthService $authService;
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required|in:user,admin,individual,origin',
            'origin_id' => 'nullable|exists:users,id', // only used when type is individual
            'national_id' => 'nullable|string|max:255',
            'commercial_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_iban' => 'nullable|string|max:34',
            'bank_account_address' => 'nullable|string|max:255',
            'language' => 'nullable|in:ar,en',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => __('messages.validation_error'),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $result = $this->authService->register($validator->validated());

            // Load relationships if needed (individual may have optional origin)
            if ($result['user']->type === 'individual' && $result['user']->origin_id) {
                $result['user']->load('origin');
            }

            $resourceClass = $this->getResourceClass($result['user']->type);
            $userResource = new $resourceClass($result['user']);

            return response()->json([
                'message' => __('messages.user_registered_success'),
                'user' => $userResource,
                'token' => $result['token'],
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_error'),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.registration_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
                'type' => 'nullable|in:user,admin,individual,origin',
            ]);
            $result = $this->authService->login($request->only('email', 'password', 'type'));

            // Load relationships if needed (individual may have optional origin)
            if ($result['user']->type === 'individual' && $result['user']->origin_id) {
                $result['user']->load('origin');
            }

            $resourceClass = $this->getResourceClass($result['user']->type);
            $userResource = new $resourceClass($result['user']->load('alerts'));
            
            return response()->json([
                'message' => __('messages.login_success'),
                'user' => $userResource,
                'token' => $result['token'],
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.invalid_credentials'),
                'errors' => $e->errors(),
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $tokenId = $request->user()->currentAccessToken()->id ?? null;
            $this->authService->logout($request->user(), $tokenId);

            return response()->json([
                'message' => __('messages.logged_out_success'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.logout_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function me(Request $request)
    {
        $user = $request->user();

        // Load relationships if needed (individual may have optional origin)
        if ($user->type === 'individual' && $user->origin_id) {
            $user->load('origin');
        }

        $resourceClass = $this->getResourceClass($user->type);
        $userResource = new $resourceClass($user);

        return response()->json([
            'user' => $userResource,
        ], 200);
    }

    protected function getResourceClass(string $type): string
    {
        return match ($type) {
            'admin' => AdminResource::class,
            'individual' => IndividualResource::class,
            'origin' => OriginResource::class,
            default => UserResource::class,
        };
    }

    public function updateProfile(Request $request)
    {
        try {
        $user = auth()->user();
        $request->validate([
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id . ',id,type,' . $user->type,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id . ',id,type,' . $user->type,
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_iban' => 'nullable|string|max:34',
            'bank_account_address' => 'nullable|string|max:255',
            'language' => 'nullable|in:ar,en',
        ]);

        $user = $this->authService->updateProfile($request->all());

        // if ahs image, update it
        if ($request->hasFile('image')) {
            // update using spatie media library
            $user->addMediaFromRequest('image')->toMediaCollection('profile');
        }

        $resourceClass = $this->getResourceClass($user->type);
        return response()->json([
            'message' => __('messages.profile_updated_success'),
            'user' => new $resourceClass($user),
        ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_profile'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'old_password' => 'required|string',
                'new_password' => 'required|string',
            ]);

            $user = auth()->user();
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'message' => __('messages.old_password_incorrect'),
                ], 401);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'message' => __('messages.password_changed_success'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.failed_change_password'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
