<?php

namespace App\Console\Commands;

use App\Agency;
use App\Jobs\RefreshForNextbus;
use GuzzleHttp\Client;
use App\Jobs\RefreshForGTFS;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class QueueActiveAgencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agency:refresh-actives';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will refresh all active agencies vehicles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all agencies
        $agencies = Agency::where('is_active', 1)->get();

        // Get time
        $time = time();

        // Create client
        $client = new Client();

        // Run each agency
        foreach ($agencies as $agency) {
            try {
                $requestOptions = [];

                // Add header to options (if one)
                if ($agency->header_name) {
                    $headerArray = [
                        $agency->header_name => $agency->header_value
                    ];
                    $requestOptions['headers'] = $headerArray;
                }

                // Add query parameters to options (if one)
                if ($agency->param_name) {
                    $headerQuery = [
                        $agency->param_name => $agency->param_value
                    ];
                    $requestOptions['query'] = $headerQuery;
                }

                $response = $client->request($agency->realtime_method, $agency->realtime_url, $requestOptions);

                if ($response->getStatusCode() !== 200) {
                    break;
                }

                $fileName = $agency->slug . '-' . $time . '.pb';
                Storage::put($fileName, (string) $response->getBody());

                if ($agency->realtime_type === 'gtfsrt') {
                    RefreshForGTFS::dispatch($agency, $fileName, $time)->onQueue('vehicles');
                }

                if ($agency->realtime_type === 'nextbus') {
                    RefreshForNextbus::dispatch($agency, $fileName, $time)->onQueue('vehicles');
                }
            } catch (\Exception $e) {
                report($e);
            }
        }

        $client = null;
    }

    // Todo: send email if fails
}
