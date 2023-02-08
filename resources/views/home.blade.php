@extends('layouts.app')

@section('body')
    @auth
        <div class="text-white bg-primary-700 dark:bg-primary-900">
            <div class="container flex items-center px-4 py-2 mx-auto gap-x-4">
                <b class="text-sm font-medium tracking-wide">Admin panel:</b>
                <a href="/horizon"
                    class="inline-flex items-center self-end px-4 py-2 text-sm font-medium tracking-wider uppercase bg-white bg-opacity-0 rounded hover:bg-opacity-10 focus:bg-opacity-10 justify-self-start">
                    Horizon
                </a>
                <a href="/vin"
                    class="inline-flex items-center self-end px-4 py-2 text-sm font-medium tracking-wider uppercase bg-white bg-opacity-0 rounded hover:bg-opacity-10 focus:bg-opacity-10 justify-self-start">
                    Vin
                </a>
                <div class="flex-grow"></div>
                <a href="{{ route('logout') }}"
                    class="inline-flex items-center self-end px-4 py-2 text-sm font-medium tracking-wider uppercase bg-white bg-opacity-0 rounded hover:bg-opacity-10 focus:bg-opacity-10 justify-self-start">
                    Log out
                </a>
            </div>
        </div>
    @endauth
    <div class="relative bg-secondary-500 dark:bg-secondary-700 bg-tt-pattern bg-32">
        <div class="py-10 bg-gradient-to-r from-secondary-500 dark:from-secondary-700 to-transparent">
            <div class="container px-4 mx-auto">
                <h1 class="text-4xl font-bold xl:text-6xl text-primary-900 dark:text-white md:w-2/3 lg:w-1/3">
                    {{ __('Making realtime transit data accessible') }}</h1>
            </div>
        </div>
    </div>
    <div class="container grid px-4 mx-auto mt-8 lg:grid-cols-3 gap-y-8 lg:gap-x-12">
        <div class="grid p-4 bg-white rounded-lg shadow-sm dark:bg-grey dark:text-white">
            <div class="flex items-center mb-2">
                <h3 class="text-lg font-semibold">{{ __('REST API for developers') }}</h3>
                <span
                    class="px-2 py-1 ml-2 mr-2 text-xs font-medium text-white rounded-2xl bg-secondary-700 dark:bg-secondary-900">{{ __('Free!') }}</span>
                <div class="flex-grow"></div>
                <x-gmdi-code class="w-8 h-8 text-secondary-700 dark:text-white" />
            </div>
            <p class="mb-4">
                {{ __('A simple JSON REST api to access realtime transit from multiple Canadians cities, like Toronto, Montréal, Gatineau and more!') }}
            </p>
            <div class="flex flex-wrap gap-2">
                <a target="_blank" href="/docs"
                    class="inline-flex items-center self-end px-4 py-2 text-sm font-medium tracking-wider text-white uppercase rounded shadow bg-primary-500 dark:bg-primary-700 hover:bg-opacity-80 justify-self-start">
                    {{ __('Docs') }}
                    <x-gmdi-open-in-new class="w-5 h-5 ml-2" />
                </a>
                <a target="_blank" href="https://{{ app()->getLocale() === 'en' ? 'status' : 'statut' }}.transittracker.ca"
                    class="inline-flex items-center self-end px-4 py-2 text-sm font-medium tracking-wider text-white uppercase rounded shadow bg-primary-500 dark:bg-primary-700 hover:bg-opacity-80 justify-self-start">
                    {{ __('Status') }}
                    <x-gmdi-open-in-new class="w-5 h-5 ml-2" />
                </a>
            </div>
        </div>
        <div class="grid p-4 text-white rounded-lg shadow-sm bg-primary-500 dark:bg-primary-700">
            <div class="flex items-center mb-2">
                <h3 class="text-lg font-semibold">{{ __('Looking for Transit Tracker?') }}</h3>
                <div class="flex-grow"></div>
                <x-gmdi-pin-drop class="w-8 h-" />
            </div>
            <p class="mb-4">
                {{ __('If you are not a developer, you can always use Transit Tracker without any technical knowledge.') }}
            </p>
            <a target="_blank" href="https://www.transittracker.ca/{{ app()->getLocale() === 'en' ? '' : 'fr' }}"
                class="inline-flex items-center self-end px-4 py-2 text-sm font-medium tracking-wider text-black uppercase bg-white rounded shadow dark:bg-grey dark:text-white hover:bg-opacity-80 justify-self-start">
                {{ __('transittracker.ca') }}
                <x-gmdi-open-in-new class="w-5 h-5 ml-2" />
            </a>
        </div>
    </div>
@endsection
