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
            ->where('vehicle', $vin)
            ->exo()
            ->with(['agency:id,slug,short_name,color,text_color', 'trip:id,route_short_name,route_long_name,trip_headsign,trip_short_name,trip_id', 'tag:id,label,description,color,text_color'])
            ->get();

        if (!$vehicles->count()) {
            return view('vin.error', ['vin' => $vin])->with('Invalid VIN');
        }

        $vinInfo = $vehicles[0]->vin_info;

        return view('vin.show', [
            'vin' => $vin,
            'suggestions' => $suggestions,
            'vehicles' => $vehicles,
            'sessionSuggestion' => session("vin-{$vin}"),
            'sessionVote' => session("vin-vote-{$vin}"),
            'vinInfo' => $vinInfo,
        ]);
    }
}
