<?php

namespace App\Http\Controllers\Vin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Vehicle;

class AgencyController extends Controller
{
    public function show(string $sector)
    {
        $agency = Agency::query()
            ->where('name_slug', $sector)
            ->select(['id', 'name', 'color', 'is_archived'])
            ->firstOrFail();

        $vehicles = Vehicle::query()
            ->vin()
            ->where('agency_id', $agency->id)
            ->select(['id', 'agency_id', 'vehicle_id', 'force_vehicle_id', 'label', 'force_label', 'timestamp', 'gtfs_trip_id', 'gtfs_route_id'])
            ->with([
                'trip:agency_id,gtfs_trip_id,headsign',
                'gtfsRoute:agency_id,gtfs_route_id,short_name',
                'tags:id,label,slug',
                'vinInformationOriginal:vin,make',
            ])
            ->orderBy('force_label')
            ->get();

        return view('vin.agency', compact('agency', 'vehicles'));
    }
}
