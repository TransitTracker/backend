<?php

return [
    'api_key' => env('APP_API_KEY', null),
    'admin_email' => env('MAIL_TO', ''),
    'slack_webhook_url' => env('SLACK_WEBHOOK_URL'),
    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret' => env('TURNSTILE_SECRET_KEY'),
    ],
    'mapbox' => [
        'secret_key' => env('MAPBOX_SECRET_KEY'),
        'light_style' => env('MAPBOX_LIGHT_STYLE'),
        'dark_style' => env('MAPBOX_DARK_STYLE'),
    ],
    'print_gtfs_rt_bin' => env('PRINT_GTFS_RT_BIN'),
    'domain' => [
        'web' => env('WEB_DOMAIN', null),
        'api' => env('API_DOMAIN', null),
        'vin' => env('VIN_DOMAIN', null),
    ],
    'path' => [
        'vin' => env('VIN_PATH', 'vin'),
    ],
];
