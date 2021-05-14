<?php

namespace App\Jobs;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
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
            $extractFolder = getcwd().'/storage/app/gtfs/'.$this->agency->slug.'-'.time();
            mkdir($extractFolder);

            // Extract and dispatch services
            // If there is no calendar file, create an empty file.
            $services = $zip->getFromName('calendar.txt');
            if ($services) {
                file_put_contents($extractFolder.'/calendar.txt', "$services");
                ProcessGtfsServices::dispatch($this->agency, $extractFolder.'/calendar.txt')->onQueue('gtfs');
            } else {
                ProcessGtfsServices::dispatch($this->agency, false)->onQueue('gtfs');
            }

            // Open and dispatch routes
            $routes = $zip->getFromName('routes.txt');
            file_put_contents($extractFolder.'/routes.txt', $routes);
            ProcessGtfsRoutes::dispatch($this->agency, $extractFolder.'/routes.txt')->onQueue('gtfs');

            // Open and dispatch trips
            $trips = $zip->getFromName('trips.txt');
            file_put_contents($extractFolder.'/trips.txt', $trips);
            $tripsReader = Reader::createFromPath($extractFolder.'/trips.txt')->setHeaderOffset(0);
            // Make sure there is never more than 50000 trips per job
            $numberOfTripsStatement = ceil(count($tripsReader) / 4500);
            for ($i = 0; $i <= $numberOfTripsStatement - 1; $i++) {
                ProcessGtfsTrips::dispatch($this->agency, $extractFolder.'/trips.txt', $i * 50000)->onQueue('gtfs');
            }

            // Open and dispatch shapes (if any)
            $shapes = $zip->getFromName('shapes.txt');
            if ($shapes) {
                file_put_contents("{$extractFolder}/shapes.txt", $shapes);
                ProcessGtfsShapes::dispatch($this->agency, "{$extractFolder}/shapes.txt")->onQueue('gtfs');
            }

            $zip->close();
        }

        $zip = null;
    }
}
