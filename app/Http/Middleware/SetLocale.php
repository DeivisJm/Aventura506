<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Priority:
     * 1. Session (user-selected language)
     * 2. Browser language (Accept-Language)
     * 3. App default (config/app.php)
     */
    public function handle(Request $request, Closure $next)
    {
        // 1️⃣ If user already selected a language, keep it
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
            return $next($request);
        }

        // 2️⃣ Detect browser language (es, en, etc.)
        $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        // Supported languages
        $availableLocales = ['es', 'en'];

        if (in_array($browserLocale, $availableLocales)) {
            App::setLocale($browserLocale);
            Session::put('locale', $browserLocale);
        } else {
            // 3️⃣ Fallback
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
