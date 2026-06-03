<x-layout>
    <div class="container px-4 mx-auto mt-8 max-w-2xl">
        <h1 class="text-2xl font-bold md:text-4xl text-primary-700 dark:text-white font-heading mb-4">{{ __('Submit a Region Image') }}</h1>
        <p class="mb-6">{{ __('Help us feature the best images for each region! Submitted images will be reviewed before they become the active header image.') }}</p>

        @if (session('status'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vin.region-image.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="region_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Region') }}</label>
                <select id="region_id" name="region_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md dark:bg-neutral-90 dark:border-neutral-70 dark:text-white">
                    <option value="" disabled selected>{{ __('Select a region') }}</option>
                    @foreach ($regions as $id => $name)
                        <option value="{{ $id }}" {{ old('region_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Image (JPEG, PNG, WEBP)') }}</label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('Image will be converted to 16:9 ratio and WebP format.') }}</p>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:text-gray-400 dark:file:bg-neutral-80 dark:file:text-white">
            </div>

            <div>
                <label for="author_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Author Name') }}</label>
                <input type="text" name="author_name" id="author_name" required value="{{ old('author_name') }}" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-neutral-90 dark:border-neutral-70 dark:text-white py-2 px-3">
            </div>

            <div>
                <label for="author_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Author Link (Optional)') }}</label>
                <input type="url" name="author_link" id="author_link" value="{{ old('author_link') }}" placeholder="https://" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-neutral-90 dark:border-neutral-70 dark:text-white py-2 px-3">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Description') }}</label>
                <textarea id="description" name="description" rows="3" required class="mt-1 shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border border-gray-300 rounded-md dark:bg-neutral-90 dark:border-neutral-70 dark:text-white py-2 px-3">{{ old('description') }}</textarea>
            </div>

            <div>
                <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
            </div>

            <div>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
    </div>
</x-layout>
