<?php

namespace App\Http\Controllers\Api\V2;

use App;
use App\Http\Controllers\Controller;
use App\Http\Resources\V2\GeoJsonShapeResource;
use App\Models\Agency;
use App\Models\Gtfs\Shape;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\UrlParam;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

class ShapeController extends Controller
{
    public function __construct()
    {
        if (! App::environment('local')) {
            $this->middleware('throttle:45,1,v2-shapes');
        }

        // One week, shapes should not change very often
        $this->middleware(CacheResponse::for(days(7)));
    }

    /**
     * GeoJSON Shape
     */
    #[Group('Trips')]
    #[UrlParam('shapeId', '1000238')]
    public function show(Agency $agency, string $shapeId)
    {
        return GeoJsonShapeResource::make(
            Shape::query()
                ->where(['agency_id' => $agency->id, 'gtfs_shape_id' => $shapeId])
                ->select(['agency_id', 'gtfs_shape_id', 'shape'])
                ->with([
                    'firstTrip:id,trips.agency_id,gtfs_trip_id,trips.gtfs_shape_id',
                    'firstTrip.stopTimes:stop_times.agency_id,stop_times.gtfs_trip_id,gtfs_stop_id',
                    'firstTrip.stopTimes.stop:stops.agency_id,stops.gtfs_stop_id,position',
                ])
                ->firstOrFail()
        );
    }
}
