@extends('layouts.vin')

@section('body')
    <div class="container grid grid-cols-6 px-4 mx-auto mt-8 md:grid-cols-12 gap-y-8 gap-x-12">
        <h1 class="col-span-6 text-2xl font-bold md:col-span-8 md:mb-4 md:text-4xl text-primary-700 dark:text-white">{{ __('exo VIN Database') }}</h1>
        <div class="flex items-start col-span-6 md:justify-end md:col-span-4" x-data="{vin: ''}">
            <form x-bind:action="'/vin/'+vin" class="flex shadow">
                <input x-model="vin" type="text" placeholder="VIN" class="border-transparent rounded-l dark:bg-grey focus:border-transparent focus:outline-none focus:ring-0 dark:text-white" maxlength="17" minlength="17" required>
                <button class="p-2 text-white transition-colors rounded-r bg-primary-500 hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-900" type="submit">
                    <x-gmdi-arrow-forward class="w-6 h-6" />
                </button>
            </form>
        </div>
        
        <div class="col-span-full">
            <small class="text-xs font-medium tracking-widest uppercase dark:text-white">{{ __('Latest suggestions') }}</small>
            <table class="overflow-x-auto whitespace-nowrap bg-white border border-black/[0.12] rounded dark:bg-grey dark:text-white dark:border-white/[0.12] border-collapse block">
                <thead>
                    <tr class="font-medium h-14">
                        <th class="px-4 text-left">VIN</th>
                        <th class="px-4 text-left">Suggestion</th>
                        <th class="px-4 text-right">Upvotes</th>
                        <th class="px-4 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="border-t divide-y divide-black/[0.12] border-black/[0.12] dark:border-white/[0.12] dark:divide-white/[0.12]">
                    @foreach($suggestions as $suggestion)
                    <tr class="h-[3.25rem]">
                        <td class="px-4 text-left">
                            <a href="{{ route('vin.show', ['vin' => $suggestion->vin]) }}" class="flex items-center gap-x-2">
                                {{ $suggestion->vin }}
                                <div class="inline-flex gap-x-1">
                                    @foreach($suggestion->vehicles as $vehicle)
                                    <span class="inline-block w-4 h-4 rounded-full" style="background-color: {{ $vehicle->agency->color }};"></span>
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
            <small class="text-xs font-medium tracking-widest uppercase dark:text-white">{{ __('Unlabelled Vehicles') }}</small>
            <ul class="mt-1 bg-white shadow dark:bg-grey dark:text-white">
                @foreach($unlabelledVehicles as $vehicle)
                <li>
                    <a href="{{ route('vin.show', ['vin' => $vehicle->vehicle]) }}" class="block px-4 py-3">
                        <p class="flex items-center mb-2 leading-tight gap-x-2">
                            <span class="w-4 h-4 border-4 rounded-full inline @if($vehicle->active) bg-green-500 border-green-100 dark:border-green-900 @else bg-red-500 border-red-100 dark:border-red-900 @endif"></span>
                            {{ $vehicle->vehicle }}
                        </p>
                        <small class="text-sm leading-tight">{{ $vehicle->agency->name }} on route {{ $vehicle->trip->route_short_name }}</small>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
