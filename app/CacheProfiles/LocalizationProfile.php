<?php

namespace App\CacheProfiles;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;
use Symfony\Component\HttpFoundation\Response;

class LocalizationProfile extends CacheAllSuccessfulGetRequests
{
    /*
     * Set a string to add to differentiate this request from others.
     */
    public function useCacheNameSuffix(Request $request): string
    {
        if ($request->is('v2/*')) {
            return App::currentLocale();
        }

        return '';
    }

    /**
     * Only cache 2xx responses. The parent also caches redirections,
     * which includes 304 Not Modified produced by ETag handling.
     */
    public function shouldCacheResponse(Response $response): bool
    {
        return $response->isSuccessful();
    }
}
