<?php

namespace App\Http\Controllers\Api\V2;

use App;
use App\Http\Controllers\Controller;
use App\Http\Resources\V2\BlockResource;
use App\Models\Agency;
use App\Models\Trip;
use Illuminate\Support\Facades\Validator;

class BlockController extends Controller
{
    public function __construct()
    {
        if (! App::environment('local')) {
            $this->middleware('throttle:45,1,v2-blocks');
        }

        // One week, blocks will not change
        $this->middleware('cacheResponse:604800');
    }

    public function show(Agency $agency, string $tripId)
    {
        $trip = Trip::select(['id', 'agency_id', 'trip_id', 'service_id', 'gtfs_block_id'])->where(['agency_id' => $agency->id, 'trip_id' => $tripId])->first();

        if (! $trip) {
            return response()->json(['message' => 'Trip not found.', 'errors' => (object) [
                'trip_id' => ['Trip not found.'],
            ]], 404);
        }

        // Make sure the agency support blocks, otherwise it will throw an error
        Validator::make($trip->toArray(), [
            'tripId' => 'required_without_all:block_id,trip_id',
            'gtfs_block_id' => 'required',
            'trip_id' => 'required',
        ])->validate();

        $trips = Trip::query()
            ->where(['agency_id' => $agency->id, 'gtfs_block_id' => $trip->gtfs_block_id, 'service_id' => $trip->service_id])
            ->select(['id', 'agency_id', 'trip_id', 'trip_headsign', 'trip_short_name', 'route_color', 'route_text_color', 'route_short_name'])
            ->with('firstDeparture')
            ->get()
            ->sortBy('firstDeparture.departure')
            ->transform(function ($item) {
                $item->firstDeparture->departure = str($item->firstDeparture->departure)->substr(0, 5);

                return $item;
            });

        return BlockResource::collection($trips);
    }
}
