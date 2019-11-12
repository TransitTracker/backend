<?php

namespace App\Jobs;

use App\Agency;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class DownloadGTFS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $agency;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     */
    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Download GTFS
        $client = new Client();
        $response = $client->get($this->agency->static_gtfs_url);

        if ($response->getStatusCode() !== 200) {
            // Todo: send email
        }

        // Save ZIP to storage
        $fileName = 'gtfs/' . $this->agency->slug . '-' . time() . '.zip';
        Storage::put($fileName, $response->getBody());

        ExtractAndDispatchGtfs::dispatch($this->agency, $fileName)->onQueue('gtfs');
    }
}
