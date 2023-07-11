<x-layout>
    <div class="container grid grid-cols-6 px-4 mx-auto mt-8 md:grid-cols-12 gap-y-8 gap-x-12">
        <div class="flex items-center col-span-full gap-x-2">
            <span class="w-8 h-8 rounded-full" style="background-color: {{ $agency->color }};"></span>
            <h1 class="text-2xl font-bold md:text-4xl text-primary-700 dark:text-white font-heading">{{ $agency->name }}</h1>
        </div>

        <table class="overflow-x-auto whitespace-nowrap border rounded bg-neutral-96 dark:bg-neutral-10 border-neutralVariant-50 text-neutral-10 dark:text-neutral-90 dark:border-neutralVariant-60 border-collapse block col-span-full">
            <thead>
                <tr class="h-14">
                    <th class="px-4 font-medium text-left w-[99%]">VIN</th>
                    <th class="px-4 font-medium text-left">{{ __('Fleet number') }}</th>
                    <th class="px-4 font-medium text-left">{{ __('Manufacturer') }}</th>
                    <th class="px-4 font-medium text-left">{{ __('Operator') }}</th>
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
                            <span class="inline-flex items-center text-sm italic bg-neutral-90 dark:bg-neutral-24 gap-x-1 px-1.5 py-0.5 rounded-full">
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
                        @foreach ($vehicle->tags as $tag)
                        <a href="{{ route('vin.operator.show', ['tagSlug' => $tag->slug]) }}">
                            {{ $tag->label }}
                        </a>
                        @endforeach
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
</x-layout>