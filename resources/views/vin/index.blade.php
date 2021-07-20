@extends('layouts.vin')

@section('body')
    <div class="container grid grid-cols-1 px-4 mx-auto mt-8 md:grid-cols-3 gap-y-8 gap-x-12">
        <h1 class="text-2xl font-bold md:mb-4 md:text-4xl text-primary-700 col-span-full">exo VIN Database</h1>
        
        {{-- <div class="col-span-full">
            <div class="relative flex items-center h-12 px-4 mt-1 text-sm text-white bg-primary-700">
                <div class="absolute inset-y-0 left-0 flex items-center px-4 text-sm bg-secondary-700" style="width: {{ 70 }}%;">
                    {{ $totalVehicles - $unlabelledVehicles->count() }} labelled bus
                </div>
                <div class="flex-grow"></div>
                {{ $unlabelledVehicles->count() }} unlabelled bus
            </div>
            <small class="text-xs font-medium tracking-widest uppercase">{{ $totalVehicles - $unlabelledVehicles->count() }} out of {{ $totalVehicles }} ({{ $labelledPercentage }}%)</small>
        </div> --}}
        
        <div class="col-span-full">
            <small class="text-xs font-medium tracking-widest uppercase">Recent suggestions</small>
            <ul class="mt-1 bg-white shadow">
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
            <small class="text-xs font-medium tracking-widest uppercase">Unlabelled Vehicles</small>
            <ul class="mt-1 bg-white shadow">
                @foreach($unlabelledVehicles as $vehicle)
                <li>
                    <a href="{{ route('vin.show', ['vin' => $vehicle->vehicle]) }}" class="block px-4 py-3">
                        <p class="flex items-center mb-2 leading-tight gap-x-2">
                            <span class="w-4 h-4 border-4 rounded-full inline @if($vehicle->active) bg-green-500 border-green-100 @else bg-red-500 border-red-100 @endif"></span>
                            {{ $vehicle->vehicle }}
                        </p>
                        {{-- <small class="text-sm leading-tight">{{ $vehicle->agency->name }} on route {{ $vehicle->trip->route_short_name }}</small> --}}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
