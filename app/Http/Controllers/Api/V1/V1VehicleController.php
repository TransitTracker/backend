<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehiclesCollection;
use App\Models\Agency;
use App\Models\Vehicle;
use Illuminate\Support\Facades\App;
use Laracsv\Export;
use League\Csv\CannotInsertRecord;

class V1VehicleController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agency  $agency
     * @return VehiclesCollection|\Illuminate\Http\JsonResponse
     */
    public function show(Agency $agency)
    {
        if ($agency->is_active) {
            $vehicles = Vehicle::where([['active', true], ['agency_id', $agency->id]])->with(['trip', 'links:link_id'])->get();

            return (new VehiclesCollection($vehicles))
                ->additional([
                    'timestamp' => $agency->timestamp,
                ]);
        } else {
            return response()->json(['message' => 'AGENCY_INACTIVE'], 403);
        }
    }

    /**
     * Display the specified resource, in CSV format.
     *
     * @param Agency $agency
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function dump(Agency $agency)
    {
        if (App::environment('local')) {
            app('debugbar')->disable();
        }

        if ((bool)!$agency->license['is_downloadable']) {
            return response()->json(['message' => 'Download not allowed for this agency.'], 403);
        }

        $fields = ['agency.slug', 'vehicle', 'route', 'gtfs_trip', 'lat', 'lon', 'trip.trip_headsign',
            'trip.trip_short_name', 'trip.route_short_name', 'trip.route_long_name', 'trip.service.service_id', 'bearing',
            'speed', 'start', 'status', 'current_stop_sequence', 'created_at', 'updated_at', 'relationship', 'label',
            'plate', 'odometer', 'timestamp', 'congestion', 'occupancy',];

        $vehicles = Vehicle::where('agency_id', $agency->id)->get();

        $date = date('Ymd_Hi');
        $fileName = "tt-dump-{$agency->slug}-{$date}.csv";

        $csvExporter = new Export();

        try {
            return $csvExporter->build($vehicles, $fields)->download($fileName);
        } catch (CannotInsertRecord $e) {
            return response()->json(['message' => 'Problem while generating CSV. Please try again later.'], 500);
        }
    }
}
