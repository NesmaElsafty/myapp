<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restrict access by authenticated user type.
 * Usage: middleware(['auth:sanctum', 'type:admin']) or type:user, type:individual, type:origin
 * Multiple types: middleware(['auth:sanctum', 'type:individual,origin'])
 */
class EnsureUserType
{
    public function handle(Request $request, Closure $next, string ...$allowedTypes): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => __('auth.unauthenticated') ?: 'Unauthenticated',
            ], 401);
        }

        // Support comma-separated single argument: type:individual,origin
        if (count($allowedTypes) === 1 && str_contains($allowedTypes[0], ',')) {
            $allowedTypes = array_map('trim', explode(',', $allowedTypes[0]));
        }

        if (! in_array($user->type, $allowedTypes, true)) {
            return response()->json([
                'message' => __('auth.unauthorized_type') ?: 'Unauthorized. This action is not allowed for your account type.',
            ], 403);
        }

        if ($user->is_active !== '1' && $user->is_active !== true) {
            return response()->json([
                'message' => __('auth.account_inactive') ?: 'Your account is inactive. Please contact the administrator.',
            ], 403);
        }

        return $next($request);
    }
}
