<x-filament-panels::page>
    <form wire:submit.prevent="fetchData">
        {{ $this->form }}
    </form>
    {{ $this->table }}
</x-filament-panels::page>
