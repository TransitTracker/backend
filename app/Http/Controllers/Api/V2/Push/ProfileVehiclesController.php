<?php

namespace App\Http\Controllers\Api\V2\Push;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\VehiclePushResource;
use App\Models\NotificationUser;
use Illuminate\Http\Request;

class ProfileVehiclesController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'uuid' => 'required|uuid',
        ]);

        $user = NotificationUser::query()
            ->where('uuid', $validated['uuid'])
            ->with([
                'vehicles:id,label,force_label,vehicle_id,force_vehicle_id,last_seen_at,vehicle_type,agency_id',
            ])
            ->firstOrFail();

        return VehiclePushResource::collection($user->vehicles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'uuid' => 'required|uuid',
            'vehicleId' => 'required|integer',
        ]);

        $user = NotificationUser::query()
            ->where('uuid', $validated['uuid'])
            ->withCount('vehicles')
            ->firstOrFail();

        if ($user->vehicles_count >= 50) {
            return response()
                ->json([
                    'message' => '50 favorites vehicles maximum.',
                ], 400);
        }

        $user->vehicles()->syncWithoutDetaching([$validated['vehicleId']]);

        $user->refresh();
        $user->load([
            'vehicles:id,label,force_label,vehicle_id,force_vehicle_id,last_seen_at,vehicle_type,agency_id',
        ]);

        return VehiclePushResource::collection($user->vehicles);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'uuid' => 'required|uuid',
            'vehicleId' => 'required|integer',
        ]);

        $user = NotificationUser::where('uuid', $validated['uuid'])->firstOrFail();

        $user->vehicles()->detach($validated['vehicleId']);

        $user->refresh();
        $user->load([
            'vehicles:id,label,force_label,vehicle_id,force_vehicle_id,last_seen_at,vehicle_type,agency_id',
        ]);

        return VehiclePushResource::collection($user->vehicles);
    }
}
