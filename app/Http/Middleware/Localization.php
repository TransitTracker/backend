<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Localization constructor.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

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

        if (!$locale) {
            $locale = $this->app->config->get('app.locale');
        } elseif ($locale === 'fr-CA') {
            $locale = 'fr';
        } elseif ($locale === 'en-CA') {
            $locale = 'en';
        }

        if (!array_key_exists($locale, $this->app->config->get('app.supported_languages'))) {
            return abort(403, 'Language not supported. Try with en or fr.');
        }

        $this->app->setLocale($locale);

        $response = $next($request);
        $response->headers->set('Content-Language', $locale);

        return $response;
    }
}
