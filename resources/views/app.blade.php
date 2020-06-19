<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Transit Tracker</title>
        <meta name="description" content="A tracker for most transit vehicles in the greater Montreal and Toronto area, see more than 2000 vehicules in one map, including STM, TTC, and many more!">
        <meta name="author" content="FelixINX">
        <link rel="icon" href="favicon.ico">
        <meta name="keywords" content="transit, bus, buses, train, tracker, tram, Montreal, STM, STL, RTL, exo, map">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:creator" content="@felixinx">
        <meta name="twitter:title" content="Transit Tracker">
        <meta name="twitter:description" content="One map for most buses and trains in the greater Montreal and Toronto">
        <meta name="twitter:image" content="/img/twitter-card.png">
        <meta name="og:title" content="Transit Tracker">
        <meta name="og:description" content="One map for most buses and trains in the greater Montreal and Toronto">
        <meta name="og:image" content="/img/open-graph.png">
        <meta name="og:url" content="https://transittracker.ca">
        <meta name="og:locale" content="en_CA">
        <meta name="og:locale:alternate" content="fr_CA">

        <link rel="manifest" href="/manifest.json">
        <link rel="icon" sizes="192x192" href="/img/icon-192.png">
        <link rel="apple-touch-icon" href="/img/icon-ios-512.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/img/icon-ios-120.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/img/icon-ios-152.png">
        <link rel="apple-touch-icon" sizes="167x167" href="/img/icon-ios-167.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/img/icon-ios-180.png">
        <meta name="apple-mobile-web-app-title" content="T Tracker">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="#303633">

        <link rel="preconnect" href="{{ env('MIX_MATOMO_HOST') }}">
        <link rel="dns-prefetch" href="{{ env('MIX_MATOMO_HOST') }}">
    </head>
    <body>
        <noscript>
            <strong>We're sorry but Transit Tracker doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div id="app"></div>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
        <script src="{{ mix('js/vendor.js') }}" type="text/javascript"></script>
        <script src="{{ mix('js/manifest.js') }}" type="text/javascript"></script>

        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet" async>
        <link href="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css" rel="stylesheet"/>
    </body>
</html>
