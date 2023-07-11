<?php

namespace App\Http\Controllers\Vin;

use App\Enums\TagType;
use App\Http\Controllers\Controller;
use App\Models\Tag;

class OperatorController extends Controller
{
    public function show(Tag $tag)
    {
        abort_if($tag->type->value !== TagType::Operator, 404);

        $tag->load([
            'exoVinVehicles:id,agency_id,vehicle_id,force_vehicle_id,label,force_label,timestamp,gtfs_route_id,gtfs_trip_id',
            'exoVinVehicles.trip:agency_id,gtfs_trip_id,headsign',
            'exoVinVehicles.gtfsRoute:agency_id,gtfs_route_id,short_name',
            'exoVinVehicles.vinInformationOriginal:vin,make',
            'exoVinVehicles.agency:id,name,color,text_color',
        ]);

        $agencies = $tag->exoVinVehicles->sortBy('force_label')->groupBy('agency')->sortDesc();

        return view('vin.operator', compact('tag', 'agencies'));
    }
}
