<?php

namespace App\Http\Controllers\Vin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Vehicle;
use App\Models\Vin\Suggestion;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SuggestionController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::with(['vehicles:vehicle,agency_id', 'vehicles.agency:id,color,short_name'])->latest()->limit(15)->get();

        $unlabelledVehicles = Vehicle::query()
            ->latest()
            ->where([['force_label', '=', null]])
            ->exoWithVin()
            ->orderBy('updated_at')
            ->select('id', 'vehicle', 'trip_id', 'force_label', 'agency_id', 'updated_at')
            ->with(['relatedVehicles:id,vehicle,agency_id,updated_at,trip_id,active', 'relatedVehicles.agency:id,color,short_name', 'relatedVehicles.trip:id,route_short_name,trip_headsign'])
            ->limit(15)
            ->get();

        $sortedUnlabbeledVehicles = $unlabelledVehicles->map(function ($table) {
            $lastVehicle = $table->relatedVehicles->sortByDesc('updated_at')->first();
            $table->last_seen_at_with_related = $lastVehicle->updated_at;
            $table->last_trip = $lastVehicle->trip;
            $table->one_is_active = in_array(true, $table->relatedVehicles->pluck('active')->all());

            return $table;
        })->sortByDesc('last_seen_at_with_related');

        $unsortedAgencies = Agency::query()
            ->where([['id', '>=', 5], ['id', '<=', 16]])
            ->withCount('exoLabelledVehicles', 'exoUnlabelledVehicles')
            ->get();

        $agencies = $unsortedAgencies->sortByDesc('exo_unlabelled_vehicles_count');

        $allLabelled = $agencies->sum('exo_labelled_vehicles_count');
        $allUnlabelled = $agencies->sum('exo_unlabelled_vehicles_count');

        return view('vin.index', compact('suggestions', 'sortedUnlabbeledVehicles', 'agencies', 'allLabelled', 'allUnlabelled'));
    }

    public function store(Request $request, string $vin)
    {
        abort_unless($vin === $request->input('vin'), 404, 'VIN do not match.');

        $this->validate($request, [
            'vin' => [
                'required',
                'size:17',
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

        Suggestion::create($request->all());

        return back()->with('Thanks for your suggestion!');
    }

    public function vote(Request $request, Suggestion $suggestion)
    {
        $request->validate([
            'g-recaptcha-response' => ['required', 'string', new Recaptcha],
        ]);

        $request->session()->put("vin-vote-{$suggestion->vin}", $suggestion->id);

        $suggestion->upvotes += 1;

        $suggestion->save();

        return back();
    }

    public function approve(Suggestion $suggestion, Agency $agency = null)
    {
        if (! $agency) {
            return response()->json(['message' => 'Missing agency'], 400);
        }

        $suggestion->update([
            'is_rejected' => false,
        ]);

        Vehicle::query()
            ->withoutTouch()
            ->where(['vehicle' => $suggestion->vin, 'agency_id' => $agency->id])
            ->update(['force_label' => $suggestion->label]);

        return back()->with('status', 'Suggestion approved.');
    }

    public function reject(Suggestion $suggestion)
    {
        $suggestion->update([
            'is_rejected' => true,
        ]);

        return back()->with('status', 'Deleted.');
    }
}
