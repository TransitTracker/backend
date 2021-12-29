<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Content-Language');

        if (! $locale) {
            $locale = config('app.locale');
        } elseif ($locale === 'fr-CA') {
            $locale = 'fr';
        } elseif ($locale === 'en-CA') {
            $locale = 'en';
        }

        if (! array_key_exists($locale, config('app.supported_languages'))) {
            return abort(403, 'Language not supported. Try with en or fr.');
        }

        App::setLocale($locale);

        $response = $next($request);
        $response->headers->set('Content-Language', $locale);

        return $response;
    }
}
