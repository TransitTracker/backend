@extends('layouts.vin')

@section('body')
    <div class="container grid grid-cols-1 px-4 mx-auto mt-8 md:grid-cols-3 gap-y-8 gap-x-12">
        <h1 class="text-2xl font-bold md:mb-4 md:text-4xl text-m3-primary-on-container dark:text-white col-span-full">VIN {{ $vin }}</h1>
        
        <div class="md:col-span-2">
            <ul class="flex overflow-auto gap-x-4">
                @foreach($vehicles as $vehicle)
                    <li class="flex-shrink-0 px-4 py-2 mb-2 space-y-2 text-sm bg-white rounded dark:bg-m3-surface-dark-variant dark:text-m3-surface-dark-on-variant">
                        <div class="inline px-2 py-1 rounded" style="color: {{ $vehicle->agency->text_color }};background-color: {{ $vehicle->agency->color }};">
                            {{ $vehicle->agency->short_name }}
                        </div>
                        @if($vehicle->force_label)<small class="ml-2 text-xs tracking-wide">{{ __('Fleet label:') }} {{ $vehicle->force_label }}</small>@endif
                        <div>{{ __('Last seen:') }} {{ now()->parse($vehicle->updated_at)->diffForHumans() }}</div>
                    </li>
                @endforeach
            </ul>

            @if($sessionSuggestion)
            <div class="flex flex-col items-center justify-center p-4 mt-6 bg-white rounded shadow dark:bg-m3-surface-dark dark:text-m3-surface-dark-on">
                <h2 class="text-xl font-medium leading-8 tracking-wide">{{ __('Thanks for your suggestion!') }}</h2>
                <x-gmdi-check class="w-12 h-12 text-green-700 fill-current" />
            </div>
            @else
            <form action="" method="POST" class="p-4 mt-6 bg-white rounded shadow dark:bg-m3-surface-dark dark:text-m3-surface-dark-on dark:border dark:border-m3-background-dark-outline" id="form-suggest">
                @csrf
                <input type="hidden" value="{{ $vin }}" id="vin" name="vin">
                
                <h2 class="text-xl font-medium leading-8 tracking-wide">{{ __('Submit a new fleet number') }}</h2>

                <div class="relative mt-8 mb-4">
                    <input type="text" id="label" placeholder="{{ __('Fleet number') }}" name="label" required
                        class="w-48 h-8 px-0 py-2 mb-2 placeholder-transparent transition-colors bg-transparent border-0 border-b-2 border-black dark:border-white peer focus:ring-0 border-opacity-40 dark:border-opacity-60 focus:border-primary-500 dark:focus:border-white focus:border-opacity-100 @error('label') border-red-500 border-opacity-100 @enderror" />
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
                
                @error('g-recaptcha-response')
                <div class="mb-4 text-xs font-medium text-red-500">{{ __('The reCAPTCHA validation has failed. Please try again.') }}</div>
                @enderror

                <div class="flex gap-x-2">
                    <button data-sitekey="{{ config('transittracker.recaptcha.site') }}" data-callback='onSuggestSubmit'
                        class="relative flex items-center h-10 px-6 text-sm font-medium transition-colors rounded-full bg-m3-primary text-m3-primary-on dark:bg-m3-primary-dark dark:text-m3-primary-dark-on hover:bg-opacity-85 focus:bg-opacity-75">
                        {{ __('Send') }}
                        <x-gmdi-send class="w-5 h-5 ml-2" />
                    </button>
                    @auth
                        @foreach($vehicles as $vehicle)
                        <button formaction="{{ route('vin.agency.store', ['agency' => $vehicle->agency->slug]) }}" formmethod="POST" type="submit" class="relative flex items-center h-10 px-6 text-sm font-medium transition-colors rounded-full bg-m3-secondary-container text-m3-secondary-on-container dark:bg-m3-secondary-dark-container dark:text-m3-secondary-dark-on-container hover:bg-opacity-80 hover:bg-opacity-85 focus:bg-opacity-75">
                            <x-gmdi-save class="w-5 h-5 mr-2" />
                            Save to {{ $vehicle->agency->short_name }}
                        </button>
                        @endforeach
                    @endauth
                </div>

            </form>
            @endif
        </div>
        <div class="mt-1 bg-white rounded shadow dark:bg-m3-surface-dark-variant dark:text-m3-surface-dark-on-variant">
            <div class="flex items-center h-12 px-4 text-sm uppercase opacity-60">{{ __('Submitted suggestions') }}</div>
            <ul>
                @foreach($suggestions as $suggestion)
                <li>
                    <div class="flex items-center px-4 py-3 gap-x-4 @if($sessionVote === $suggestion->id) bg-green-100 @endif">
                        <div class="flex-grow">
                            <p class="mb-2 leading-tight">{{ $suggestion->label }}</p>
                            <small class="text-sm leading-tight">
                                @if($suggestion->note)
                                {{ $suggestion->note }} &bull;
                                @endif
                                {{ $suggestion->created_at->diffForHumans() }}
                            </small>
                            @if($sessionVote === $suggestion->id)
                                <div class="py-0.5 px-1 rounded bg-green-500 text-white text-xs inline-block">{{ __('You have voted for this suggestion') }}</div>
                            @endif
                            @if($sessionSuggestion === $suggestion->label)
                                <div class="py-0.5 px-1 rounded bg-gray-700 text-white text-xs inline-block">{{ __('Your suggestion') }}</div>
                            @endif
                        </div>
                        @guest
                        <form action="{{ route('vin.vote', ['vinSuggestion' => $suggestion->id]) }}" method="POST" id="form-vote">
                            @csrf
                            <button data-sitekey="{{ config('transittracker.recaptcha.site') }}" data-callback='onVoteSubmit'
                                @if($sessionVote) disabled @endif
                                class="relative flex items-center justify-center w-9 h-9 before:rounded-full before:absolute before:inset-0 before:bg-black dark:before:bg-white before:opacity-0 hover:before:opacity-5 dark:hover:before:opacity-10 disabled:before:opacity-0 focus:before:opacity-5 disabled:cursor-not-allowed group @if(!$sessionVote) g-recaptcha @endif">
                                <x-gmdi-thumb-up class="w-6 h-6 text-green-700 fill-current group-disabled:text-gray-300" />
                            </button>
                        </form>
                        @endguest
                        @auth
                        {{ $suggestion->upvotes }}
                        <div x-data="{showModal: false}">
                            <button
                                x-on:click="showModal = true"
                                class="relative flex items-center justify-center w-9 h-9 before:rounded-full before:absolute before:inset-0 before:bg-black before:opacity-0 hover:before:opacity-5 focus:before:opacity-5 disabled:cursor-not-allowed group">
                                <x-gmdi-check class="w-6 h-6 text-green-700 fill-current group-disabled:text-gray-300" />
                            </button>
                            <div class="absolute inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50" x-show="showModal">
                                <div class="bg-white dark:bg-m3-surface-dark dark:text-m3-surface-dark-on rounded shadow-xl w-[280px]" x-on:click.away="showModal = false">
                                    <div class="flex items-center h-16 pl-6 pr-2 text-xl font-medium tracking-wide shadow">Apply new VIN to</div>
                                    <div class="pl-6 pr-2">
                                        @foreach($vehicles as $vehicle)
                                        <form action="{{ route('vin.approve', ['vinSuggestion' => $suggestion->id, 'agency' => $vehicle->agency->slug]) }}" method="POST">
                                            @csrf
                                            <button class="flex items-center h-12 gap-x-8" type="submit">
                                                <input type="radio" id="{{ $vehicle->agency->slug }}" class="text-2xl text-secondary-500 dark:text-secondary-900">
                                                <label for="{{ $vehicle->agency->slug }}" class="text-sm tracking-wide">{{ $vehicle->agency->short_name }}</label>
                                            </button>
                                        </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('vin.delete', ['vinSuggestion' => $suggestion->id]) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="relative flex items-center justify-center w-9 h-9 before:rounded-full before:absolute before:inset-0 before:bg-black before:opacity-0 hover:before:opacity-5 focus:before:opacity-5 disabled:cursor-not-allowed group">
                                <x-gmdi-delete class="w-6 h-6 text-red-700 fill-current group-disabled:text-gray-300" />
                            </button>
                        </form>
                        @endauth
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSuggestSubmit(token) {
            document.getElementById('form-suggest').submit()
            console.log(token)
        }
        function onVoteSubmit(token) {
            document.getElementById('form-vote').submit()
            console.log(token)
        }
    </script>
    <style>
        .grecaptcha-badge {
            bottom: 64px !important;
        }
    </style>
@endsection
