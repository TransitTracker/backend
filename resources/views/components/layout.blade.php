<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Transit Tracker') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @cookieconsentscripts
    @stack('scripts')
</head>

<body class="relative min-h-screen font-sans bg-primary-95 dark:bg-neutral-6 text-neutral-10 dark:text-neutral-90 flex flex-col scroll-smooth">
    <nav class="w-full bg-primary-40 z-40 dark:bg-neutral-12 text-white fixed top-0  shadow-2" x-data="{ navShow: false }">
        <div class="container flex items-center md:hidden h-16 mx-auto px-4 gap-4">

            <button @click="navShow = !navShow"><x-gmdi-menu class="h-6 w-6 transition-transform" x-bind:class="navShow ? 'rotate-90' : ''" /></button>
            <a href="{{ route('vin.index') }}" class="flex items-center px-2 py-1 -mx-2 -my-1 transition-colors text-xl bg-white bg-opacity-0 rounded hover:bg-opacity-10 font-heading">
                <svg viewBox="0 0 295.01 403.72" xmlns="http://www.w3.org/2000/svg" class="h-6 mr-2">
                    <path fill="#fff" d="m147.51 1.875c-80.34 0-145.63 65.291-145.63 145.63 0 84.709 87.863 198.79 126.94 245.63 9.708 11.651 27.428 11.651 37.137 0 39.32-46.845 127.18-160.92 127.18-245.63 0-80.34-65.291-145.63-145.63-145.63zm0 70.631c34.895 0 63.158 3.9481 63.158 31.58v78.945c0 6.948-3.0785 13.185-7.8945 17.527v10.105c0 6.553-5.3678 11.842-11.842 11.842-6.553 0-11.842-5.3678-11.842-11.842v-3.9473h-63.158v3.9473a11.826 11.826 0 0 1-11.842 11.842 11.826 11.826 0 0 1-11.844-11.842v-10.105c-4.816-4.342-7.8945-10.579-7.8945-17.527v-78.945c0-27.632 28.263-31.58 63.158-31.58zm-47.367 31.58v39.473h94.734v-39.473h-94.734zm11.842 63.156a11.826 11.826 0 0 0-11.842 11.844 11.826 11.826 0 0 0 11.842 11.842c6.552 0 11.842-5.2888 11.842-11.842a11.826 11.826 0 0 0-11.842-11.844zm71.051 0c-6.552 0-11.842 5.2908-11.842 11.844a11.826 11.826 0 0 0 11.842 11.842 11.826 11.826 0 0 0 11.842-11.842 11.826 11.826 0 0 0-11.842-11.844z" />
                </svg>

                <p>{{ __('VIN Database') }}</p>
            </a>
        </div>
        <div class="md:container flex flex-col md:flex-row   md:gap-4 md:items-center md:px-4 mx-auto md:h-16 bg-primary-50 dark:bg-neutral-22 md:bg-transparent" x-bind:class="!navShow ? 'hidden md:flex' : ''">
            <a href="{{ route('vin.index') }}" class="hidden md:flex items-center px-2 py-1 -mx-2 -my-1 transition-colors text-xl bg-white bg-opacity-0 rounded hover:bg-opacity-10 font-heading">
                <svg viewBox="0 0 295.01 403.72" xmlns="http://www.w3.org/2000/svg" class="h-6 mr-2">
                    <path fill="#fff" d="m147.51 1.875c-80.34 0-145.63 65.291-145.63 145.63 0 84.709 87.863 198.79 126.94 245.63 9.708 11.651 27.428 11.651 37.137 0 39.32-46.845 127.18-160.92 127.18-245.63 0-80.34-65.291-145.63-145.63-145.63zm0 70.631c34.895 0 63.158 3.9481 63.158 31.58v78.945c0 6.948-3.0785 13.185-7.8945 17.527v10.105c0 6.553-5.3678 11.842-11.842 11.842-6.553 0-11.842-5.3678-11.842-11.842v-3.9473h-63.158v3.9473a11.826 11.826 0 0 1-11.842 11.842 11.826 11.826 0 0 1-11.844-11.842v-10.105c-4.816-4.342-7.8945-10.579-7.8945-17.527v-78.945c0-27.632 28.263-31.58 63.158-31.58zm-47.367 31.58v39.473h94.734v-39.473h-94.734zm11.842 63.156a11.826 11.826 0 0 0-11.842 11.844 11.826 11.826 0 0 0 11.842 11.842c6.552 0 11.842-5.2888 11.842-11.842a11.826 11.826 0 0 0-11.842-11.844zm71.051 0c-6.552 0-11.842 5.2908-11.842 11.844a11.826 11.826 0 0 0 11.842 11.842 11.826 11.826 0 0 0 11.842-11.842 11.826 11.826 0 0 0-11.842-11.844z" />
                </svg>

                <p>Transit Tracker &bull; {{ __('VIN Database') }}</p>
            </a>

            <div class=" overflow-hidden group block" x-data="{ expanded: false }">
                <button class="md:h-9 h-12 px-4 flex items-center md:justify-center bg-white bg-opacity-0 group-hover:bg-opacity-10 md:rounded-t w-full md:w-auto justify-between" @click="expanded = !expanded">
                    {{ __('Sectors') }}
                    <x-gmdi-keyboard-arrow-down class="w-6 h-6 text-current transition-transform md:hidden" x-bind:class="expanded ? 'rotate-180' : ''" />
                </button>
                <ul class=" md:hidden md:absolute z-10 min-w-[4rem] group-hover:block bg-white dark:bg-neutral-24 text-primary-10 dark:text-white" x-show="expanded" x-collapse>
                    @foreach($sectors as $sector)
                    <li>
                        <a href="{{ route('vin.agency.show', ['sector' => $sector->name_slug]) }}" class="flex gap-2 items-center px-4 py-3 hover:bg-neutral-90 hover:dark:bg-neutral-22">
                            <span class="w-4 h-4 flex-shrink-0 rounded-full" style="background-color: {{ $sector->color }}"></span>
                            <span class="font-bold font-heading">
                                @if($sector->is_archived)
                                <small class="italic">{{ __('Archived') }}</small>
                                @endif
                                {{ $sector->short_name }}
                            </span>
                            <span class="grow px-1"></span>
                            <small>{{ $sector->exo_with_vin_count }}</small>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class=" overflow-hidden group block" x-data="{ expanded: false }">
                <button class="md:h-9 h-12 px-4 flex items-center md:justify-center bg-white bg-opacity-0 group-hover:bg-opacity-10 md:rounded-t w-full md:w-auto justify-between" @click="expanded = !expanded">
                    {{ __('Operators') }}
                    <x-gmdi-keyboard-arrow-down class="w-6 h-6 text-current transition-transform md:hidden" x-bind:class="expanded ? 'rotate-180' : ''" />
                </button>
                <ul class="md:hidden md:absolute z-10 min-w-[4rem] group-hover:block bg-white dark:bg-neutral-24 text-primary-10 dark:text-white" x-show="expanded" x-collapse>
                    @foreach($operators as $operator)
                    <li>
                        <a href="{{ route('vin.operator.show', ['tagSlug' => $operator->slug]) }}" class="flex gap-2 items-center px-4 py-3 hover:bg-neutral-90 hover:dark:bg-neutral-22">
                            <div class="-mx-2 px-2 -my-1 py-1 rounded" style="background-color: {{ $operator->color }}; color: {{ $operator->text_color }};">{{ $operator->label }}</div>
                            <span class="grow px-1"></span>
                            <small>{{ $operator->exo_vin_vehicles_count }}</small>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <span class="grow"></span>

            <a href="{{ route('locale', ['locale' => app()->getLocale() === 'en' ? 'fr' : 'en']) }}" class="h-12 md:h-9 px-4 flex items-center justify-center bg-white bg-opacity-0 hover:bg-opacity-10 md:rounded">
                {{ __('FR') }}
            </a>
        </div>
    </nav>
    @if (session('from-api'))
    <div class="bg-error-90 dark:bg-error-30 text-error-10 dark:text-error-90">
        <div class="container p-4 mx-auto">
            <p class="text-lg font-bold">{{ __('The VIN project has moved!') }}</p>
            <p class="mt-1">{{ __('It is now accessible at ') }}<a class="font-medium underline" href="{{ route('vin.index') }}">{{ route('vin.index') }}</a>.</p>
        </div>
    </div>
    @endif
    @if (session('status'))
    <div class="text-white bg-secondary-700">
        <div class="container p-4 mx-auto text-sm font-medium tracking-wide">
            {{ session('status') }}
        </div>
    </div>
    @endif
    <div class="pb-24 pt-16 flex-grow">{{ $slot }}</div>

    <footer class="w-full dark:text-primary-90 bg-primary-90 text-primary-10 dark:bg-primary-30 relative overflow-hidden z-30">
        <div class="container mx-auto p-4">
            <div class="flex items-center font-heading font-bold gap-2">
                <svg viewBox="0 0 295.01 403.72" xmlns="http://www.w3.org/2000/svg" class="h-6 text-primary-40 dark:text-white fill-current">
                    <path d="m147.51 1.875c-80.34 0-145.63 65.291-145.63 145.63 0 84.709 87.863 198.79 126.94 245.63 9.708 11.651 27.428 11.651 37.137 0 39.32-46.845 127.18-160.92 127.18-245.63 0-80.34-65.291-145.63-145.63-145.63zm0 70.631c34.895 0 63.158 3.9481 63.158 31.58v78.945c0 6.948-3.0785 13.185-7.8945 17.527v10.105c0 6.553-5.3678 11.842-11.842 11.842-6.553 0-11.842-5.3678-11.842-11.842v-3.9473h-63.158v3.9473a11.826 11.826 0 0 1-11.842 11.842 11.826 11.826 0 0 1-11.844-11.842v-10.105c-4.816-4.342-7.8945-10.579-7.8945-17.527v-78.945c0-27.632 28.263-31.58 63.158-31.58zm-47.367 31.58v39.473h94.734v-39.473h-94.734zm11.842 63.156a11.826 11.826 0 0 0-11.842 11.844 11.826 11.826 0 0 0 11.842 11.842c6.552 0 11.842-5.2888 11.842-11.842a11.826 11.826 0 0 0-11.842-11.844zm71.051 0c-6.552 0-11.842 5.2908-11.842 11.844a11.826 11.826 0 0 0 11.842 11.842 11.826 11.826 0 0 0 11.842-11.842 11.826 11.826 0 0 0-11.842-11.844z" />
                </svg>
                <p>Transit Tracker
            </div>
            <small class="pl-7">{{ __('Making real time transit data accessible') }}</small>
            <ul class="flex flex-col md:flex-row gap-x-2 gap-y-4 mt-4">
                <li class="md:after:pl-2 md:after:content-['\2022']"><a target="_blank" href="https://transittracker.ca" class="hover:underline">{{ __('Main application') }}</a></li>
                <li class="md:after:pl-2 md:after:content-['\2022']"><a target="_blank" href="{{ route('scribe') }}" class="hover:underline">{{ __('For developers') }}</a></li>
                <li><a target="_blank" href="https://github.com/TransitTracker" class="hover:underline">{{ __('On GitHub') }}</a></li>
                <span class="grow"></span>
                @cookieconsentbutton(action: 'reset', label: __('About cookies'))
                <span class="grow"></span>
                <li><a target="_blank" href="https://felixinx.me" class="hover:underline md:mr-24">{{ __('By @felixinx') }}</a></li>
            </ul>
        </div>

        <svg viewBox="0 0 295.01 403.72" xmlns="http://www.w3.org/2000/svg" class=" h-40 -right-5    -bottom-12 absolute text-primary-87 dark:text-primary-24 fill-current">
            <path d="m147.51 1.875c-80.34 0-145.63 65.291-145.63 145.63 0 84.709 87.863 198.79 126.94 245.63 9.708 11.651 27.428 11.651 37.137 0 39.32-46.845 127.18-160.92 127.18-245.63 0-80.34-65.291-145.63-145.63-145.63zm0 70.631c34.895 0 63.158 3.9481 63.158 31.58v78.945c0 6.948-3.0785 13.185-7.8945 17.527v10.105c0 6.553-5.3678 11.842-11.842 11.842-6.553 0-11.842-5.3678-11.842-11.842v-3.9473h-63.158v3.9473a11.826 11.826 0 0 1-11.842 11.842 11.826 11.826 0 0 1-11.844-11.842v-10.105c-4.816-4.342-7.8945-10.579-7.8945-17.527v-78.945c0-27.632 28.263-31.58 63.158-31.58zm-47.367 31.58v39.473h94.734v-39.473h-94.734zm11.842 63.156a11.826 11.826 0 0 0-11.842 11.844 11.826 11.826 0 0 0 11.842 11.842c6.552 0 11.842-5.2888 11.842-11.842a11.826 11.826 0 0 0-11.842-11.844zm71.051 0c-6.552 0-11.842 5.2908-11.842 11.844a11.826 11.826 0 0 0 11.842 11.842 11.826 11.826 0 0 0 11.842-11.842 11.826 11.826 0 0 0-11.842-11.844z" />
        </svg>

        <!--<svg width="240" height="120" viewBox="0 0 240 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute right-0 inset-y-0 stroke-current stroke-2">
            <path d="M30 120V100C30 94.4772 34.4772 90 40 90H170C175.523 90 180 85.5228 180 80V0" />
            <path d="M90 0V50C90 55.5228 94.4772 60 100 60H240" />
            <path d="M60 120V40C60 34.4772 64.4772 30 70 30H240" />
            <path d="M150 0V120" />
            <path d="M240 60H220C214.477 60 210 64.4772 210 70V120" />
            <path d="M228 60H220C214.477 60 210 64.4772 210 70V71" stroke="url(#paint0)" stroke-linecap="round" />
            <path d="M73 90H88" stroke="url(#paint1)" stroke-linecap="round" />
            <path d="M150 47V32" stroke="url(#paint2)" stroke-linecap="round" />
            <defs>
                <linearGradient id="paint0" x1="227" y1="60" x2="211" y2="65.5" gradientUnits="userSpaceOnUse">
                    <stop stop-color="currentColor" class="text-secondary-80 dark:text-secondary-40" />
                    <stop offset="1" stop-color="currentColor" />
                </linearGradient>
                <linearGradient id="paint1" x1="74.2" y1="90" x2="88" y2="90" gradientUnits="userSpaceOnUse">
                    <stop stop-color="currentColor" class="text-secondary-80 dark:text-secondary-40" />
                    <stop offset="1" stop-color="currentColor" />
                </linearGradient>
                <linearGradient id="paint2" x1="150" y1="46.4" x2="150" y2="32" gradientUnits="userSpaceOnUse">
                    <stop stop-color="currentColor" class="text-secondary-80 dark:text-secondary-40" />
                    <stop offset="1" stop-color="currentColor" />
                </linearGradient>
            </defs>
        </svg>-->

    </footer>

    @production
    <script async defer data-website-id="4e8482d0-2870-42ab-92d3-02854e972369" data-cache="true" src="https://stats.felixinx.me/umami.js"></script>
    @endproduction

    @cookieconsentview
</body>

</html>