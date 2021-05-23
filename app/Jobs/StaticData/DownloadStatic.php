<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class DownloadStatic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

            return;
        }

        // Dispatch extraction
        Bus::batch([
            new ExtractAndDispatchStaticGtfs($this->agency, $fileName),
        ])->onQueue('gtfs')->name("{$this->agency->slug} GTFS refresh {$time}")->dispatch();

        // Erase client
        $client = null;
    }
}
