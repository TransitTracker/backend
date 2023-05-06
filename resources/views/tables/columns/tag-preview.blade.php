<div style="background-color: {{ $getRecord()->color }}; color: {{ $getRecord()->text_color }}; padding: 0.25rem 0.5rem;border-radius: 0.25rem;display: flex;column-gap: 0.25rem;align-items: center;" id="tags-preview-{{ $getRecord()->id }}">
    @if($getRecord()->icon)
        <svg style="width: 1rem; height: 1rem;" viewBox="0 0 24 24">
            <path d="{{ $getRecord()->icon }}" fill="currentColor" />
        </svg>
    @endif
    {{ $getRecord()->label }}
</div>

<style>
    .dark #tags-preview-{{ $getRecord()->id }} {
        background-color: {{ $getRecord()->dark_color }} !important;
        color: {{ $getRecord()->dark_text_color }} !important;
    }
</style>
