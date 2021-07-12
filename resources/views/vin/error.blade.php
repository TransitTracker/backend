@extends('layouts.vin')

@section('body')
    <div class="container px-4 mx-auto mt-4">
        <div class="flex flex-wrap items-center gap-4 p-4 text-white bg-red-600 rounded">
            <x-gmdi-error class="w-6 h-6" />
            <p>This VIN doesnt't exist in the database. You can still submit a suggestion for a future VIN.</p>
            <div class="flex-grow"></div>
            <a href="https://docs.google.com/forms/d/e/1FAIpQLSfArnGVDN8u1UeYzuV22VzXEbwJR9MtDF_G_MlGuHv34DeR7w/viewform?entry.1145724711={{ $vin }}" class="rounded border border-white font-medium text-sm tracking-widest uppercase flex items-center h-9 px-4 min-w-[64px]">Submit suggestion</a>
        </div>
    </div>
@endsection
