<?php

namespace App\Jobs\RealtimeData;

use App\Models\Agency;
use App\Models\Gtfs\Route;
use App\Models\Gtfs\Trip;
use App\Models\Stat;
use App\Models\Vehicle;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MatanYadaev\EloquentSpatial\Objects\Point;

class NextbusJsonHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue = 'realtime-process';

    /**
     * Create a new job instance.
     */
    public function __construct(private Agency $agency, private int $time)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws Exception
     */
    public function handle()
    {
        // Put all previously active vehicle as inactive
        $inactiveArray = Vehicle::where([
            ['is_active', true],
            ['agency_id', $this->agency->id],
        ])->select(['id', 'is_active'])->get();
        $activeArray = [];

        $data = Storage::get("realtime/{$this->agency->slug}");

        // Convert JSON to PHP object
        $json = json_decode($data);

        $timestamp = floor($json?->lastTime?->time / 1000);

        // Return early if there is no vehicles
        if (! property_exists($json, 'vehicle') || gettype($json?->vehicle) !== 'array') {
            return;
        }

        // Go trough each vehicle
        foreach ($json->vehicle as $vehicle) {
            // Continue if there is no routeTag
            if (! $vehicle?->routeTag || ! $vehicle?->id) {
                continue;
            }

            // Continue if outdated
            if ((int) $vehicle?->secsSinceReport > 120) {
                continue;
            }

            $vehicleModel = Vehicle::updateOrCreate(['agency_id' => $this->agency->id, 'vehicle_id' => $vehicle->id],
                [
                    'is_active' => true,
                    'agency_id' => $this->agency->id,
                    'vehicle_id' => $vehicle->id,
                    'position' => $this->processField(['lat' => $vehicle->lat, 'lon' => $vehicle->lon], 'position'),
                    'gtfs_route_id' => $this->retrieveRoute($vehicle->routeTag),
                    'gtfs_trip_id' => $this->retrieveTrip($vehicle->routeTag),
                    'bearing' => $this->processField($vehicle->heading),
                    'speed' => $this->processField($vehicle->speedKmHr),
                    'timestamp' => $this->processField(strval($timestamp - (int) $vehicle->secsSinceReport)),
                    'last_seen_at' => Carbon::parse($this->processField($timestamp - (int) $vehicle->secsSinceReport)),
                ]
            );

            $activeArray[] = $vehicleModel->id;
        }

        // Update active information
        if ($inactiveArray->except($activeArray)->count() > 0) {
            $inactiveArray->except($activeArray)->toQuery()->update(['is_active' => false]);
        }

        // Replace timestamp
        $this->agency->timestamp = (int) $timestamp;
        $this->agency->save();

        // Get count
        $count = count($json->vehicle);

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => $count,
            'agency' => $this->agency->slug,
            'time' => $this->time,
        ];
        $stat->save();
    }

    private function processField($value, ?string $transformer = null)
    {
        if (! filled($value)) {
            return null;
        }

        if ($transformer === 'position' && filled($value['lat']) && filled($value['lon'])) {
            return (new Point(round((float) $value['lat'], 5), round((float) $value['lon'], 5)))->toSqlExpression(DB::connection());
        }

        return $value;
    }

    // TODO: Improve because trip_id should not be visible to the user as it is just a random one
    // Only possible with STL since it's simple, one route direction = one shape
    private function retrieveTrip(string $routeTag): ?string
    {
        if ($this->agency->slug !== 'stl') {
            return null;
        }

        return Trip::where([['agency_id', $this->agency->id], ['gtfs_shape_id', 'LIKE', "%{$routeTag}%"]])
            ->select('gtfs_trip_id')
            ->pluck('gtfs_trip_id')
            ->first();
    }

    private function retrieveRoute(string $routeTag): string
    {
        if ($this->agency->slug === 'stl') {
            return Route::where([
                ['agency_id', $this->agency->id],
                ['gtfs_route_id', 'LIKE', "%{$routeTag}"],
                ['short_name', substr($routeTag, 0, -1)],
            ])
                ->select('gtfs_route_id')
                ->pluck('gtfs_route_id')
                ->first() ?? $routeTag;
        }

        if ($this->agency->slug === 'ttc') {
            return Route::where(['agency_id' => $this->agency->id, 'short_name' => $routeTag])
                ->select('gtfs_route_id')
                ->pluck('gtfs_route_id')
                ->first() ?? $routeTag;
        }

        return $routeTag;
    }
}
