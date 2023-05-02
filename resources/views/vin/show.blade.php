@extends('layouts.vin')

@section('body')
    <div class="container grid grid-cols-1 px-4 mx-auto mt-8 md:grid-cols-3 gap-y-8 gap-x-12">
        <h1 class="text-2xl font-bold md:mb-4 md:text-4xl text-m3-primary-on-container dark:text-white col-span-full font-heading">
            VIN {{ $vin }}
        </h1>
        @if ($information->make)
            <div class="col-span-full font-medium text-[1.375rem] leading-7 text-m3-primary-on-container dark:text-white -mt-6 md:-mt-10 flex items-center gap-x-2"
                x-data="{ vinInfo: false }">
                <h2>{{ $information->make }} {{ $information->model }} {{ $information->year }}</h2>

                <x-icon-button.standard href="#" @click="vinInfo = true">
                    <x-gmdi-info class="h-6 w-6 text-current dark:text-white" />
                </x-icon-button.standard>
                <x-dialog.basic showProp="vinInfo">
                    <x-slot:title>{{ __('Aditionnal information based on VIN number') }}</x-slot>
                        {{ __('This information is generated automatically from the NHTSA Product Information Catalog Vehicle Listing (vPIC).') }}
                        <a href="https://vpic.nhtsa.dot.gov/api/Home" class=" inline-flex items-center gap-x-1 underline"
                            target="_blank">
                            <span>{{ __('Source') }}</span>
                            <x-gmdi-open-in-new class="h-4 w-4 text-current" />
                        </a>
                        <x-slot:body>
                            <dl class="text-sm">
                                <dt class="text-xs">{{ __('Manufacturer') }}</dt>
                                <dd class="mt-0.5">
                                    {{ $information->make }}
                                </dd>
                                <dt class="mt-2 text-xs">{{ __('Year') }}</dt>
                                <dd class="mt-0.5">
                                    {{ $information->year }}
                                </dd>
                                <dt class="mt-2 text-xs">{{ __('Model') }}</dt>
                                <dd class="mt-0.5">
                                    {{ $information->model }}
                                </dd>
                                @if (filled($information->engine))
                                    <dt class="mt-2 text-xs">{{ __('Engine') }}</dt>
                                    <dd class="mt-0.5">
                                        {{ $information->engine }}
                                    </dd>
                                @endif
                                @if ($information->fuel)
                                    <dt class="mt-2 text-xs">{{ __('Propulsion') }}</dt>
                                    <dd class="mt-0.5">
                                        {{ $information->fuel }}
                                    </dd>
                                @endif
                                @if ($information->length)
                                    <dt class="mt-2 text-xs">{{ __('Length') }}</dt>
                                    <dd class="mt-0.5">
                                        {{ $information->length }}
                                    </dd>
                                @endif
                                <dt class="mt-2 text-xs">{{ __('Assembly plant') }}</dt>
                                <dd class="mt-0.5">
                                    {{ $information->assembly }}
                                </dd>
                                <dt class="mt-2 text-xs">{{ __('Sequence') }}</dt>
                                <dd class="mt-0.5">
                                    {{ $information->sequence }}
                                </dd>
                                @if ($information->others)
                                    @foreach ($information->others as $label => $value)
                                        <dt class="mt-2 text-xs">{{ $label }}*</dt>
                                        <dd class="mt-0.5">
                                            {{ $value }}
                                        </dd>
                                    @endforeach
                                    <p class="mt-4 italic">
                                        {{ __('* Additional information provided by NHTSA. May represent information about the vehicle model and not that vehicle exactly.') }}
                                    </p>
                                @endif
                            </dl>
                            </x-slot>
                            <x-slot:actions>
                                <div class="flex">
                                    <x-button.text href="#" :hasIcon="false" @click="vinInfo = false"
                                        class="ml-auto">
                                        Close
                                    </x-button.text>
                                </div>
                            </x-slot>
                </x-dialog.basic>
            </div>
        @endif

        <div class="md:col-span-2">
            <ul class="space-y-2">
                @foreach ($vehicles as $vehicle)
                    <li class="flex-shrink-0 py-2 px-4 mb-2 space-y-2 rounded-2xl bg-m3-surface-variant text-m3-surface-on-variant dark:bg-m3-surface-dark-variant dark:text-m3-surface-dark-on-variant"
                        x-data="{ open: false }">
                        <div class="flex items-center gap-x-4">
                            <b class="mb-0 font-medium leading-6 tracking-wide">
                                {{ $vehicle->force_label ? $vehicle->force_label : __('Unknown') }}
                            </b>
                            @foreach ($vehicle->tags as $tag)
                                <div class="items-center rounded px-2 py-1" title="{{ $tag->description }}"
                                    style="background-color: {{ $tag->color }};color: {{ $tag->text_color }}">
                                    {{ $tag->label }}</div>
                            @endforeach
                            <div class="grow"></div>
                            <x-button.text :has-icon="true"
                                href="{{ route('vin.agency.show', ['agency' => $vehicle->agency->slug]) }}"
                                class="text-m3-surface-on-variant dark:text-m3-surface-dark-on-variant">
                                <span class="inline-block w-4 h-4 rounded-full"
                                    style="background-color: {{ $vehicle->agency->color }}"></span>
                                <span>{{ $vehicle->agency->short_name }}</span>
                            </x-button.text>
                        </div>
                        <div class="flex items-center gap-x-1 text-xs">
                            <x-gmdi-access-time class="w-4 h-4 fill-current" />
                            <span>
                                {{ __('Last seen') }}
                                {{ now()->parse($vehicle->updated_at)->diffForHumans() }}
                            </span>
                            <div class="flex-grow"></div>
                            @if ($vehicle->active)
                                <a href="https://transittracker.ca/regions/mtl/map?vehicle={{ $vehicle->id }}"
                                    class="bg-m3-primary text-m3-primary-on dark:bg-m3-primary-dark dark:text-m3-primary-dark-on pl-1 pr-2 flex items-center gap-x-1 rounded min-h-[1.5rem]">
                                    <x-gmdi-pin-drop class="w-4 h-4 text-current" />
                                    <span>{{ __('Live on') }} <b>Transit Tracker</b></span>
                                </a>
                            @else
                                <button class="flex items-center gap-x-1"
                                    x-on:click="open = !open">{{ __('Show latest info') }}
                                    <x-gmdi-keyboard-arrow-down class="w-4 h-4 text-current transition-transform"
                                        x-bind:class="open ? 'rotate-180' : ''" />
                                </button>
                            @endif
                        </div>
                        <div class="-mx-4 mt-2" x-show="open" x-collapse>
                            <dl
                                class="border-t border-m3-surface-on-variant/25 dark:border-m3-surface-dark-on-variant/25 px-4 py-2">
                                <dt class="text-xs mb-0.5">{{ __('Last trip') }}</dt>
                                <dd>
                                    <b class="font-medium leading-6 tracking-wide">{{ $vehicle->gtfsRoute->short_name }}
                                        {{ $vehicle->gtfsRoute->long_name }}</b>
                                    @if ($vehicle->trip->headsign)
                                        <div class="flex gap-x-1 items-center">
                                            <x-gmdi-arrow-forward class="w-4 h-4 text-current" />
                                            {{ $vehicle->trip->headsign }}
                                        </div>
                                    @endif
                                    @if ($vehicle->trip->short_name)
                                        <div class="flex gap-x-1 items-center">
                                            <x-gmdi-view-timeline class="w-4 h-4 text-current" />
                                            {{ __('Departure #') }}{{ $vehicle->trip->short_name }}
                                        </div>
                                    @endif
                                    <div class="flex gap-x-1 items-center">
                                        <x-gmdi-numbers class="w-4 h-4 text-current" />
                                        {{ $vehicle->gtfs_trip_id }}
                                    </div>
                                </dd>
                            </dl>
                            <dl
                                class="border-t border-m3-surface-on-variant/25 dark:border-m3-surface-dark-on-variant/25 px-4 py-2">
                                <dt class="text-xs mb-0.5">{{ __('Last position') }}</dt>
                                <dd>
                                    <a href="https://www.openstreetmap.org/?mlat={{ $vehicle->lat }}&mlon={{ $vehicle->lon }}#map=16/{{ $vehicle->lat }}/{{ $vehicle->lon }}&layers=T"
                                        target="_blank" class="flex gap-x-1 items-center underline">
                                        <x-gmdi-pin-drop class="w-4 h-4 text-current" /> {{ $vehicle->lat }},
                                        {{ $vehicle->lon }}
                                        @if ($vehicle->bearing)
                                            <x-gmdi-north class="w-4 h-4 text-current"
                                                style="transform:rotate({{ $vehicle->bearing }}deg)" />
                                        @endif
                                    </a>
                                    @if ($vehicle->speed)
                                        <div class="flex gap-x-1 items-center">
                                            <x-gmdi-speed class="w-4 h-4 text-current" />
                                            {{ $vehicle->speed }} km/h
                                        </div>
                                    @endif
                                </dd>
                            </dl>
                            @if (App::currentLocale() === 'en')
                                <small class="text-xs italic px-4">{{ __('As of') }}
                                    {{ $vehicle->updated_at->isoFormat('MMMM Do g') }} {{ __('at') }}
                                    {{ $vehicle->updated_at->isoFormat('hh:mm a') }}</small>
                            @else
                                <small class="text-xs italic px-4">{{ __('As of') }}
                                    {{ $vehicle->updated_at->isoFormat('Do MMMM g') }} {{ __('at') }}
                                    {{ $vehicle->updated_at->isoFormat('kk:mm') }}</small>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>

            @if ($sessionSuggestion)
                <div
                    class="flex flex-col items-center justify-center p-4 mt-6 bg-white rounded shadow dark:bg-m3-surface-dark dark:text-m3-surface-dark-on">
                    <h2 class="text-xl font-medium leading-8 tracking-wide">{{ __('Thanks for your suggestion!') }}
                    </h2>
                    <x-gmdi-check class="w-12 h-12 text-green-700 fill-current" />
                </div>
            @else
                <form action="" method="POST"
                    class="p-4 mt-6 border rounded-2xl text-m3-surface-on dark:bg-m3-surface-dark dark:text-m3-surface-dark-on border-m3-background-outline dark:border-m3-background-dark-outline"
                    id="form-suggest">
                    @csrf
                    
                    @env('local')
                    <input type="hidden" value="good" id="cf-turnstile-response" name="cf-turnstile-response" />
                    @endenv

                    <input type="hidden" value="{{ $vin }}" id="vin" name="vin">

                    <h2 class="text-[1.375rem] leading-8">{{ __('Submit a new fleet number') }}</h2>

                    <div class="relative mt-8 mb-4">
                        <input type="text" id="label" placeholder="{{ __('Fleet number') }}" name="label"
                            required value="{{ @old('label') }}"
                            class="w-48 h-8 px-0 py-2 mb-2 placeholder-transparent transition-colors bg-transparent border-0 border-b-2 border-black/40 dark:border-white peer focus:ring-0 dark:border-opacity-60 focus:border-primary-500 dark:focus:border-white focus:border-opacity-100 @error('label') border-red-500 border-opacity-100 @enderror" />
                        <label for="label"
                            class="absolute left-0 transition-transform origin-top-left scale-75 -translate-y-8 top-1/2 opacity-60 peer-focus:-translate-y-8 peer-focus:scale-75 peer-focus:text-primary-500 dark:peer-focus:text-white peer-focus:opacity-100 peer-placeholder-shown:-translate-y-4 peer-placeholder-shown:scale-100 @error('label') text-red-500 opacity-100 @enderror">
                            {{ __('Fleet number') }}
                        </label>
                        @error('label')
                            <div class="absolute text-xs text-red-500 -bottom-3">{{ $message }}</div>
                            <!-- <div class="absolute text-xs text-red-500 -bottom-3">{{ __('This field is required.') }}</div> -->
                        @enderror
                    </div>

                    <div class="relative mt-8 mb-4">
                        <input type="text" id="note" placeholder="Extra note" name="note"
                            class="w-full h-8 px-0 py-2 mb-2 placeholder-transparent transition-colors bg-transparent border-0 border-b-2 border-black dark:border-white peer focus:ring-0 border-opacity-40 dark:border-opacity-60 focus:border-primary-500 dark:focus:border-white focus:border-opacity-100" />
                        <label for="note"
                            class="absolute left-0 transition-transform origin-top-left scale-75 -translate-y-8 top-1/2 opacity-60 peer-focus:-translate-y-8 peer-focus:scale-75 peer-focus:text-primary-500 dark:peer-focus:text-white peer-focus:opacity-100 peer-placeholder-shown:-translate-y-4 peer-placeholder-shown:scale-100">
                            {{ __('Extra note') }}
                        </label>
                    </div>

                    <div class="cf-turnstile" data-sitekey="{{ config('transittracker.turnstile.site_key') }}" data-size="compact"></div>

                    @error('cf-turnstile-response')
                        <div class="mb-4 text-xs font-medium text-red-500">
                            {{ __('The captcha validation has failed. Please try again.') }}
                        </div>
                    @enderror

                    <div class="flex">
                        <button type="submit"
                            class="relative flex items-center h-10 px-6 text-sm font-medium transition-colors rounded-full bg-m3-primary text-m3-primary-on dark:bg-m3-primary-dark dark:text-m3-primary-dark-on hover:bg-opacity-85 focus:bg-opacity-75">
                            {{ __('Send') }}
                            <x-gmdi-send class="w-5 h-5 ml-2" />
                        </button>
                    </div>

                </form>
            @endif
        </div>
        <div
            class="py-4 mt-1 rounded-2xl bg-m3-surface-variant text-m3-surface-on-variant dark:bg-m3-surface-dark-variant dark:text-m3-surface-dark-on-variant">
            <h2 class="text-sm font-medium leading-5 tracking-[0.007rem] px-4">{{ __('Submitted suggestions') }}
            </h2>
            <ul class="font-medium">
                @foreach ($suggestions as $suggestion)
                    <li>
                        <div
                            class="flex items-center py-3 px-4 gap-x-4 @if ($sessionVote === $suggestion->id) bg-green-100 @endif">
                            <div class="flex-grow">
                                <p class="leading-6">{{ $suggestion->label }}</p>
                                <small class="text-xs leading-4">
                                    {{ $suggestion->created_at->diffForHumans() }}
                                    @if ($suggestion->note)
                                        &bull; {{ $suggestion->note }}
                                    @endif
                                </small>
                                @if ($sessionVote === $suggestion->id)
                                    <div class="py-0.5 px-1 rounded bg-green-500 text-white text-xs inline-block">
                                        {{ __('You have voted for this suggestion') }}
                                    </div>
                                @endif
                                @if ($sessionSuggestion === $suggestion->label)
                                    <div class="py-0.5 px-1 rounded bg-gray-700 text-white text-xs inline-block">
                                        {{ __('Your suggestion') }}
                                    </div>
                                @endif
                                @if ($suggestion->is_rejected)
                                    <div
                                        class="py-0.5 px-1 rounded bg-m3-error text-m3-error-on dark:bg-m3-error-dark dark:text-m3-error-dark-on text-xs inline-block">
                                        {{ __('Rejected') }}
                                    </div>
                                @endif
                            </div>
                            @guest
                                <form action="{{ route('vin.vote', ['suggestion' => $suggestion->id]) }}" method="POST"
                                    id="form-vote">
                    
                                    @env('local')
                                    <input type="hidden" value="good" id="cf-turnstile-response" name="cf-turnstile-response" />
                                    @endenv

                                    <div class="cf-turnstile" data-sitekey="{{ config('transittracker.turnstile.site_key') }}" data-size="compact"></div>
                                    
                                    @csrf
                                    <button @if ($sessionVote) disabled @endif
                                        class="relative flex items-center justify-center w-9 h-9 before:rounded-full before:absolute before:inset-0 before:bg-black dark:before:bg-white before:opacity-0 hover:before:opacity-5 dark:hover:before:opacity-10 disabled:before:opacity-0 focus:before:opacity-5 disabled:cursor-not-allowed group">
                                        <x-gmdi-thumb-up
                                            class="w-6 h-6 text-green-700 fill-current group-disabled:text-gray-300" />
                                    </button>
                                </form>
                            @endguest
                            @auth
                                {{ $suggestion->upvotes }}
                                <div x-data="{ showModal: false }">
                                    <button x-on:click="showModal = true"
                                        class="relative flex items-center justify-center w-9 h-9 before:rounded-full before:absolute before:inset-0 before:bg-black before:opacity-0 hover:before:opacity-5 focus:before:opacity-5 disabled:cursor-not-allowed group">
                                        <x-gmdi-check
                                            class="w-6 h-6 text-green-700 fill-current group-disabled:text-gray-300" />
                                    </button>
                                    <div class="absolute inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50"
                                        x-show="showModal">
                                        <div class="bg-white dark:bg-m3-surface-dark dark:text-m3-surface-dark-on rounded shadow-xl w-[280px]"
                                            x-on:click.away="showModal = false">
                                            <div
                                                class="flex items-center h-16 pl-6 pr-2 text-xl font-medium tracking-wide shadow">
                                                Apply new VIN to</div>
                                            <div class="pl-6 pr-2">
                                                @foreach ($vehicles as $vehicle)
                                                    <form
                                                        action="{{ route('vin.approve', ['suggestion' => $suggestion->id, 'agency' => $vehicle->agency->slug]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="flex items-center h-12 gap-x-8" type="submit">
                                                            <input type="radio" id="{{ $vehicle->agency->slug }}"
                                                                class="text-2xl text-secondary-500 dark:text-secondary-900">
                                                            <label for="{{ $vehicle->agency->slug }}"
                                                                class="text-sm tracking-wide">{{ $vehicle->agency->short_name }}</label>
                                                        </button>
                                                    </form>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('vin.reject', ['suggestion' => $suggestion->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="relative flex items-center justify-center w-9 h-9 before:rounded-full before:absolute before:inset-0 before:bg-black before:opacity-0 hover:before:opacity-5 focus:before:opacity-5 disabled:cursor-not-allowed group">
                                        <x-gmdi-close class="w-6 h-6 text-red-700 fill-current group-disabled:text-gray-300" />
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        @auth
            <div class="col-span-full flex gap-x-2">
                @foreach ($vehicles as $vehicle)
                    <a href="{{ route('filament.resources.vehicles.edit', ['record' => $vehicle]) }}" target="_blank"
                        class="relative flex items-center gap-2 h-10 pl-6 pr-4 text-sm font-medium transition-colors rounded-full bg-m3-secondary-container text-m3-secondary-on-container dark:bg-m3-secondary-dark-container dark:text-m3-secondary-dark-on-container hover:bg-opacity-80 hover:bg-opacity-85 focus:bg-opacity-75">
                        {{ $vehicle->agency->short_name }} in admin
                        <x-gmdi-open-in-new class="w-[1.125rem] h-[1.125rem]" />
                    </a>
                @endforeach
            </div>
        @endauth
    </div>

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endsection
