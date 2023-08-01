<?php

namespace App\Http\Controllers\Vin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Vin\Suggestion;

class VehicleController extends Controller
{
    public function show(string $vin)
    {
        $suggestions = Suggestion::where('vin', $vin)->get();

        $vehicles = Vehicle::query()
            ->where(['vehicle_id' => $vin, 'force_vehicle_id' => null])
            ->orWhere('force_vehicle_id', $vin)
            ->exoWithVin()
            ->with(['agency:id,slug,short_name,color,text_color,name_slug,is_archived', 'gtfsRoute:agency_id,gtfs_route_id,short_name,long_name', 'trip:agency_id,gtfs_trip_id,headsign,short_name', 'tags:id,label,description,color,text_color,slug', 'vinInformationOriginal'])
            ->orderBy('updated_at', 'desc')
            ->get();

        if (! $vehicles->count()) {
            return view('vin.error', ['vin' => $vin])->with('Invalid VIN');
        }

        return view('vin.show', [
            'vin' => $vin,
            'suggestions' => $suggestions,
            'vehicles' => $vehicles,
            'sessionSuggestion' => session("vin-{$vin}"),
            'sessionVote' => session("vin-vote-{$vin}"),
            'information' => $vehicles[0]->vinInformation,
        ]);
    }
}
