<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('lang', 'en');
        if (in_array($lang, ['en', 'ar'], true)) {
            app()->setLocale($lang);
        } else {
            app()->setLocale('en');
        }

        return $next($request);
    }
}
