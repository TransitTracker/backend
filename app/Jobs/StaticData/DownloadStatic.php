<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use GuzzleHttp\Client;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadStatic implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Agency $agency, private array $files = [
        'calendar.txt',
        'routes.txt',
        'stops.txt',
        'stop_times.txt',
        'trips.txt',
        'shapes.txt',
    ])
    {
    }

    public function handle(): void
    {
        // Set path
        $cwd = getcwd();
        $time = time();
        $fileName = "{$cwd}/storage/app/static/{$this->agency->slug}-{$time}.zip";

        // Download GTFS
        $client = new Client();
        $headers = filled($this->agency->static_etag) ? ['If-None-Match' => $this->agency->static_etag] : [];
        $response = $client->get($this->agency->static_gtfs_url, [
            'sink' => $fileName,
            'headers' => $headers,
            'verify' => $this->agency->slug === 'stm' ? false : true,
        ]);

        if ($response->hasHeader('ETag')) {
            $this->agency->static_etag = $response->getHeader('ETag')[0];
            $this->agency->saveQuietly();
        }

        if ($response->getStatusCode() === 304) {
            // 304 = same data
            // Do not continue

            $client = null;

            $this->batch()->cancel();

            return;
        }

        // Dispatch extraction
        $this->batch()->add([new ExtractAndDispatchStaticGtfs($this->agency, $fileName, $this->files)]);

        // Erase client
        $client = null;

        return;
    }
}
