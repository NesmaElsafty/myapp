<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sets the application locale from the request header "lang".
 * Supported values: "en" (English), "ar" (Arabic). Defaults to "en" if missing or invalid.
 * All controller response messages and validation errors will be translated accordingly.
 */
class SetLocaleFromHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('lang', config('app.locale', 'en'));
        $lang = strtolower(trim($lang));
        if (in_array($lang, ['en', 'ar'], true)) {
            app()->setLocale($lang);
        } else {
            app()->setLocale(config('app.fallback_locale', 'en'));
        }

        return $next($request);
    }
}
