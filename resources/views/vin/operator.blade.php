<x-layout>
    <div class="container grid grid-cols-6 px-4 mx-auto mt-8 md:grid-cols-12 gap-y-8 gap-x-12 relative">
        <div class="flex items-center col-span-full md:mb-4" id="heading">
            <h1 class="text-2xl font-bold md:text-4xl font-heading p-4 rounded-lg" style="background-color: {{ $tag->color }};color: {{ $tag->text_color }};">{{ $tag->label }}</h1>
        </div>

        <a href="#top" class="bottom-4 right-4 h-10 w-10 flex items-center justify-center bg-primary-90 dark:bg-primary-30 fixed z-20 rounded-xl shadow-3">
            <x-gmdi-arrow-upward class="w-6 h-6 text-primary-10 dark:text-primary-90 z-10" />
        </a>

        @foreach($agencies as $agency => $vehicles)
        <div class="col-span-full relative" x-data="{ expanded: false }">
            <div class="px-4 py-2 rounded flex items-center justify-between sticky top-16" :class="expanded ? 'rounded-b-none' : ''" style="background-color: {{ json_decode($agency)->color }}; color: {{ json_decode($agency)->text_color }};" @click="expanded =! expanded">
                <div>
                    <h2 class="font-bold text-lg font-heading">{{ json_decode($agency)->name }}</h2>
                    <p>{{ $vehicles->count() }} {{ __('buses') }}</p>
                </div>
                <button class="flex items-center gap-x-1">
                    <span class="hidden md:inline">{{ __('Show all') }}</span>
                    <x-gmdi-keyboard-arrow-down class="w-6 h-6 md:w-4 md:h-4 text-current transition-transform" x-bind:class="expanded ? 'rotate-180' : ''" />
                </button>
            </div>
            <table class="!overflow-x-auto whitespace-nowrap border rounded-b bg-neutral-96 dark:bg-neutral-10 border-neutralVariant-50 text-neutral-10 dark:text-neutral-90 dark:border-neutralVariant-60 border-collapse block border-t-0" x-show="expanded" x-collapse>
                <thead>
                    <tr class="h-14">
                        <th class="px-4 font-medium text-left w-[99%]">VIN</th>
                        <th class="px-4 font-medium text-left">{{ __('Fleet number') }}</th>
                        <th class="px-4 font-medium text-left">{{ __('Manufacturer') }}</th>
                        <th class="px-4 font-medium text-left">{{ __('Last trip') }}</th>
                        <th class="px-4 font-medium text-left">{{ __('Last seen') }}</th>
                    </tr>
                </thead>
                <tbody class="border-t divide-y divide-black/[0.12] border-black/[0.12] dark:border-white/[0.12] dark:divide-white/[0.12]">
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
                                <span class="inline-flex items-center text-sm italic text-gray-500 dark:bg-neutralVariant-30 dark:text-neutralVariant-80 gap-x-1 bg-gray-100 px-1.5 py-0.5 rounded-full">
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
                                {{ now()->parse($vehicle->timestamp)->diffForHumans() }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endforeach
    </div>
</x-layout>