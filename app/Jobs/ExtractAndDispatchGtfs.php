<?php

namespace App\Jobs;

use App\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

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
        $zip = new \ZipArchive();
        $file = $zip->open($this->zipFile);

        if ($file) {
            // Unzip file
            $extractFolder = getcwd() . '/storage/app/gtfs/' . $this->agency->slug . '-' . time();
            $zip->extractTo($extractFolder);
            $zip->close();

            // Open and dispatch routes
            $routesReader = Reader::createFromPath($extractFolder . '/routes.txt', 'r')->setHeaderOffset(0);
            foreach ($routesReader->getRecords() as $route) {
                ProcessGtfsRoute::dispatch($this->agency, $route)->onQueue('gtfs');
            }
            $routesReader = null;

            // Open and dispatch services
            $servicesReader = Reader::createFromPath($extractFolder . '/calendar.txt', 'r')->setHeaderOffset(0);
            foreach ($servicesReader->getRecords() as $service) {
                ProcessGtfsService::dispatch($this->agency, $service)->onQueue('gtfs');
            }
            $servicesReader = null;

            // Open and dispatch trips
            $tripsReader = Reader::createFromPath($extractFolder . '/trips.txt', 'r')->setHeaderOffset(0);
            foreach ($tripsReader->getRecords() as $trip) {
                ProcessGtfsTrip::dispatch($this->agency, $trip)->onQueue('gtfs')->delay(3);
            }
            $tripsReader = null;

            // Delete files
            array_map('unlink', glob($extractFolder . '/*.txt'));
            rmdir($extractFolder);
            Storage::delete($this->zipFile);
        }
    }
}
