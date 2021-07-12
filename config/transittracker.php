<?php

return [
    'api_key' => env('APP_API_KEY', null),
    'admin_email' => env('MAIL_TO', ''),
    'slack_webhook_url' => env('SLACK_WEBHOOK_URL'),
    'recaptcha' => [
        'site' => env('RECAPTCHA_SITE_KEY'),
        'secret' => env('RECAPTCHA_SECRET_KEY'),
    ],
];
