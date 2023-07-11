<x-layout>
    <div class="md:mt-8 mt-4 container px-4 mx-auto ">
            <div class="flex md:items-center gap-4 p-4 text-white bg-error-40 dark:bg-error-80 dark:text-error-20 rounded max-w-4xl">
                <x-gmdi-error class="w-6 h-6 flex-shrink-0" />
                <p>
                    {{ __('This VIN does not exist in the database.') }}
                    <a href="{{ route('vin.index') }}" class="underline">{{ __('Return to home page') }}</a>.
                </p>
            </div>

    </div>
</x-layout>
