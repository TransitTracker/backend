<?php

namespace App\Http\Controllers\Vin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Vehicle;
use App\Models\VinSuggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AgencyController extends Controller
{
    public function show(Agency $agency)
    {
        $agency->load('exoWithVin', 'exoWithVin.trip:id,route_short_name,trip_headsign');

        $vehicles = $agency->exoWithVin->sortBy('force_label');

        return view('vin.agency', compact('agency', 'vehicles'));
    }

    public function store(Request $request, Agency $agency)
    {
        $vin = $request->input('vin');

        $this->validate($request, [
            'vin' => [
                'required',
                'size:17',
                'exists:vehicles,vehicle',
            ],
            'label' => [
                'required',
                Rule::unique('vin_suggestions')->where(function ($query) use ($vin) {
                    return $query->where('vin', $vin);
                }),
            ],
        ]);

        VinSuggestion::create([
            'vin' => $request->input('vin'),
            'label' => $request->input('label'),
            'note' => Auth::user()->name,
        ]);

        Vehicle::where([['vehicle', '=', $vin], ['agency_id', $agency->id]])->update(['force_label' => $request->input('label')]);

        return back()->with('Done!');
    }
}