<?php

namespace App\CacheProfiles;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;

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
}
