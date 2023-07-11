<x-layout>
    <div class="container grid grid-cols-6 px-4 mx-auto mt-8 md:grid-cols-12 gap-y-8 gap-x-12" x-data="{ sector: 0 }">
        <div class="col-span-full">
            <h1 class="text-xl font-bold">{{ __('Welcome to the VIN Database, for exo bus sectors!') }}</h1>
            <p>{{ __("Thanks to community effort, exo buses are now identified by fleet numbers in Transit Tracker. Explore exo's directory of buses across their sectors right here.") }}
                <a href="#about" class="underline">{{ __('Learn more') }}</a>
            </p>
        </div>
        <svg viewBox="0 0 800 619" class="col-span-6 max-w-6xl">
            @foreach ($agencies as $agency)
                <a href="{{ route('vin.agency.show', ['sector' => $agency->name_slug]) }}" class="transition-opacity"
                    @mouseover="sector = {{ $agency->id }}" @mouseleave="sector = 0"
                    :class="{ 'opacity-50': sector === {{ $agency->id }} }">
                    <path fill="{{ $agency->color }}" stroke="{{ $agency->color }}" d="{{ $agency->area_path }}" />
                </a>
            @endforeach
        </svg>

        <ul class="col-span-6 space-y-2 block">
            @foreach ($agencies as $agency)
                <li @mouseover="sector = {{ $agency->id }}">
                    <a href="{{ route('vin.agency.show', ['sector' => $agency->name_slug]) }}"
                        class="flex items-center gap-x-2 -mx-2 -my-1 md:-my-2 px-2 py-1 md:py-2 rounded"
                        :class="{ 'bg-white dark:bg-neutral-22': sector === {{ $agency->id }} }">
                        <span class="w-6 h-6 rounded-full flex-shrink-0"
                            style="background-color: {{ $agency->color }};"></span>
                        <div>
                            <p class="text-1xl font-bold xl:text-2xl text-primary-700 dark:text-white font-heading">
                                {{ $agency->short_name }}</p>
                            <p class="md:inline">{{ $agency->exo_with_vin_count }} {{ __('buses') }}</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="col-span-full">
            <h2 class="mb-2 text-2xl leading-8 font-heading">{{ __('Operators') }}</h2>
            <ul class="flex flex-wrap gap-2 col-span-full">
                @foreach ($operators as $operator)
                    <li>
                        <a class="rounded px-2 py-1 cursor-pointer flex flex-col"
                            style="background-color: {{ $operator->color }};color: {{ $operator->text_color }}"
                            href="{{ route('vin.operator.show', ['tagSlug' => $operator->slug]) }}">
                            <p>{{ $operator->label }}</p>
                            <small class="text-xs">{{ $operator->exo_vin_vehicles_count }} {{ __('buses') }}</small>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-span-full md:col-span-6">
            <h2 class="mb-2 text-2xl leading-8 font-heading">
                {{ __('Latest suggestions') }}
            </h2>
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
                {{ __('Latest vehicles without a fleet number') }}
            </h2>
            @if (count($unlabelledVehicles))
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
                                    {{ $vehicle->lastVehicle->gtfsRoute?->short_name }} >
                                    {{ $vehicle->lastVehicle->trip?->headsign }}
                                </td>
                                <td class="px-4 text-left">
                                    <a href="{{ route('vin.show', ['vin' => $vehicle->ref]) }}">
                                        {{ now()->parse($vehicle->lastVehicle->timestamp ?? 0)->diffForHumans() }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex items-center justify-center flex-col gap-2 mt-8">
                    <x-gmdi-check-r class="w-14 h-14" />
                    <p class="text-xl">{{ __('All vehicles have a fleet number!') }}</p>
                </div>
            @endif
        </div>
        <div class="col-span-full">
            <h2 class="mb-2 text-2xl leading-8 font-heading" id="about">{{ __('About this project') }}</h2>
            <p class="prose text-neutral-10 dark:text-white">
                {{ __('For the past few years, exo bus sectors real-time data has been identifying their buses using VINs (unique manufacturer identifier). This project aims to identify all exo buses with their fleet number. It also allows to observe the movements of vehicles through different sectors, to group them by operators as well as to obtain technical information on each bus, extracted from the VIN number.') }}
                <br>
                {{ __("This project would not be possible without MTL66's contribution to bus identification and suggestion management. Thank you!") }}
            </p>
        </div>
    </div>
</x-layout>
