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
            'vehicles:id,agency_id,vehicle_id,force_vehicle_id,label,force_label,updated_at,gtfs_route_id,gtfs_trip_id',
            'vehicles.trip:agency_id,gtfs_trip_id,headsign',
            'vehicles.gtfsRoute:agency_id,gtfs_route_id,short_name',
            'vehicles.vinInformationOriginal:vin,make',
            'vehicles.agency:id,name,color,text_color',
        ]);

        $agencies = $tag->vehicles->groupBy('agency')->sortDesc();

        return view('vin.operator', compact('tag', 'agencies'));
    }
}
