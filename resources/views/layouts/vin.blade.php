<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="relative min-h-screen font-sans bg-primary-100">
    <nav class="w-full text-xl text-white bg-primary-500 drop-shadow">
        <div class="container flex items-center px-4 py-4 mx-auto md:px-0">
            <a href="https://www.transittracker.ca/" class="flex items-center px-2 py-1 -mx-2 -my-1 transition-colors bg-white bg-opacity-0 rounded hover:bg-opacity-10">
                <svg viewBox="0 0 295.01 403.72" xmlns="http://www.w3.org/2000/svg" class="h-6 mr-2">
                    <path fill="#fff" d="m147.51 1.875c-80.34 0-145.63 65.291-145.63 145.63 0 84.709 87.863 198.79 126.94 245.63 9.708 11.651 27.428 11.651 37.137 0 39.32-46.845 127.18-160.92 127.18-245.63 0-80.34-65.291-145.63-145.63-145.63zm0 70.631c34.895 0 63.158 3.9481 63.158 31.58v78.945c0 6.948-3.0785 13.185-7.8945 17.527v10.105c0 6.553-5.3678 11.842-11.842 11.842-6.553 0-11.842-5.3678-11.842-11.842v-3.9473h-63.158v3.9473a11.826 11.826 0 0 1-11.842 11.842 11.826 11.826 0 0 1-11.844-11.842v-10.105c-4.816-4.342-7.8945-10.579-7.8945-17.527v-78.945c0-27.632 28.263-31.58 63.158-31.58zm-47.367 31.58v39.473h94.734v-39.473h-94.734zm11.842 63.156a11.826 11.826 0 0 0-11.842 11.844 11.826 11.826 0 0 0 11.842 11.842c6.552 0 11.842-5.2888 11.842-11.842a11.826 11.826 0 0 0-11.842-11.844zm71.051 0c-6.552 0-11.842 5.2908-11.842 11.844a11.826 11.826 0 0 0 11.842 11.842 11.826 11.826 0 0 0 11.842-11.842 11.826 11.826 0 0 0-11.842-11.844z"/>
                </svg>

                <p>Transit Tracker</p>
            </a>
        </div>
    </nav>
    @if (session('status'))
    <div class="text-white bg-secondary-700">
        <div class="container p-4 mx-auto text-sm font-medium tracking-wide">
            {{ session('status') }}
        </div>
    </div>
    @endif
    <div class="text-black bg-[#facc15] pt-2.5 pb-2 pl-4 pr-2 flex items-center gap-x-4">
        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 text-white bg-black bg-opacity-25 rounded-full">
            <x-gmdi-new-releases class="w-6 h-6" />
        </div>        
        A new home for exo VINs. You can now see other user's submissions and vote for the good ones.
    </div>    
    <div class="pb-24">@yield('body')</div>

    <footer class="absolute bottom-0 w-full h-12 mt-20">
        <div class="container flex items-center h-full px-4 mx-auto border-t-4 border-opacity-25 border-primary-500">
            <div>
                <img src="https://felixinx.me/favicon.svg" alt="FelixINX logo" class="inline w-8 h-8">
                {{ __('A project by') }} <a href="https://felixinx.me/{{ app()->getLocale() === 'en' ? 'en' : '' }}" class="text-[#1f5784] font-bold">@felixinx</a>
            </div>
            <div class="flex-grow"></div>
            <a href="https://github.com/TransitTracker" class="transition-colors hover:text-primary-700">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path>
                </svg>
            </a>
        </div>
    </footer>

    @production
    <script async defer data-website-id="577432c9-d486-4ba6-8d36-6407c6c618e8" src="https://stats.felixinx.me/umami.js"></script>
    @endproduction
</body>
</html>
