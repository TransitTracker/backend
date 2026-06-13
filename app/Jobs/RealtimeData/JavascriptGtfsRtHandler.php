<?php

namespace App\Jobs\RealtimeData;

use App\Models\Agency;
use App\Models\Carriage;
use App\Models\Stat;
use App\Models\Vehicle;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use MatanYadaev\EloquentSpatial\Objects\Point;

class JavascriptGtfsRtHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Agency $agency, private int $time) {}

    private array $activeArray = [];

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filePath = Storage::path("realtime/{$this->agency->slug}");
        $printGtfsRt = config('transittracker.print_gtfs_rt_bin');

        // Convert protobuf to PHP object
        try {
            $result = Process::run("cat '{$filePath}' | {$printGtfsRt} -s");
            $collection = collect(json_decode($result->output()));
            $count = $collection->count();
        } catch (Exception $e) {
            Log::error("Error while decoding GTFS-RT feed from {$this->agency->slug}: {$e->getMessage()}");

            return;
        }

        $carriagesToUpsert = [];
        $seenVehicleIds = [];

        // Go through each vehicle
        // Where not null to exclude alerts and trip updates
        $collection->whereNotNull('vehicle')->each(function ($entity) use (&$carriagesToUpsert, &$seenVehicleIds) {
            /*
             * Check if entity has vehiclePosition or if is not valid
             */
            if (! $entity->vehicle || ! $entity->vehicle?->trip || ! $entity->vehicle?->position) {
                return;
            }
            $vehicle = $entity->vehicle;

            $seenVehicleIds[] = $vehicle->vehicle->id;

            /*
             * Prepare a new array to update the vehicle model
             */
            $newVehicle = [
                'is_active' => true,
                'gtfs_trip_id' => $this->processField($vehicle->trip?->trip_id),
                'gtfs_route_id' => $this->processField($vehicle->trip?->route_id),
                'start_time' => $this->processField($vehicle->trip?->start_time ?? null),
                'schedule_relationship' => $this->processField($vehicle->trip?->schedule_relationship),
                'position' => $this->processField(['lat' => $vehicle->position?->latitude, 'lon' => $vehicle->position?->longitude], 'position'),
                'current_stop_sequence' => $this->processField($vehicle->current_stop_sequence ?? null),
                'current_status' => $this->processField($vehicle->current_status ?? null),
                'timestamp' => $this->processField($vehicle->timestamp->low ?? $this->time),
                'gtfs_stop_id' => $this->processField($vehicle->stop_id ?? null),
                'last_seen_at' => $this->processField($vehicle->timestamp->low ?? $this->time, 'timestamp'),
            ];

            /*
             * Update vehicles carriage
             */
            if (property_exists($vehicle, 'multi_carriage_details')) {
                foreach ($vehicle->multi_carriage_details as $item) {
                    $carriagesToUpsert[] = [
                        'agency_id' => $this->agency->id,
                        'carriage_id' => $item->id,
                        'vehicle_id' => $vehicle->vehicle->id,
                        'label' => $item->label ?? null,
                        'occupancy_status' => $item->occupancy_status ?? null,
                        'sequence' => $item->carriage_sequence,
                    ];
                }
            }

            /*
             * Create or update the vehicle model
             */
            try {
                $vehicleModel = Vehicle::updateOrCreate(['agency_id' => $this->agency->id, 'vehicle_id' => $vehicle->vehicle->id], $newVehicle);

                $this->activeArray[] = $vehicleModel->id;
            } catch (Exception $e) {
                Log::warning('Vehicle in the refresh failed', [
                    'agency' => $this->agency->slug,
                    'exception' => $e->getMessage(),
                    'line' => $e->getLine(),
                ]);
            }
        });

        // Mass Upsert Carriages
        if (! empty($carriagesToUpsert)) {
            Carriage::upsert(
                $carriagesToUpsert,
                ['agency_id', 'carriage_id'],
                ['label', 'occupancy_status', 'sequence', 'vehicle_id']
            );
        }

        // Mark unseen vehicles as inactive in a single query
        if (! empty($seenVehicleIds)) {
            Vehicle::where('agency_id', $this->agency->id)
                ->where('is_active', true)
                ->whereNotIn('vehicle_id', $seenVehicleIds)
                ->update(['is_active' => false]);
        }

        // Replace timestamp
        $this->agency->timestamp = $this->time;
        $this->agency->save();

        // Add statistics
        Stat::create([
            'type' => 'vehicleTotal',
            'data' => [
                'count' => $count,
                'agency' => $this->agency->slug,
                'time' => $this->time,
            ],
        ]);
    }

    private function processField(mixed $value, ?string $transformer = null)
    {
        if ($transformer === 'speed') {
            return (is_numeric($value) && $value >= 0 && $value <= 150) ? round((float) $value, 0) : null;
        }

        if ($transformer === 'odometer') {
            return (is_numeric($value) && $value >= 0 && $value <= 10000000) ? round((float) $value, 0) : null;
        }

        if ($transformer === 'bearing') {
            return (is_numeric($value) && $value >= 0 && $value <= 360) ? round((float) $value, 0) : null;
        }

        if (! filled($value)) {
            return null;
        }

        if ($transformer === 'label' && in_array($this->agency->slug, ['go', 'up', 'la', 'vr', 'lr', 'lasso', 'sju', 'so', 'hsl', 'pi', 'rous', 'sv', 'tm', 'crc'])) {
            return null;
        }

        if ($transformer === 'position' && filled($value['lat']) && filled($value['lon'])) {
            $lat = round((float) $value['lat'], 5);
            $lon = round((float) $value['lon'], 5);
            if ($lat < -90 || $lat > 90 || $lon < -180 || $lon > 180) {
                return null;
            }

            return new Point($lat, $lon);
        }

        if ($transformer === 'timestamp') {
            $timestamp = ($value > 0) ? $value : $this->time;

            return Carbon::createFromTimestamp($timestamp, 'America/Toronto');
        }

        return $value;
    }
}
