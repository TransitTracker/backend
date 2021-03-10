<?php

namespace App\Jobs;

use App\Actions\HandleFailedDispatch;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DispatchAgencies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Collection
     */
    public Collection $agencies;

    /**
     * Create a new job instance.
     *
     * @param Collection $agencies
     */
    public function __construct(Collection $agencies)
    {
        $this->agencies = $agencies;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get the time
        $time = time();

        // Create client
        $client = new Client();

        // Run through each agency id
        foreach ($this->agencies as $agency) {
            try {
                $requestOptions = [];
                $requestOptions['timeout'] = 10;

                // Add header to options (if one)
                if ($agency->header_name) {
                    $headerArray = [
                        $agency->header_name => $agency->header_value,
                    ];
                    $requestOptions['headers'] = $headerArray;
                }

                // Add query parameters to options (if one)
                if ($agency->param_name) {
                    $headerQuery = [
                        $agency->param_name => $agency->param_value,
                    ];
                    $requestOptions['query'] = $headerQuery;
                }

                // TODO: Improve custom download calls, maybe using manager?
                // Realtime url for STO
                $downloadUrl = $agency->realtime_url;
                if ($agency->download_method === 'sto') {
                    // Remove the parameters
                    $requestOptions = [];
                    $stoSecret = $agency->header_value;

                    $dateUtc = now()->setTimezone('UTC');
                    $dateIso = "{$dateUtc->format('Ymd')}T{$dateUtc->format('Hi')}Z";
                    $stoHash  = strtoupper(hash('sha256', "{$stoSecret}{$dateIso}"));
                    $downloadUrl = "{$agency->realtime_url}&hash={$stoHash}";
                    info($downloadUrl);
                }

                $response = $client->request($agency->realtime_method, $downloadUrl, $requestOptions);

                $fileName = 'downloads/'.$agency->slug.'-'.$time.'.pb';
                Storage::put($fileName, (string) $response->getBody());

                if ($agency->realtime_type === 'gtfsrt') {
                    RefreshForGTFS::dispatch($agency, $fileName, $time)->onQueue('vehicles');
                }

                if ($agency->realtime_type === 'nextbus') {
                    RefreshForNextbus::dispatch($agency, $fileName, $time)->onQueue('vehicles');
                }
            } catch (RequestException $e) {
               $action = new HandleFailedDispatch($e, $agency);
               $action->execute();
            }
        }

        // Empty client
        $client = null;
    }
}
