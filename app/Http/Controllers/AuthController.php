<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\AdminResource;
use App\Http\Resources\IndividualResource;
use App\Http\Resources\AgentResource;
use App\Http\Resources\OriginResource;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;

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
            'type' => 'required|in:user,admin,individual,agent,origin',
            'origin_id' => 'nullable|exists:users,id',
            'national_id' => 'nullable|string|max:255',
            'commercial_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $result = $this->authService->register($validator->validated());

            // Load relationships if needed
            if ($result['user']->type === 'agent') {
                $result['user']->load('origin');
            }

            $resourceClass = $this->getResourceClass($result['user']->type);
            $userResource = new $resourceClass($result['user']);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $userResource,
                'token' => $result['token'],
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'type' => 'nullable|in:user,admin,individual,agent,origin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $result = $this->authService->login($validator->validated());

            // Load relationships if needed
            if ($result['user']->type === 'agent') {
                $result['user']->load('origin');
            }

            $resourceClass = $this->getResourceClass($result['user']->type);
            $userResource = new $resourceClass($result['user']);

            return response()->json([
                'message' => 'Login successful',
                'user' => $userResource,
                'token' => $result['token'],
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Invalid credentials',
                'errors' => $e->errors(),
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        try {
            $tokenId = $request->user()->currentAccessToken()->id ?? null;
            $this->authService->logout($request->user(), $tokenId);

            return response()->json([
                'message' => 'Logged out successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request)
    {
        $user = $request->user();

        // Load relationships if needed
        if ($user->type === 'agent') {
            $user->load('origin');
        }

        $resourceClass = $this->getResourceClass($user->type);
        $userResource = new $resourceClass($user);

        return response()->json([
            'user' => $userResource,
        ], 200);
    }

    /**
     * Get resource class based on user type
     */
    protected function getResourceClass(string $type): string
    {
        return match ($type) {
            'admin' => AdminResource::class,
            'individual' => IndividualResource::class,
            'agent' => AgentResource::class,
            'origin' => OriginResource::class,
            default => UserResource::class,
        };
    }
}
