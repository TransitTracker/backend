@extends('layouts.app')

@section('body')
@auth
    <div class="bg-primary-700 text-white">
        <div class="container mx-auto px-4 flex items-center gap-x-4 py-2">
            <b class="font-medium text-sm tracking-wide">Admin panel:</b>
            <a href="/horizon"
                class="rounded inline-flex items-center font-medium bg-white bg-opacity-0 hover:bg-opacity-10 focus:bg-opacity-10 px-4 py-2 text-sm tracking-wider uppercase justify-self-start self-end">
                Horizon
            </a>
            <div class="flex-grow"></div>
            <a href="{{ route('logout') }}"
                class="rounded inline-flex items-center font-medium bg-white bg-opacity-0 hover:bg-opacity-10 focus:bg-opacity-10 px-4 py-2 text-sm tracking-wider uppercase justify-self-start self-end">
                Log out
            </a>
        </div>
    </div> 
@endauth
    <div class="bg-secondary-500 bg-tt-pattern bg-32 relative">
        <div class="bg-gradient-to-r from-secondary-500 to-transparent py-10">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl xl:text-6xl text-primary-900 font-bold md:w-2/3 lg:w-1/3">{{ __('Making realtime transit data accessible') }}</h1>
            </div>
        </div>
    </div>
    <div class="container grid lg:grid-cols-3 gap-y-8 lg:gap-x-12 mx-auto px-4 mt-8">
        <div class="bg-white rounded-lg shadow-sm p-4 grid">
            <div class="flex items-center mb-2">
                <h3 class="text-lg font-semibold">{{ __('REST API for developers') }}</h3>
                <span class="ml-2 mr-2 py-1 px-2 rounded-2xl bg-secondary-700 text-white font-medium text-xs">{{ __('Free!') }}</span>
                <div class="flex-grow"></div>
                <x-gmdi-code class="w-8 h-8 text-secondary-700" />
            </div>
            <p class="mb-4">{{ __('A simple JSON REST api to access realtime transit from multiple Canadians cities, like Toronto, Montréal, Gatineau and more!') }}</p>
            <div class="flex flex-wrap gap-2">
                <a target="_blank" href="https://felixinx.stoplight.io/docs/transit-tracker" class="rounded inline-flex items-center text-white font-medium shadow bg-primary-500 hover:bg-opacity-80 px-4 py-2 text-sm tracking-wider uppercase justify-self-start self-end">
                    {{ __('Docs') }}
                    <x-gmdi-open-in-new class="w-5 h-5 ml-2" />
                </a>
                <a target="_blank" href="https://{{ app()->getLocale() === 'en' ? 'status' : 'statut' }}.transittracker.ca" class="rounded inline-flex items-center text-white font-medium shadow bg-primary-500 hover:bg-opacity-80 px-4 py-2 text-sm tracking-wider uppercase justify-self-start self-end">
                    {{ __('Status') }}
                    <x-gmdi-open-in-new class="w-5 h-5 ml-2" />
                </a>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 grid">
            <div class="flex items-center mb-2">
                <h3 class="text-lg font-semibold">{{ __('Bring Your Own Data') }}</h3>
                <div class="flex-grow"></div>
                <x-gmdi-upload-file class="w-8 h-8 text-secondary-700" />
            </div>
            <p class="mb-4">{{ __('You can now locally import your GTFS-Realtime feeds into Transit Tracker. Along with the static feed, you can access all Transit Tracker features for any compatible cities!') }}</p>
            <a target="_blank" href="https://www.transittracker.ca/{{ app()->getLocale() === 'en' ? '' : 'fr/' }}byod" class="rounded inline-flex items-center text-white font-medium shadow bg-primary-500 hover:bg-opacity-80 px-4 py-2 text-sm tracking-wider uppercase justify-self-start self-end">
                {{ __('Start now') }}
                <x-gmdi-open-in-new class="w-5 h-5 ml-2" />
            </a>
        </div>
        <div class="bg-primary-500 text-white rounded-lg shadow-sm p-4 grid">
            <div class="flex items-center mb-2">
                <h3 class="text-lg font-semibold">{{ __('Looking for Transit Tracker?') }}</h3>
                <div class="flex-grow"></div>
                <x-gmdi-pin-drop class="w-8 h-" />
            </div>
            <p class="mb-4">{{ __('If you are not a developer, you can always use Transit Tracker without any technical knowledge.') }}</p>
            <a target="_blank" href="https://www.transittracker.ca/{{ app()->getLocale() === 'en' ? '' : 'fr' }}" class="rounded inline-flex items-center font-medium shadow bg-white text-black hover:bg-opacity-80 px-4 py-2 text-sm tracking-wider uppercase justify-self-start self-end">
                {{ __('transittracker.ca') }}
                <x-gmdi-open-in-new class="w-5 h-5 ml-2" />
            </a>
        </div>
    </div>
@endsection
