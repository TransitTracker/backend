<?php

namespace App\Jobs\RealtimeData;

use App\Actions\HandleExpiredGtfs;
use App\Models\Agency;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use MatanYadaev\EloquentSpatial\Objects\Point;

class JavascriptGtfsRtHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue = 'realtime-process';

    /**
     * Create a new job instance.
     */
    public function __construct(private Agency $agency, private int $time)
    {
    }

    private array $activeArray = [];

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Put all previously active vehicle as inactive
        $inactiveArray = Vehicle::where([
            ['is_active', true],
            ['agency_id', $this->agency->id],
        ])->select(['id', 'is_active'])->get();

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

        $vehiclesWithoutTrip = 0;

        // Go through each vehicle
        // Where not null to exclude alerts and trip updates
        $collection->whereNotNull('vehicle')->each(function ($entity) {
            /*
             * Check if entity has vehiclePosition or if is not valid
             */
            if (! $entity->vehicle || ! $entity->vehicle?->trip || ! $entity->vehicle?->position) {
                return;
            }
            $vehicle = $entity->vehicle;

            /*
             * Prepare a new array to update the vehicle model
             */
            $newVehicle = [
                'is_active' => true,
                'gtfs_trip_id' => $this->processField($vehicle->trip?->trip_id),
                'gtfs_route_id' => $this->processField($vehicle->trip?->route_id),
                'start_time' => $this->processField($vehicle->trip?->start_time),
                'schedule_relationship' => $this->processField($vehicle->trip?->schedule_relationship),
                'position' => $this->processField(['lat' => $vehicle->position?->latitude, 'lon' => $vehicle->position?->longitude], 'position'),
                'current_stop_sequence' => $this->processField($vehicle->current_stop_sequence),
                'current_status' => $this->processField($vehicle->current_status),
                'timestamp' => $this->processField($vehicle->timestamp->low ?? $this->time),
                'gtfs_stop_id' => $this->processField($vehicle->stop_id),
                'last_seen_at' => Carbon::parse($this->processField($vehicle->timestamp->low ?? $this->time)),
            ];

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

        // Update active information
        if ($inactiveArray->except($this->activeArray)->count() > 0) {
            $inactiveArray->except($this->activeArray)->toQuery()->update(['is_active' => false]);
        }

        // Replace timestamp
        $this->agency->timestamp = $this->time;
        $this->agency->save();

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => $count,
            'agency' => $this->agency->slug,
            'time' => $this->time,
        ];
        $stat->save();

        // Launch a notification if more than half of the vehicles don't have corresponding trip
        if ($count > 0 && ($vehiclesWithoutTrip / $count) > 0.5) {
            $action = new HandleExpiredGtfs($this->agency);
            $action->execute();
        }
    }

    private function processField($value, ?string $transformer = null)
    {
        if (! filled($value)) {
            return null;
        }

        if ($transformer === 'label' && in_array($this->agency->slug, ['go', 'up', 'la', 'vr', 'lr', 'lasso', 'sju', 'so', 'hsl', 'pi', 'rous', 'sv', 'tm', 'crc'])) {
            return null;
        }

        if ($transformer === 'position' && filled($value['lat']) && filled($value['lat'])) {
            return new Point(round($value['lat'], 5), round($value['lon'], 5));
        }

        return $value;
    }
}
