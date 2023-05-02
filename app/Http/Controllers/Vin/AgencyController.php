<?php

namespace App\Http\Controllers\Vin;

use App\Http\Controllers\Controller;
use App\Models\Agency;

class AgencyController extends Controller
{
    public function show(Agency $agency)
    {
        $agency->load('exoWithVin:agency_id,vehicle_id,force_vehicle_id,label,force_label,updated_at,gtfs_trip_id,gtfs_route_id', 'exoWithVin.trip:agency_id,gtfs_trip_id,headsign', 'exoWithVin.gtfsRoute:agency_id,gtfs_route_id,short_name');

        $vehicles = $agency->exoWithVin->sortBy('force_label');
        $vehicles->load('tags:id,label', 'vinInformationForceRef:vin,make');

        return view('vin.agency', compact('agency', 'vehicles'));
    }
}
