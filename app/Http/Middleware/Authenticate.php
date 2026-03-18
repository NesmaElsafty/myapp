<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * For APIs we don't want any redirect to a login route; we just let the
     * AuthenticationException bubble up so our global handler can return JSON.
     */
    protected function redirectTo($request): ?string
    {
        // For API requests, never redirect (this avoids "Route [login] not defined").
        if ($request->expectsJson() || $request->is('api/*')) {
            return null;
        }

        // You can return a web login path here if you ever add one.
        return null;
    }
}

