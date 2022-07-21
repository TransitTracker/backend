<div {{ $attributes }} tabindex="-1" x-bind:aria-hidden="!{{ $showProp }}">
    <div class="absolute top-0 left-0 h-full w-full flex items-center justify-center pointer-events-none">
        <div class="absolute inset-0 z-40 bg-black/75" x-show="{{ $showProp }}" x-transition.opacity.duration.300ms></div>
        <div class="bg-m3-surface dark:bg-m3-surface-dark p-6 rounded-[1.75rem] text-m3-surface-on-variant dark:text-m3-surface-dark-on-variant min-w-[17.5rem] max-w-[35rem] z-50 pointer-events-auto"
            x-show="{{ $showProp }}" @click.outside="{{ $showProp }} = false" x-transition.scale.80.duration.300ms.opacity>
            <h2 class="text-2xl leading-8 text-m3-surface-on dark:text-m3-surface-dark-on">{{ $title }}</h2>
            <p class="mt-4 leading-5 text-sm">{{ $slot }}</p>
            @if ($body ?? null)
                <hr class="my-3 border-t border-m3-surface-variant dark:border-m3-surface-dark-variant">
                <p class="mt-4 leading-5 text-sm">{{ $body }}</p>
            @endif
            @if ($actions ?? null)
                <hr class="my-3 border-t border-m3-surface-variant dark:border-m3-surface-dark-variant">
                {{ $actions }}
            @endif
        </div>
    </div>
</div>
