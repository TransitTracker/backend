<?php

namespace App\Http\Controllers\Vin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Vehicle;

class AgencyController extends Controller
{
    public function show(Agency $agency)
    {
        $vehicles = Vehicle::query()
            ->vin()
            ->where('agency_id', $agency->id)
            ->select(['id', 'agency_id', 'vehicle_id', 'force_vehicle_id', 'label', 'force_label', 'updated_at', 'gtfs_trip_id', 'gtfs_route_id'])
            ->with([
                'trip:agency_id,gtfs_trip_id,headsign',
                'gtfsRoute:agency_id,gtfs_route_id,short_name',
                'tags:id,label',
                'vinInformationOriginal:vin,make',
            ])
            ->orderBy('force_label')
            ->get();

        return view('vin.agency', compact('agency', 'vehicles'));
    }
}
