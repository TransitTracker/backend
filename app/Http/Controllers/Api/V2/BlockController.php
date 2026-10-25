<?php

namespace App\Http\Controllers\Api\V2;

use App;
use App\Http\Controllers\Controller;
use App\Http\Resources\V2\BlockResource;
use App\Models\Agency;
use App\Models\Gtfs\Trip;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Illuminate\Support\Facades\Validator;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

#[Group('Trips')]
class BlockController extends Controller
{
    public function __construct()
    {
        if (! App::environment('local', 'testing')) {
            $this->middleware('throttle:45,1,v2-blocks');
        }

        // One week, blocks will not change
        $this->middleware(CacheResponse::for(days(7)));
    }

    /**
     * Get related trips in block
     *
     * Retrieve all trips operating in the same GTFS vehicle block as the specified trip. Only available for agencies providing block assignments (e.g., go).
     */
    #[PathParameter('agencySlug', description: 'The unique slug identifier of the transit agency.', type: 'string', example: 'go')]
    #[PathParameter('tripId', description: 'The GTFS Trip identifier.', type: 'string', example: '951057')]
    public function show(Agency $agencySlug, string $tripId)
    {
        $trip = Trip::select(['id', 'agency_id', 'gtfs_trip_id', 'gtfs_service_id', 'gtfs_block_id'])->where(['agency_id' => $agencySlug->id, 'gtfs_trip_id' => $tripId])->first();

        if (! $trip) {
            return response()->json(['message' => 'Trip not found.', 'errors' => (object) [
                'gtfs_trip_id' => ['Trip not found.'],
            ]], 404);
        }

        // Make sure the agency support blocks, otherwise it will throw an error
        Validator::make($trip->toArray(), [
            'tripId' => 'required_without_all:gtfs_block_id,gtfs_trip_id',
            'gtfs_block_id' => 'required',
            'gtfs_trip_id' => 'required',
        ])->validate();

        $trips = Trip::query()
            ->where(['agency_id' => $agencySlug->id, 'gtfs_block_id' => $trip->gtfs_block_id, 'gtfs_service_id' => $trip->gtfs_service_id])
            ->select(['id', 'agency_id', 'gtfs_trip_id', 'headsign', 'short_name', 'gtfs_route_id'])
            ->with(['firstDeparture', 'route:agency_id,gtfs_route_id,short_name,color,text_color'])
            ->get()
            ->filter(function ($item) {
                return $item->firstDeparture;
            })
            ->sortBy('firstDeparture.departure')
            ->transform(function ($item) {
                $item->firstDeparture->departure = str($item->firstDeparture->departure)->substr(0, 5);

                return $item;
            });

        return BlockResource::collection($trips);
    }
}
