<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Trip;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
use ZipArchive;

class ExtractAndDispatchStaticGtfs implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Agency $agency;
    private string $zipFile;

    public function __construct(Agency $agency, string $zipFile)
    {
        $this->agency = $agency;
        $this->zipFile = $zipFile;
    }

    public function handle()
    {
        // Open (will only unzip needed files)
        $zip = new ZipArchive();
        $file = $zip->open($this->zipFile);

        if (! $file) {
            return false;
        }

        // Set and create extract folder
        $cwd = getcwd();
        $time = time();
        $extractFolder = "{$cwd}/storage/app/static/{$this->agency->slug}-{$time}";
        mkdir($extractFolder);

        // Extract and dispatch services
        // If there is no calendar file, create an empty file.
        $services = $zip->getFromName('calendar.txt');
        if ($services) {
            file_put_contents($extractFolder.'/calendar.txt', $services);

            $this->batch()->add([
                new ProcessGtfsServices($this->agency, "{$extractFolder}/calendar.txt"),
            ]);
        } else {
            $this->batch()->add([
                new ProcessGtfsServices($this->agency, false),
            ]);
        }

        // Open and dispatch routes
        $routes = $zip->getFromName('routes.txt');
        file_put_contents($extractFolder.'/routes.txt', $routes);

        $this->batch()->add([
            new ProcessGtfsRoutes($this->agency, "{$extractFolder}/routes.txt"),
        ]);

        // Remove old trips
        Trip::whereAgencyId($this->agency->id)->delete();

        // Open and dispatch trips
        $trips = $zip->getFromName('trips.txt');
        file_put_contents($extractFolder.'/trips.txt', $trips);
        $tripsReader = Reader::createFromPath($extractFolder.'/trips.txt')->setHeaderOffset(0);

        // Make sure there is never more than 50000 trips per job
        $numberOfTripsStatement = ceil(count($tripsReader) / 50000);

        for ($i = 0; $i <= $numberOfTripsStatement - 1; $i++) {
            $this->batch()->add([
                new ProcessGtfsTrips($this->agency, "{$extractFolder}/trips.txt", $i * 50000),
            ]);
        }

        // Open and dispatch shapes (if any)
        $shapes = $zip->getFromName('shapes.txt');

        if ($shapes) {
            file_put_contents("{$extractFolder}/shapes.txt", $shapes);

            $this->batch()->add([
                new ProcessGtfsShapes($this->agency, "{$extractFolder}/shapes.txt"),
            ]);
        }

        $zip->close();

        $zip = null;
    }
}
