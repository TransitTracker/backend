@extends('layouts.app')

@section('body')
    <div class="container mx-auto px-4 mt-8">
        <h1 class="text-4xl text-primary-700 font-bold">Request an API key</h1>

        <p class="text-lg mt-2 mb-8">Requesting an API key is free, quick and, easy. You will instantly get your key after this form.</p>

        <div class="relative my-4">
            <input type="text" id="name" placeholder="Name" class="peer placeholder-transparent bg-transparent border-0 border-b-2 focus:ring-0 border-black border-opacity-40 h-8 focus:border-primary-500 focus:border-opacity-100 transition-colors px-0 w-48" />
            <label for="name" class="absolute top-1/2 -translate-y-8 left-0 opacity-60 text-xs peer-focus:-translate-y-8 peer-focus:text-xs peer-focus:text-primary-500 peer-focus:opacity-100 transition-transform peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-base">Name</label>
        </div>

        <div class="relative my-4">
            <input type="text" id="email" placeholder="Email" class="peer placeholder-transparent bg-transparent border-0 border-b-2 focus:ring-0 border-black border-opacity-40 h-8 focus:border-primary-500 focus:border-opacity-100 transition-colors px-0 w-48" />
            <label for="email" class="absolute top-1/2 -translate-y-8 left-0 opacity-60 text-xs peer-focus:-translate-y-8 peer-focus:text-xs peer-focus:text-primary-500 peer-focus:opacity-100 transition-transform peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-base">Email</label>
        </div>

        <div class="relative mt-8 mb-4 w-40">
            <input type="text" id="usage" placeholder="Usage" class="peer placeholder-transparent bg-transparent border-0 border-b-2 focus:ring-0 border-black border-opacity-40 h-8 focus:border-primary-500 focus:border-opacity-100 transition-colors px-0 w-96"/>
            <label for="usage" class="absolute top-1/2 -translate-y-8 left-0 opacity-60 text-xs peer-focus:-translate-y-8 peer-focus:text-xs peer-focus:text-primary-500 peer-focus:opacity-100 transition-transform peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-base">Usage</label>
        </div>

    </div>
@endsection
