@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_start')
<div class="card">
    <div class="card-body d-flex align-items-center p-0">
        @if (isset($widget['icon']))
            <div class="icon p-3 mr-1 bg-{{ $widget['color'] ?? 'primary' }} h-100 d-flex align-items-center justify-center">
                <i class="font-2xl {{ $widget['icon'] }}"></i>
            </div>

        @endif

        <div class="p-2 w-100">
            @if (isset($widget['progress']))
                @if (isset($widget['total']))
                    <div class="text-value-sm text-{{ $widget['text-color'] ?? $widget['color'] }}">
                        <b class="text-{{ $widget['color'] }}">{{ $widget['progress'] }}</b>/{{ $widget['total'] }}</div>
                @endif
                <div class="progress progress-{{ $widget['color'] }} progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $widget['total'] ? ($widget['progress']/$widget['total'])*100 : 0 }}%"
                         aria-valuenow="{{ $widget['progress']  }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            @elseif(isset($widget['total']))
                <div class="text-value-sm text-{{ $widget['text-color'] ?? $widget['color'] }}">{!! $widget['total'] !!}</div>
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
<style>
    .card {
        height: calc(100% - 1.5rem);
    }
</style>
@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_end')