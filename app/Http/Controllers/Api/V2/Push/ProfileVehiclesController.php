<?php

namespace App\Http\Controllers\Api\V2\Push;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\NotificationUserResource;
use App\Models\NotificationUser;
use Illuminate\Http\Request;

class ProfileVehiclesController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'uuid' => 'required|uuid',
            'vehicleId' => 'required|integer',
        ]);

        $user = NotificationUser::where('uuid', $validated['uuid'])->firstOrFail();

        $user->vehicles()->syncWithoutDetaching([$validated['vehicleId']]);

        $user->load('vehicles:id,label,force_label,vehicle,icon,agency_id', 'vehicles.agency:id,slug');

        return NotificationUserResource::make($user);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'uuid' => 'required|uuid',
            'vehicleId' => 'required|integer',
        ]);

        $user = NotificationUser::where('uuid', $validated['uuid'])->firstOrFail();

        $user->vehicles()->detach($validated['vehicleId']);

        $user->load('vehicles:id,label,force_label,vehicle,icon,agency_id', 'vehicles.agency:id,slug');

        return NotificationUserResource::make($user);
    }
}
