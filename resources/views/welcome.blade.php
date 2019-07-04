<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link href="favicon.ico" rel="icon">
        <title>Montréal Transit Tracker</title>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" rel="stylesheet"/>
    </head>
    <body>
        <noscript>
            <strong>We're sorry but Montreal Transit Tracker doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div id="app"></div>
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
