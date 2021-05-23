<?php

namespace App\Jobs\RealtimeData;

use App\Actions\HandleFailedDispatch;
use Cron\CronExpression;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
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
        $client = new Client([
            'connect_timeout' => 3,
            'read_timeout' => 10,
            'timeout' => 10,
        ]);

        // Run through each agency id
        foreach ($this->agencies as $agency) {
            try {
                // Check if this agency should run now
                $cron = new CronExpression($agency->cron_schedule);
                if (! $cron->isDue()) {
                    continue;
                }

                $requestOptions = [];

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
                    $stoHash = strtoupper(hash('sha256', "{$stoSecret}{$dateIso}"));
                    $downloadUrl = "{$agency->realtime_url}&hash={$stoHash}";
                }

                $response = $client->request($agency->realtime_method, $downloadUrl, $requestOptions);

                $fileName = "downloads/{$agency->slug}-{$time}";
                Storage::put($fileName, (string) $response->getBody());
                Storage::put("feeds/{$agency->slug}", (string) $response->getBody());

                if ($agency->realtime_type === 'gtfsrt') {
                    GtfsRtHandler::dispatch($agency, $fileName, $time)->onQueue('vehicles');
                }

                if ($agency->realtime_type === 'nextbus') {
                    NextbusXmlHandler::dispatch($agency, $fileName, $time)->onQueue('vehicles');
                }

                if ($agency->realtime_type === 'nextbus-json') {
                    NextbusJsonHandler::dispatch($agency, $fileName, $time)->onQueue('vehicles');
                }
            } catch (RequestException $e) {
                $action = new HandleFailedDispatch($e, $agency);
                $action->execute();
            } catch (ConnectException $e) {
            }
        }

        // Empty client
        $client = null;
    }
}
