@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type' => 'div',
        'class' => 'd-flex align-items-stretch flex-wrap',
        'content' => [
            [
                'type' => 'stats',
                'wrapper' => ['class' => 'col-md-6 col-sm-4'],
                'color' => 'secondary',
                'text-color' => 'dark',
                'icon' => 'la la-microchip',
                'total' => strval(app(\Laravel\Horizon\Contracts\MetricsRepository::class)->jobsProcessedPerMinute()),
                'description' => 'Jobs per minute',
                'link' => route('horizon.index'),
                'link-text' => 'Launch Horizon',
                'link-icon' => 'la la-external-link-alt'
            ],
            [
                'type' => 'stats',
                'wrapper' => ['class' => 'col-md-6 col-sm-4'],
                'color' => 'danger',
                'icon' => 'la la-times',
                'total' => strval(app(\Laravel\Horizon\Contracts\JobRepository::class)->countRecentlyFailed()),
                'description' => 'Failed jobs',
                'link' => route('horizon.index'),
                'link-text' => 'Launch Horizon',
                'link-icon' => 'la la-external-link-alt'
            ],
            [
                'type' => 'stats',
                'wrapper' => ['class' => 'col-12'],
                'color' => 'dark',
                'icon' => 'la la-exclamation-triangle',
                'total' => strval(count(\App\Models\Alert::select('id')->get())),
                'description' => 'Alerts',
                'link' => backpack_url('alert')
            ],
            [
                'type' => 'stats',
                'wrapper' => ['class' => 'col-md-6 col-sm-4'],
                'color' => 'primary',
                'icon' => 'la la-map-signs',
                'total' => strval(count(\App\Models\Region::select('id')->get())),
                'description' => 'Regions',
                'link' => backpack_url('region')
            ],
            [
                'type' => 'stats',
                'wrapper' => ['class' => 'col-md-6 col-sm-4'],
                'color' => 'primary',
                'text-color' => 'muted',
                'icon' => 'la la-warehouse',
                'progress' => strval(count(\App\Models\Agency::where('is_active', true)->select('id')->get())),
                'total' => strval(count(\App\Models\Agency::select('id')->get())),
                'description' => 'Agencies',
                'link' => backpack_url('agency')
            ],
            [
                'type' => 'stats',
                'wrapper' => ['class' => 'col-md-6 col-sm-4'],
                'color' => 'primary',
                'text-color' => 'muted',
                'icon' => 'la la-bus',
                'progress' => strval(count(\App\Models\Vehicle::where('active', true)->select('id')->get())),
                'total' => strval(count(\App\Models\Vehicle::select('id')->get())),
                'description' => 'Vehicles',
                'link' => backpack_url('vehicle')
            ],
            [
                'type' => 'stats',
                'wrapper' => ['class' => 'col-md-6 col-sm-4'],
                'color' => 'primary',
                'icon' => 'la la-link',
                'total' => strval(count(\App\Models\Link::select('id')->get())),
                'description' => 'Links',
                'link' => backpack_url('link')
            ]
        ]
    ];
@endphp