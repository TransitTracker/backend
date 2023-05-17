@extends('layouts.vin')

@section('body')
    <div class="container grid grid-cols-6 px-4 mx-auto mt-8 md:grid-cols-12 gap-y-8 gap-x-12">
        <div class="flex items-center col-span-6 md:col-span-8 md:mb-4">
            <h1 class="text-2xl font-bold md:text-4xl font-heading p-4 rounded-lg"  style="background-color: {{ $tag->color }};color: {{ $tag->text_color }};">{{ $tag->label }}</h1>
        </div>
        <div class="flex items-start col-span-6 md:justify-end md:col-span-4" x-data="{ vin: '' }">
            <form x-bind:action="'/vin/' + vin" class="flex shadow">
                <input x-model="vin" type="text" placeholder="VIN"
                    class="border-transparent rounded-l dark:bg-m3-surface-dark-variant focus:border-transparent focus:outline-none focus:ring-0 dark:text-m3-surface-dark-on-variant"
                    maxlength="17" minlength="17" required>
                <button
                    class="p-2 text-white transition-colors rounded-r bg-primary-500 hover:bg-primary-700 dark:bg-m3-primary-dark-container dark:hover:bg-primary-900"
                    type="submit">
                    <x-gmdi-arrow-forward class="w-6 h-6" />
                </button>
            </form>
        </div>

        @foreach($agencies as $agency => $vehicles)
            <div class="col-span-full" x-data="{ expanded: false }">
                <div class="px-4 py-2 rounded flex items-center justify-between" :class="expanded ? 'rounded-b-none' : ''" style="background-color: {{ json_decode($agency)->color }}; color: {{ json_decode($agency)->text_color }};" @click="expanded =! expanded">
                    <div>
                        <h2 class="font-bold text-lg font-heading">{{ json_decode($agency)->name }}</h2>
                        <p>{{ $vehicles->count() }} {{ __('buses') }}</p>
                    </div>
                    <button class="flex items-center gap-x-1">
                        <span class="hidden md:inline">{{ __('Show all') }}</span>
                        <x-gmdi-keyboard-arrow-down class="w-6 h-6 md:w-4 md:h-4 text-current transition-transform"
                                                    x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                </div>
                <table class="!overflow-x-auto whitespace-nowrap bg-white border border-black/[0.12] rounded-b dark:bg-m3-surface-dark dark:text-m3-surface-dark-on dark:border-m3-background-dark-outline border-collapse block"
                       x-show="expanded" x-collapse>
                    <thead>
                    <tr class="h-14">
                        <th class="px-4 font-medium text-left w-[99%]">VIN</th>
                        <th class="px-4 font-medium text-left">{{ __('Fleet number') }}</th>
                        <th class="px-4 font-medium text-left">{{ __('Manufacturer') }}</th>
                        <th class="px-4 font-medium text-left">{{ __('Last trip') }}</th>
                        <th class="px-4 font-medium text-left">{{ __('Last seen') }}</th>
                    </tr>
                    </thead>
                    <tbody
                            class="border-t divide-y divide-black/[0.12] border-black/[0.12] dark:border-white/[0.12] dark:divide-white/[0.12]">
                    @foreach ($vehicles as $vehicle)
                        <tr class="h-[3.25rem]">
                            <td class="px-4 text-left">
                                <a href="{{ route('vin.show', ['vin' => $vehicle->ref]) }}">
                                    {{ $vehicle->ref }}
                                </a>
                            </td>
                            <td class="px-4 text-left">
                                <a href="{{ route('vin.show', ['vin' => $vehicle->ref]) }}">
                                    @if ($vehicle->force_label)
                                        {{ $vehicle->force_label }}
                                    @else
                                        <span
                                                class="inline-flex items-center text-sm italic text-gray-500 dark:bg-m3-surface-dark-variant dark:text-m3-surface-dark-on-variant gap-x-1 bg-gray-100 px-1.5 py-0.5 rounded-full">
                                        {{ __('Contribute') }}
                                        <x-gmdi-edit-note class="w-4 h-4" />
                                    </span>
                                    @endif
                                </a>
                            </td>
                            <td class="px-4 text-left">
                                {{ $vehicle->vinInformation->make }}
                            </td>
                            <td class="px-4 text-left">
                                <a href="{{ route('vin.show', ['vin' => $vehicle->ref]) }}">
                                    {{ $vehicle->gtfsRoute?->short_name }} > {{ $vehicle->trip?->headsign }}
                                </a>
                            </td>
                            <td class="px-4 text-left">
                                <a href="{{ route('vin.show', ['vin' => $vehicle->ref]) }}">
                                    {{ $vehicle->updated_at->diffForHumans() }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @endforeach
    </div>
@endsection
