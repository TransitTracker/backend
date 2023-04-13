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
            ->exo()
            ->with(['agency:id,slug,short_name,color,text_color', 'trip:id,route_short_name,route_long_name,trip_headsign,trip_short_name,trip_id', 'tags:id,label,description,color,text_color', 'vinInformationForceRef'])
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
