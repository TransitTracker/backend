<?php

namespace App\Http\Controllers\Vin;

use App\Enums\TagType;
use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Tag;
use App\Models\Vehicle;
use App\Models\Vin\Suggestion;
use App\Rules\Turnstile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SuggestionController extends Controller
{
    public function index()
    {
        $agencies = Agency::query()
            ->select(['id', 'short_name', 'color', 'name_slug', 'area_path'])
            ->where('is_archived', false)
            ->withCount('exoWithVin')
            ->orderBy('exo_order_id')
            ->exo()
            ->get();

        $operators = Tag::query()
            ->select(['slug', 'label', 'color', 'text_color'])
            ->ofType(TagType::Operator)
            ->withCount('exoVinVehicles')
            ->get()
            ->sortByDesc('exo_vin_vehicles_count');

        $suggestions = Suggestion::query()
            ->select(['vin', 'label', 'upvotes', 'created_at'])
            ->with(['vehicles:agency_id,vehicle_id,force_vehicle_id', 'vehicles.agency:id,color,short_name'])
            ->latest()
            ->limit(10)
            ->get();

        $unlabelledVehicles = Vehicle::query()
            ->select(['id', 'agency_id', 'vehicle_id', 'force_vehicle_id', 'gtfs_route_id', 'gtfs_trip_id', 'force_label', 'timestamp', 'updated_at'])
            ->whereNull('force_label')
            ->exoWithVin()
            ->latest()
            ->with(['relatedVehicles:id,vehicle_id,agency_id,updated_at,gtfs_trip_id,gtfs_route_id,is_active,timestamp', 'relatedVehicles.agency:id,color,short_name', 'relatedVehicles.trip:agency_id,gtfs_trip_id,headsign', 'relatedVehicles.gtfsRoute:agency_id,gtfs_route_id,short_name'])
            ->orderBy('timestamp')
            ->limit(10)
            ->get()
            ->map(function (Vehicle $vehicle) {
                $vehicle->lastVehicle = $vehicle->relatedVehicles->sortByDesc('timestamp')->first();
                $vehicle->one_is_active = in_array(true, $vehicle->relatedVehicles->pluck('is_active')->all());

                return $vehicle;
            });

        return view('vin.index', compact('agencies', 'operators', 'suggestions', 'unlabelledVehicles'));
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
            'cf-turnstile-response' => ['required', 'string', new Turnstile],
        ]);

        $request->session()->put("vin-{$vin}", $request->input('label'));

        Suggestion::create($request->except('cf-turnstile-response'));

        return back()->with('Thanks for your suggestion!');
    }

    public function vote(Request $request, Suggestion $suggestion)
    {
        $request->validate([
            'cf-turnstile-response' => ['required', 'string', new Turnstile],
        ]);

        $request->session()->put("vin-vote-{$suggestion->vin}", $suggestion->id);

        $suggestion->upvotes += 1;

        $suggestion->save();

        return back();
    }

    public function approve(Suggestion $suggestion, ?Agency $agency = null)
    {
        if (! $agency) {
            return response()->json(['message' => 'Missing agency'], 400);
        }

        $suggestion->update([
            'is_rejected' => false,
        ]);

        Vehicle::query()
            ->withoutTouch()
            ->where(['agency_id' => $agency->id, 'vehicle_id' => $suggestion->vin])
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
