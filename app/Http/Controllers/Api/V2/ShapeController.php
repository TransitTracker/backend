<?php

namespace App\Http\Controllers\Api\V2;

use App;
use App\Http\Controllers\Controller;
use App\Http\Resources\V2\GeoJsonShapeResource;
use App\Models\Agency;
use App\Models\Gtfs\Shape;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

#[Group('Shapes')]
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
     * Get trip shape as GeoJSON
     *
     * Retrieve the GeoJSON LineString geometry of a transit route shape, including stop coordinates along the path.
     */
    #[PathParameter('agencySlug', description: 'The unique slug identifier of the transit agency.', type: 'string', example: 'stm')]
    #[PathParameter('shapeId', description: 'The GTFS Shape identifier.', type: 'string', example: '1000238')]
    public function show(Agency $agencySlug, string $shapeId)
    {
        return GeoJsonShapeResource::make(
            Shape::query()
                ->where(['agency_id' => $agencySlug->id, 'gtfs_shape_id' => $shapeId])
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
