<?php

namespace App\Jobs\RealtimeData;

use App\Models\Agency;
use App\Models\Stat;
use App\Models\Trip;
use App\Models\Vehicle;
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

    /**
     * Create a new job instance.
     *
     * @param  string  $dataFile
     * @param  int  $time
     */
    public function __construct(private Agency $agency, private $dataFile, private $time)
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
        ])->select(['id', 'is_active', 'active'])->get();
        $activeArray = [];

        $data = Storage::get($this->dataFile);

        // Convert JSON to PHP object
        $json = json_decode($data);

        $timestamp = floor($json?->lastTime?->time / 1000);

        // Return early if there is no vehicles
        if (!property_exists($json, 'vehicle') || gettype($json?->vehicle) !== 'array') {
            return;
        }

        $vehiclesToUpdate = [];

        info('Before foreach');

        // Go trough each vehicle
        foreach ($json->vehicle as $vehicle) {
            // Continue if there is no routeTag
            if (! $vehicle?->routeTag || ! $vehicle?->id) {
                continue;
            }

            info("Vehicle {$vehicle->id}");

            // Continue if outdated
            if ((int) $vehicle?->secsSinceReport > 120) {
                continue;
            }

            $vehiclesToUpdate[] = [
                'agency_id' => $this->agency->id,
                'vehicle' => $vehicle->id,
                'vehicle_id' => $vehicle->id,
                'active' => true,
                'is_active' => true,
                'lat' => $this->processField(round((float) $vehicle->lat, 5)),
                'lon' => $this->processField(round((float) $vehicle->lon, 5)),
                'position' => $this->processField(['lat' => $vehicle->lat, 'lon' => $vehicle->lon], 'position'),
                'route' => $this->processField($vehicle->routeTag),
                'gtfs_route_id' => $this->processField($vehicle->routeTag),
                'bearing' => $this->processField($vehicle->heading),
                'speed' => $this->processField($vehicle->speedKmHr),
                'timestamp' => $this->processField(strval($timestamp - (int) $vehicle->secsSinceReport)),
                'trip_id' => $this->retrieveTrip($vehicle->routeTag),
            ];

            info("Added vehicle {$vehicle->id} to array");

            $activeArray[] = $vehicle->id;
        }
        info("After foreach");

        Vehicle::upsert($vehiclesToUpdate, ['agency_id', 'vehicle_id']);

        info("After upsert");


        // Update active information
        if ($inactiveArray->except($activeArray)->count() > 0) {
            $inactiveArray->except($activeArray)->toQuery()->update(['is_active' => false, 'active' => false]);
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

        // Delete the file
        Storage::delete($this->dataFile);
    }

    private function processField($value, string $transformer = null)
    {
        if (! filled($value)) {
            return null;
        }

        if ($transformer === 'position' && filled($value['lat']) && filled($value['lon'])) {
            return (new Point(round((float) $value['lat'], 5), round((float) $value['lon'], 5)))->toSqlExpression(DB::connection());
        }

        return $value;
    }

    private function retrieveTrip(string $routeTag)
    {
        if ($this->agency->slug !== 'stl') {
            return null;
        }

        return Trip::where([['agency_id', $this->agency->id], ['gtfs_shape_id', 'LIKE', "%{$routeTag}%"]])
            ->select('id')
            ->pluck('id')
            ->first();
    }
}
