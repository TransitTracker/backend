@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_start')
<div class="card">
    <div class="card-body d-flex align-items-center p-0">
        @if (isset($widget['icon']))
            <i class="fa p-3 font-2xl mr-1 {{ $widget['icon'] }} bg-{{ $widget['color'] ?? 'primary' }}"></i>
        @endif

        <div class="px-2">
            @if (isset($widget['value']))
                <div class="text-value-sm text-{{ $widget['text-color'] ?? $widget['color'] }}">{!! $widget['value'] !!}</div>
            @endif
            @if (isset($widget['description']))
                <div class="text-muted text-uppercase font-weight-bold small">{!! $widget['description'] !!}</div>
            @endif
        </div>
    </div>

    @if (isset($widget['link']))
        <div class="card-footer px-3 py-2">
            <a href="{!! $widget['link'] !!}"
               class="btn-block text-muted d-flex justify-content-between align-items-center">
                <span class="small font-weight-bold">
                    {{ $widget['link-text'] ?? 'View More' }}
                </span>
                <i class="{{ $widget['link-icon'] ?? 'la la-arrow-right' }}"></i>
            </a>
        </div>
    @endif
</div>
@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_end')