<x-filament::layouts.base :title="$title">
    <div class="filament-app-layout flex h-full w-full overflow-x-clip">
        <div
                x-data="{}"
                x-cloak
                x-show="$store.sidebar.isOpen"
                x-transition.opacity.500ms
                x-on:click="$store.sidebar.close()"
                class="filament-sidebar-close-overlay fixed inset-0 z-20 w-full h-full bg-gray-900/50 lg:hidden"
        ></div>

        <x-filament::layouts.app.sidebar />

        <div
                @if (config('filament.layout.sidebar.is_collapsible_on_desktop'))
                    x-data="{}"
                x-bind:class="{
                    'lg:pl-[var(--collapsed-sidebar-width)] rtl:lg:pr-[var(--collapsed-sidebar-width)]': ! $store.sidebar.isOpen,
                    'filament-main-sidebar-open lg:pl-[var(--sidebar-width)] rtl:lg:pr-[var(--sidebar-width)]': $store.sidebar.isOpen,
                }"
                x-bind:style="'display: flex'" {{-- Mimics `x-cloak`, as using `x-cloak` causes visual issues with chart widgets --}}
                @endif
                @class([
                    'filament-main flex-col w-screen flex-1 rtl:lg:pl-0 h-screen',
                    'hidden transition-all' => config('filament.layout.sidebar.is_collapsible_on_desktop'),
                    'flex lg:pl-[var(--sidebar-width)] rtl:lg:pr-[var(--sidebar-width)]' => ! config('filament.layout.sidebar.is_collapsible_on_desktop'),
                ])
        >
            <x-filament::topbar :breadcrumbs="$breadcrumbs" />

            <div class="filament-main-content w-full" style="height: calc(100vh - 4rem)">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-filament::layouts.base>