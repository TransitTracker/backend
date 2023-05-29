@extends('layouts.vin')

@section('body')
    <div class="container grid grid-cols-6 px-4 mx-auto mt-8 md:grid-cols-12 gap-y-8 gap-x-12" x-data="{ sector: 0 }">
        <svg viewBox="0 0 800 619" class="col-span-6 max-w-6xl">
            @foreach($agencies as $agency)
                <a
                    href="{{ route('vin.agency.show', ['sector' => $agency->name_slug]) }}"
                    class="transition-opacity"
                    @mouseover="sector = {{ $agency->id }}"
                    @mouseleave="sector = 0"
                    :class="{'opacity-50': sector === {{ $agency->id }}}"
                >
                    <path fill="{{ $agency->color }}" stroke="{{ $agency->color }}" d="{{ $agency->area_path }}" />
                </a>
            @endforeach
        </svg>

        <ul class="col-span-6 space-y-2">
            @foreach($agencies as $agency)
                <li class="flex items-center gap-x-2 justify-between" @mouseover="sector = {{ $agency->id }}">
                    <div class="flex items-center gap-x-2 -mx-2 -my-1 md:-my-2 px-2 py-1 md:py-2 rounded" :class="{'bg-white dark:bg-neutral-22': sector === {{ $agency->id }}}">
                        <span class="w-6 h-6 rounded-full" style="background-color: {{ $agency->color }};"></span>
                        <div>
                            <a href="{{ route('vin.agency.show', ['sector' => $agency->name_slug]) }}" class="text-1xl font-bold md:text-2xl text-primary-700 dark:text-white font-heading">{{ $agency->short_name }}</a>
                            <small class="md:hidden">{{ __(':total buses', ['total' => $agency->exo_with_vin_count]) }}</small>
                        </div>
                    </div>
                    <x-button.filled class="md:!inline-flex mt-2 !hidden" href="{{ route('vin.agency.show', ['sector' => $agency->name_slug]) }}" :has-left-icon="false" :has-right-icon="true">
                        {{ __(':total buses', ['total' => $agency->exo_with_vin_count]) }} <x-gmdi-keyboard-arrow-right class="w-4 h-4" />
                    </x-button.filled>
                </li>
            @endforeach
        </ul>

        <div class="col-span-full">
            <h2 class="mb-2 text-2xl leading-8 font-heading">{{ __('Operators') }}</h2>
            <ul class="flex flex-wrap gap-2 col-span-full">
                @foreach($operators as $operator)
                    <li>
                        <a class="rounded px-2 py-1 cursor-pointer flex flex-col" style="background-color: {{ $operator->color }};color: {{ $operator->text_color }}" href="{{ route('vin.operator.show', ['tagSlug' => $operator->slug]) }}">
                            <p>{{ $operator->label }}</p>
                            <small class="text-xs">{{ $operator->exo_vin_vehicles_count }} {{ __('buses') }}</small>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-span-full md:col-span-6">
            <h2 class="mb-2 text-2xl leading-8 font-heading">
                {{ __('Latest suggestions') }}</h2>
            <table
                class="overflow-x-auto whitespace-nowrap border rounded bg-neutral-96 dark:bg-neutral-10 border-neutralVariant-50 text-neutral-10 dark:text-neutral-90 dark:border-neutralVariant-60  border-collapse block">
                <thead>
                    <tr class="h-14">
                        <th class="px-4 font-medium text-left w-[99%]">VIN</th>
                        <th class="px-4 font-medium text-left">Suggestion</th>
                        <th class="px-4 font-medium text-right">{{ __('Upvotes') }}</th>
                        <th class="px-4 font-medium text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="border-t divide-y divide-neutralVariant-50 dark:divide-neutralVariant-60">
                    @foreach ($suggestions as $suggestion)
                        <tr class="h-[3.25rem]">
                            <td class="px-4 text-left">
                                <a href="{{ route('vin.show', ['vin' => $suggestion->vin]) }}"
                                    class="flex items-center justify-between gap-x-2">
                                    {{ $suggestion->vin }}
                                    <div class="inline-flex gap-x-1">
                                        @foreach ($suggestion->vehicles as $vehicle)
                                            <span class="inline-block w-4 h-4 rounded-full"
                                                style="background-color: {{ $vehicle->agency->color }};"
                                                title="{{ $vehicle->agency->short_name }}"></span>
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

        <div class="col-span-full md:col-span-6">
            <h2 class="mb-2 text-2xl leading-8 font-heading">
                {{ __('Latest vehicles without a fleet number') }}</h2>
            <table
                class="overflow-x-auto whitespace-nowrap border rounded bg-neutral-96 dark:bg-neutral-10 border-neutralVariant-50 text-neutral-10 dark:text-neutral-90 dark:border-neutralVariant-60 border-collapse block">
                <thead>
                    <tr class="h-14">
                        <th class="px-4 font-medium text-left">{{ __('Active') }}</th>
                        <th class="px-4 font-medium text-left w-[99%]">VIN</th>
                        <th class="px-4 font-medium text-left">{{ __('Last trip') }}</th>
                        <th class="px-4 font-medium text-left">{{ __('Last seen') }}</th>
                    </tr>
                </thead>
                <tbody class="border-t divide-y divide-neutralVariant-50 dark:divide-neutralVariant-60">
                    @foreach ($unlabelledVehicles as $vehicle)
                        <tr class="h-[3.25rem]">
                            <td class="px-4 text-left">
                                <a href="{{ route('vin.show', ['vin' => $vehicle->ref]) }}">
                                    @if ($vehicle->one_is_active)
                                        <span
                                            class="inline-block w-4 h-4 bg-green-500 border-4 border-green-100 rounded-full dark:border-green-900"></span>
                                    @endif
                                </a>
                            </td>
                            <td class="px-4 text-left">
                                <a href="{{ route('vin.show', ['vin' => $vehicle->ref]) }}"
                                    class="flex items-center justify-between gap-x-2">
                                    {{ $vehicle->ref }}
                                    <div class="flex gap-x-1">
                                        @foreach ($vehicle->relatedVehicles as $related)
                                            <span class="inline-block w-4 h-4 rounded-full"
                                                style="background-color: {{ $related->agency->color }};"
                                                title="{{ $related->agency->short_name }}"></span>
                                        @endforeach
                                    </div>
                                </a>
                            </td>
                            <td class="px-4 text-left">
                                {{ $vehicle->lastVehicle->gtfsRoute?->short_name }} > {{ $vehicle->lastVehicle->trip?->headsign }}
                            </td>
                            <td class="px-4 text-left">
                                <a href="{{ route('vin.show', ['vin' => $vehicle->ref]) }}">
                                    {{ $vehicle->lastVehicle->updated_at?->diffForHumans() }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-span-full">
            <h2 class="mb-2 text-2xl leading-8 font-heading">{{ __('About this project') }}</h2>
            <p class="prose md:prose-lg text-white">{{ __("Depuis quelques années, les données en temps réel des secteurs d'autobus d'exo identifient leurs bus à l'aide des VIN (identifiant unique du manufacturier). Ce projet vise à identifier tous les bus d'exo avec leur numéro de flotte. Il est permet également d'observer les mouvements de véhicules à travers différents secteurs, de les regrouper par opérateurs ainsi que d'obtenir les informations techniques sur chaque bus, extraits à partir du numéro VIN.") }}</p>
        </div>
    </div>
@endsection
