<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Vehicle;
use App\Models\VinSuggestion;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class VinController extends Controller
{
    public function index()
    {
        $suggestions = VinSuggestion::with(['vehicles:vehicle,agency_id', 'vehicles.agency:id,color'])->latest()->limit(15)->get();

        $unlabelledVehicles = Vehicle::query()
            ->latest()
            ->where([['force_label', '=', null], ['agency_id', '>=', 5], ['agency_id', '<=', 16]])
            ->with(['agency:id,name', 'trip:id,route_short_name'])
            ->limit(15)
            ->get();

        return view('vin.index', compact('suggestions', 'unlabelledVehicles'));
    }

    public function show(string $vin)
    {
        $suggestions = VinSuggestion::where('vin', $vin)->get();
        $vehicles = Vehicle::query()
            ->where([['vehicle', '=', $vin], ['agency_id', '>=', 5], ['agency_id', '<=', 16]])
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

        Vehicle::query()
            ->withoutTouch()
            ->where(['vehicle' => $vinSuggestion->vin, 'agency_id' => $agency->id])
            ->update(['force_label' => $vinSuggestion->label]);

        return back()->with('status', 'Suggestion approved.');
    }

    public function delete(VinSuggestion $vinSuggestion)
    {
        $vinSuggestion->delete();

        return back()->with('status', 'Deleted.');
    }
}
