@extends('layouts.vin')

@section('body')
    <div class="container grid grid-cols-6 px-4 mx-auto mt-8 md:grid-cols-12 gap-y-8 gap-x-12">
        <h1 class="col-span-6 text-2xl font-bold md:col-span-8 md:mb-4 md:text-4xl text-primary-700 dark:text-white">{{ __('exo VIN Database') }}</h1>
        <div class="flex items-start col-span-6 md:justify-end md:col-span-4" x-data="{vin: ''}">
            <form x-bind:action="'/vin/'+vin" class="flex shadow">
                <input x-model="vin" type="text" placeholder="VIN" class="border-transparent rounded-l dark:bg-m3-surface-dark-variant focus:border-transparent focus:outline-none focus:ring-0 dark:text-m3-surface-dark-on-variant" maxlength="17" minlength="17" required>
                <button class="p-2 text-white transition-colors rounded-r bg-primary-500 hover:bg-primary-700 dark:bg-m3-primary-dark-container dark:hover:bg-primary-900" type="submit">
                    <x-gmdi-arrow-forward class="w-6 h-6" />
                </button>
            </form>
        </div>
        
        <ul class="flex overflow-x-auto gap-x-4 col-span-full">
            <li class="relative flex flex-col items-center justify-center flex-shrink-0 w-32 h-32 bg-white rounded-full dark:bg-m3-surface-dark-variant dark:text-m3-surface-dark-on-variant" x-data="{ c: Math.PI * 2 * 55, p: {{ $allLabelled / ($allLabelled + $allUnlabelled) }} * 100 }">
                <svg class="absolute inset-0 w-32 h-32 transform -rotate-90">
                    <circle class="text-black text-opacity-20" stroke-width="5" stroke="currentColor" fill="transparent" r="55" cx="64" cy="64" />
                    <circle class="text-black" stroke-width="5" :stroke-dasharray="c"
                        :stroke-dashoffset="c - p / 100 * c" stroke-linecap="round" stroke="currentColor"
                        fill="transparent" r="55" cx="64" cy="64" />
                </svg>
                <small class="text-xs font-medium uppercase">{{ __('All') }}</small>
                <p class="font-medium">{{ $allLabelled }}</p>
                <p class="text-xs">{{ __('on') }} {{ $allUnlabelled + $allLabelled }}</p>
            </li>
            @foreach($agencies as $agency)
            <li
                class="relative flex flex-col items-center justify-center flex-shrink-0 w-32 h-32 bg-white rounded-full dark:bg-m3-surface-dark-variant dark:text-m3-surface-dark-on-variant"
                x-data="{ c: Math.PI * 2 * 55, p: ({{ $agency->exo_labelled_vehicles_count / ($agency->exo_labelled_vehicles_count + $agency->exo_unlabelled_vehicles_count) }} * 100) }">
                <svg class="absolute inset-0 w-32 h-32 transform -rotate-90">
                    <circle stroke-width="5" stroke="{{ $agency->color }}33" fill="transparent" r="55" cx="64" cy="64" />
                    <circle stroke-width="5" :stroke-dasharray="c"
                        :stroke-dashoffset="c - p / 100 * c" stroke-linecap="round" stroke="{{ $agency->color }}"
                        fill="transparent" r="55" cx="64" cy="64" />
                </svg>
                <small class="text-xs font-medium uppercase">{{ $agency->slug }}</small>
                <p class="font-medium">{{ $agency->exo_labelled_vehicles_count }}</p>
                <p class="text-xs">{{ __('on') }} {{ $agency->exo_labelled_vehicles_count + $agency->exo_unlabelled_vehicles_count }}</p>
                <a href="{{ route('vin.agency.show', ['agency' => $agency->slug ])}}" class="absolute inset-0 z-10 flex items-center justify-center text-lg font-bold text-center transition-opacity rounded-full opacity-0 hover:opacity-100" style="background-color: {{ $agency->color }}; color: {{ $agency->text_color }};">
                    {{ $agency->short_name }}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="col-span-full">
            <h2 class="mb-2 text-2xl leading-8 text-m3-surface-on dark:text-m3-background-dark-on">{{ __('Latest suggestions') }}</h2>
            <table class="overflow-x-auto whitespace-nowrap bg-white border border-black/[0.12] rounded dark:bg-m3-surface-dark dark:text-m3-surface-dark-on dark:border-m3-background-dark-outline border-collapse block">
                <thead>
                    <tr class="h-14">
                        <th class="px-4 font-medium text-left w-[99%]">VIN</th>
                        <th class="px-4 font-medium text-left">Suggestion</th>
                        <th class="px-4 font-medium text-right">{{ __('Upvotes') }}</th>
                        <th class="px-4 font-medium text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="border-t divide-y divide-black/[0.12] dark:divide-m3-background-dark-outline">
                    @foreach($suggestions as $suggestion)
                    <tr class="h-[3.25rem]">
                        <td class="px-4 text-left">
                            <a href="{{ route('vin.show', ['vin' => $suggestion->vin]) }}" class="flex items-center justify-between gap-x-2">
                                {{ $suggestion->vin }}
                                <div class="inline-flex gap-x-1">
                                    @foreach($suggestion->vehicles as $vehicle)
                                    <span class="inline-block w-4 h-4 rounded-full" style="background-color: {{ $vehicle->agency->color }};" title="{{ $agency->short_name }}"></span>
                                    @endforeach
                                </div>
                            </a>
                        </td>
                        <td class="px-4 text-left">
                            <a href="{{ route('vin.show', ['vin' => $suggestion->vin]) }}">
    
                                {{ $suggestion->label }}
                            </a>
                        </td>
                        <td class="px-4 text-right">
                            <a href="{{ route('vin.show', ['vin' => $suggestion->vin]) }}">
    
                                {{ $suggestion->upvotes }}
                            </a>
                        </td>
                        <td class="px-4 text-left">
                            <a href="{{ route('vin.show', ['vin' => $suggestion->vin]) }}">
                                {{ $suggestion->created_at->diffForHumans() }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-span-full">
            <h2 class="mb-2 text-2xl leading-8 text-m3-surface-on dark:text-m3-background-dark-on">{{ __('Latest vehicles without a fleet number') }}</h2>
            <table class="overflow-x-auto whitespace-nowrap bg-white border border-black/[0.12] rounded dark:bg-m3-surface-dark dark:text-m3-surface-dark-on dark:border-m3-background-dark-outline border-collapse block">
                <thead>
                    <tr class="h-14">
                        <th class="px-4 font-medium text-left">{{ __('Active') }}</th>
                        <th class="px-4 font-medium text-left w-[99%]">VIN</th>
                        <th class="px-4 font-medium text-left">{{ __('Last trip') }}</th>
                        <th class="px-4 font-medium text-left">{{ __('Last seen') }}</th>
                    </tr>
                </thead>
                <tbody class="border-t divide-y divide-black/[0.12] dark:divide-m3-background-dark-outline">
                    @foreach($unlabelledVehicles as $vehicle)
                    <tr class="h-[3.25rem]">
                        <td class="px-4 text-left">
                            <a href="{{ route('vin.show', ['vin' => $vehicle->vehicle]) }}">
                                @if($vehicle->active)
                                    <span class="inline-block w-4 h-4 bg-green-500 border-4 border-green-100 rounded-full dark:border-green-900"></span>
                                @endif
                            </a>
                        </td>
                        <td class="px-4 text-left">
                            <a href="{{ route('vin.show', ['vin' => $vehicle->vehicle]) }}" class="flex items-center justify-between gap-x-2">
                                {{ $vehicle->vehicle }}
                                <span class="inline-block w-4 h-4 rounded-full" style="background-color: {{ $vehicle->agency->color }};" title="{{ $agency->short_name }}"></span>
                            </a>
                        </td>
                        <td class="px-4 text-left">
                            {{ $vehicle->trip->route_short_name }} > {{ $vehicle->trip->trip_headsign }}
                        </td>
                        <td class="px-4 text-left">
                            <a href="{{ route('vin.show', ['vin' => $vehicle->vehicle]) }}">
                                {{ $vehicle->created_at->diffForHumans() }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
