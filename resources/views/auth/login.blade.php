@extends('layouts.app')

@section('body')
<div class="font-sans text-gray-900 antialiased">
    <div class="min-h-[calc(100vh-164px)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-sm overflow-hidden sm:rounded-lg">
            <!-- Auth session status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Auth validation errors -->
            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        Whoops! Something went wrong.
                    </div>

                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="relative mt-4 mb-8">
                    <input type="email" id="email" placeholder="Email" required name="email"
                        class="peer placeholder-transparent bg-transparent border-0 border-b-2 focus:ring-0 border-black border-opacity-40 h-8 focus:border-primary-500 focus:border-opacity-100 transition-colors px-0 w-full" />
                    <label for="email"
                        class="absolute top-1/2 -translate-y-8 left-0 opacity-60 text-xs peer-focus:-translate-y-8 peer-focus:text-xs peer-focus:text-primary-500 peer-focus:opacity-100 transition-transform peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-base">Email</label>
                </div>

                <!-- Password -->
                <div class="relative mb-8">
                    <input type="password" id="password" placeholder="Password" required name="password"
                        class="peer placeholder-transparent bg-transparent border-0 border-b-2 focus:ring-0 border-black border-opacity-40 h-8 focus:border-primary-500 focus:border-opacity-100 transition-colors px-0 w-full" />
                    <label for="password"
                        class="absolute top-1/2 -translate-y-8 left-0 opacity-60 text-xs peer-focus:-translate-y-8 peer-focus:text-xs peer-focus:text-primary-500 peer-focus:opacity-100 transition-transform peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-base">Password</label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="rounded inline-flex items-center text-white font-medium shadow bg-primary-500 hover:bg-opacity-80 px-4 py-2 text-sm tracking-wider uppercase justify-self-start self-end">
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection