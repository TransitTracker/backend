<?php

namespace App\Jobs;

use App\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;

class ExtractAndDispatchGtfs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $agency;
    private $zipFile;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param string $zipFile
     */
    public function __construct(Agency $agency, string $zipFile)
    {
        $this->agency = $agency;
        $this->zipFile = $zipFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $zip = new ZipArchive();
        $file = $zip->open($this->zipFile);

        if ($file) {
            // Set extract folder
            $extractFolder = getcwd() . '/storage/app/gtfs/' . $this->agency->slug . '-' . time();
            mkdir($extractFolder);

            // Extract and dispatch services
            $services = $zip->getFromName('calendar.txt');
            file_put_contents($extractFolder . '/calendar.txt', $services);
            ProcessGtfsServices::dispatch($this->agency, $extractFolder . '/calendar.txt')->onQueue('gtfs');

            // Open and dispatch routes
            $routes = $zip->getFromName('routes.txt');
            file_put_contents($extractFolder . '/routes.txt', $routes);
            ProcessGtfsRoutes::dispatch($this->agency, $extractFolder . '/routes.txt')->onQueue('gtfs');

            // Open and dispatch trips
            $trips = $zip->getFromName('trips.txt');
            file_put_contents($extractFolder . '/trips.txt', $trips);
            ProcessGtfsTrips::dispatch($this->agency, $extractFolder . '/trips.txt')->onQueue('gtfs');

            $zip->close();
        }

        $zip = null;
    }
}
