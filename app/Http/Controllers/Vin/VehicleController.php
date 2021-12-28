<?php

namespace App\Http\Controllers\Vin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VinSuggestion;

class VehicleController extends Controller
{
    public function show(string $vin)
    {
        $suggestions = VinSuggestion::where('vin', $vin)->get();
        $vehicles = Vehicle::query()
            ->where('vehicle', $vin)
            ->exo()
            ->with('agency:id,slug,short_name,color,text_color')
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
        ]);
    }
}
