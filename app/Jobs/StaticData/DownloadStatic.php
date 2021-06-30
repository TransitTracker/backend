<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\User;
use App\Notifications\StaticDataUpdated;
use GuzzleHttp\Client;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;

class DownloadStatic implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Agency $agency;

    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }

    public function handle()
    {
        // Set path
        $cwd = getcwd();
        $time = time();
        $fileName = "{$cwd}/storage/app/static/{$this->agency->slug}-{$time}.zip";

        // Download GTFS
        $client = new Client();
        $response = $client->get($this->agency->static_gtfs_url, ['sink' => $fileName, 'headers' => [
            'If-None-Match' => $this->agency->static_etag,
        ]]);

        if ($response->hasHeader('ETag')) {
            $this->agency->static_etag = $response->getHeader('ETag')[0];
            $this->agency->saveQuietly();
        }

        if ($response->getStatusCode() === 304) {
            // 304 = same data
            // Do not continue

            $client = null;

            return $this->batch()->cancel();
        }

        // Dispatch extraction
        $this->batch()->add(new ExtractAndDispatchStaticGtfs($this->agency, $fileName));

        // Erase client
        $client = null;
    }
}
