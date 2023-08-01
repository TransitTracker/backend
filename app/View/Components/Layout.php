<?php

namespace App\View\Components;

use App\Enums\TagType;
use App\Models\Agency;
use App\Models\Tag;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout', [
            'sectors' => Cache::remember('exoSectors', 86400, function () {
                return Agency::exo()->select(['short_name', 'color', 'name_slug', 'is_archived'])->withCount('exoWithVin')->orderBy('is_archived')->orderBy('exo_order_id')->get();
            }),
            'operators' => Cache::remember('exoOperators', 86400, function () {
                return Tag::ofType(TagType::Operator)->select(['label', 'slug', 'color', 'text_color'])->withCount('exoVinVehicles')->get()->sortByDesc('exo_vin_vehicles_count');
            }),
        ]);
    }
}
