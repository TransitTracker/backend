<?php

namespace App\Http\Controllers\Vin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Vehicle;
use App\Models\VinSuggestion;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VinSuggestionController extends Controller
{
    public function index()
    {
        $suggestions = VinSuggestion::with(['vehicles:vehicle,agency_id', 'vehicles.agency:id,color,short_name'])->latest()->limit(15)->get();

        $unlabelledVehicles = Vehicle::query()
            ->latest()
            ->where([['force_label', '=', null], ['agency_id', '>=', 5], ['agency_id', '<=', 16]])
            ->with(['agency:id,name,color,short_name', 'trip:id,route_short_name,trip_headsign'])
            ->limit(15)
            ->get();

        $unsortedAgencies = Agency::query()
            ->where([['id', '>=', 5], ['id', '<=', 16]])
            ->withCount('exoLabelledVehicles', 'exoUnlabelledVehicles')
            ->get();

        $agencies = $unsortedAgencies->sortByDesc('exo_unlabelled_vehicles_count');

        $allLabelled = $agencies->sum('exo_labelled_vehicles_count');
        $allUnlabelled = $agencies->sum('exo_unlabelled_vehicles_count');

        return view('vin.index', compact('suggestions', 'unlabelledVehicles', 'agencies', 'allLabelled', 'allUnlabelled'));
    }

    public function store(Request $request, string $vin)
    {
        abort_unless($vin === $request->input('vin'), 404, 'VIN do not match.');

        $this->validate($request, [
            'vin' => [
                'required',
                'size:17',
                'exists:vehicles,vehicle',
            ],
            'label' => [
                'required',
                'regex:/^[0-9-]*\d$/',
                Rule::unique('vin_suggestions')->where(function ($query) use ($vin) {
                    return $query->where('vin', $vin);
                }),
            ],
            'note' => 'max:255',
            'g-recaptcha-response' => ['required', 'string', new Recaptcha],
        ]);

        $request->session()->put("vin-{$vin}", $request->input('label'));

        VinSuggestion::create($request->all());

        return back()->with('Thanks for your suggestion!');
    }

    public function vote(Request $request, VinSuggestion $vinSuggestion)
    {
        $request->validate([
            'g-recaptcha-response' => ['required', 'string', new Recaptcha],
        ]);

        $request->session()->put("vin-vote-{$vinSuggestion->vin}", $vinSuggestion->id);

        $vinSuggestion->upvotes += 1;

        $vinSuggestion->save();

        return back();
    }

    public function approve(VinSuggestion $vinSuggestion, Agency $agency = null)
    {
        if (! $agency) {
            return response()->json(['message' => 'Missing agency'], 400);
        }

        $vinSuggestion->update([
            'is_rejected' => false,
        ]);

        Vehicle::query()
            ->withoutTouch()
            ->where(['vehicle' => $vinSuggestion->vin, 'agency_id' => $agency->id])
            ->update(['force_label' => $vinSuggestion->label]);

        return back()->with('status', 'Suggestion approved.');
    }

    public function reject(VinSuggestion $vinSuggestion)
    {
        $vinSuggestion->update([
            'is_rejected' => true,
        ]);

        return back()->with('status', 'Deleted.');
    }
}
