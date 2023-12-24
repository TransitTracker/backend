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
        'styles' => [
            'light' => env('MAPBOX_LIGHT_STYLE'),
            'dark' => env('MAPBOX_DARK_STYLE'),
            'satellite' => env('MAPBOX_SATELLITE_STYLE'),
        ],
    ],
    'print_gtfs_rt_bin' => env('PRINT_GTFS_RT_BIN'),
    'domain' => [
        'web' => env('WEB_DOMAIN', null),
        'api' => env('API_DOMAIN', null),
        'vin' => env('VIN_DOMAIN', null),
        'filament' => env('FILAMENT_DOMAIN', null),
    ],
    'path' => [
        'vin' => env('VIN_PATH', 'vin'),
        'filament' => env('FILAMENT_PATH', 'admin'),
    ],
];
