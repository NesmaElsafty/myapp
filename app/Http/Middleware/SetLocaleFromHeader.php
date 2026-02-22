<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sets the application locale for localized responses (e.g. __(), validation messages).
 * - Authenticated user: use auth()->user()->language (ar|en). Resolves Sanctum user from Bearer token when present.
 * - Guest: use request header "lang" (ar|en).
 * Falls back to config app.locale / app.fallback_locale if missing or invalid.
 */
class SetLocaleFromHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = null;

        // Resolve Sanctum user from Bearer token so we have the user before auth:sanctum runs
        $user = $request->bearerToken() ? auth()->guard('sanctum')->user() : null;
        if ($user && !empty($user->language)) {
            $lang = strtolower(trim((string) $user->language));
        }

        if ($lang === null || !in_array($lang, ['en', 'ar'], true)) {
            $lang = $request->header('lang', config('app.locale', 'en'));
            $lang = strtolower(trim((string) $lang));
        }

        if (in_array($lang, ['en', 'ar'], true)) {
            app()->setLocale($lang);
        } else {
            app()->setLocale(config('app.fallback_locale', 'en'));
        }

        return $next($request);
    }
}
