<?php

namespace App\Jobs;

use App\Agency;
use App\Events\VehiclesUpdated;
use App\FailedJobsHistory;
use App\Mail\RefreshFailed;
use App\Stat;
use App\Vehicle;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\ResponseCache\Facades\ResponseCache;

class RefreshForNextbus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Agency $agency;
    private string $dataFile;
    private int $time;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param string $dataFile
     * @param int $time
     */
    public function __construct(Agency $agency, $dataFile, $time)
    {
        $this->agency = $agency;
        $this->dataFile = $dataFile;
        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        // Put all previously active vehicle as inactive
        Vehicle::where([
            ['active', true],
            ['agency_id', $this->agency->id],
        ])->update(
            ['active' => false]
        );

        $data = Storage::get($this->dataFile);

        // Convert XML to PHP object
        $xml = simplexml_load_string($data);

        // Go trough each vehicle
        foreach ($xml->vehicle as $vehicle) {
            /*
             * Prepare a new array to update the vehicle model
             */
            $newVehicle = [];
            $newVehicle['active'] = 1;

            /*
             * Try each GTFS RT attribute
             */

            // Latitude
            if ($vehicle['lat']) {
                $newVehicle['lat'] = round($vehicle['lat'], 5);
            }

            // Longitude
            if ($vehicle['lon']) {
                $newVehicle['lon'] = round($vehicle['lon'], 5);
            }

            // Route
            if ($vehicle['routeTag']) {
                $newVehicle['route'] = $vehicle['routeTag'];
            }

            // Bearing
            if ($vehicle['heading']) {
                $newVehicle['bearing'] = $vehicle['heading'];
            }

            // Speed
            if ($vehicle['speedKmHr']) {
                $newVehicle['speed'] = $vehicle['speedKmHr'];
            }

            /*
             * Check if vehicle is recent, then create or update the vehicle model
             */
            if ($vehicle['secsSinceReport'] < 180) {
                Vehicle::updateOrCreate(['vehicle' => $vehicle['id'], 'agency_id' => $this->agency->id], $newVehicle);
            }
        }

        // Replace timestamp
        $this->agency->timestamp = (int) floor($xml->lastTime['time'] / 1000);
        $this->agency->save();

        // Send a new event to alert browser that vehicles have been refresh
        ResponseCache::clear();
        event(new VehiclesUpdated($this->agency));

        // Add statistics
        $stat = new Stat();
        $stat->type = 'vehicleTotal';
        $stat->data = (object) [
            'count' => count($xml->vehicle),
            'agency' => $this->agency->slug,
            'time' => $this->time,
        ];
        $stat->save();

        // Delete the file
        Storage::delete($this->dataFile);
    }

    /**
     * The job failed to process.
     *
     * @param $exception
     * @return void
     */
    public function failed($exception)
    {
        $className = get_class($this);

        $lastFailedJob = FailedJobsHistory::firstWhere([
            'name' => $className,
            'exception' => $exception->getMessage(),
            'agency_id' => $this->agency->id,
        ]);

        if ($lastFailedJob) {
            // last failed job exists in database
            if (Carbon::now()->diffInMinutes($lastFailedJob->last_failed) > 30) {
                // last failed job is more than 30 minutes ago
                Mail::to(env('MAIL_TO'))->send(new RefreshFailed($exception, $this->agency->slug, $className));
                $lastFailedJob->update([
                    'last_failed' => Carbon::now(),
                ]);
            }
        } else {
            // no last failed job
            Mail::to(env('MAIL_TO'))->send(new RefreshFailed($exception, $this->agency->slug, $className));
            FailedJobsHistory::create([
                'name' => $className,
                'exception' => $exception->getMessage(),
                'agency_id' => $this->agency->id,
                'last_failed' => Carbon::now(),
            ]);
        }

        // Delete the file
        Storage::delete($this->dataFile);
    }
}
