<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get supported locales from config
        $supportedLocales = explode(',', config('app.supported_locales', 'en,sw'));
        
        // Check if locale is provided in URL
        if ($request->has('locale') && in_array($request->locale, $supportedLocales)) {
            $locale = $request->locale;
            Session::put('locale', $locale);
        } 
        // Check session for stored locale
        elseif (Session::has('locale') && in_array(Session::get('locale'), $supportedLocales)) {
            $locale = Session::get('locale');
        }
        // Check browser language preference
        elseif ($request->hasHeader('Accept-Language')) {
            $browserLocale = substr($request->header('Accept-Language'), 0, 2);
            $locale = in_array($browserLocale, $supportedLocales) ? $browserLocale : config('app.locale');
        }
        // Default to app locale
        else {
            $locale = config('app.locale');
        }

        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}