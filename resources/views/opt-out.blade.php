<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Opt-out from statistics</title>
    </head>
    <body>
        <iframe style="border: 0; height: 200px; width: 600px;" src="{{ env('MIX_MATOMO_HOST') }}/index.php?module=CoreAdminHome&action=optOut&language={{ $lang }}&backgroundColor=&fontColor=&fontSize=&fontFamily=Arial"></iframe>
        <br>
        <a href="{{ route('tt.app') }}">
            @if($lang === 'en')
                Return to Transit Tracker
            @else
                Retourner dans Transit Tracker
            @endif
        </a>

        <link href="https://fonts.googleapis.com/css?family=Roboto:400&display=swap" rel="stylesheet" async>
        <style>
            body {
                font-family: 'Roboto', sans-serif;
            }
        </style>
    </body>
</html>
