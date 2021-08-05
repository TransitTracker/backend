@extends('layouts.vin')

@section('body')
    <div class="container grid grid-cols-12 px-4 mx-auto mt-8 gap-y-8 gap-x-12">
        <h1 class="col-span-8 text-2xl font-bold md:mb-4 md:text-4xl text-primary-700 dark:text-white">{{ __('exo VIN Database') }}</h1>
        <div class="flex items-start justify-end col-span-4" x-data="{vin: ''}">
            <form x-bind:action="'/vin/'+vin" class="flex shadow">
                <input x-model="vin" type="text" placeholder="VIN" class="border-transparent rounded-l dark:bg-grey focus:border-transparent focus:outline-none focus:ring-0" maxlength="17" minlength="17" required>
                <button class="p-2 text-white transition-colors rounded-r bg-primary-500 hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-900" type="submit">
                    <x-gmdi-arrow-forward class="w-6 h-6" />
                </button>
            </form>
        </div>
        
        <div class="col-span-full">
            <small class="text-xs font-medium tracking-widest uppercase dark:text-white">{{ __('Recent suggestions') }}</small>
            <ul class="mt-1 bg-white shadow dark:bg-grey dark:text-white">
                @foreach($suggestions as $suggestion)
                <li>
                    <a href="{{ route('vin.show', ['vin' => $suggestion->vin]) }}" class="block px-4 py-3">
                        <p class="flex items-center mb-2 leading-tight gap-x-2">
                            {{-- <span class="w-4 h-4 border-4 rounded-full inline if($vehicle->active) bg-green-500 border-green-100 else bg-red-500 border-red-100 endif"></span> --}}
                            {{ $suggestion->label }}
                        </p>
                        <small class="text-sm leading-tight">{{ $suggestion->vin }}</small>
                    </a>
                </li>
                @endforeach
            </ul>
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
