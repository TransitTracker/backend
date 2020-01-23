<?php

namespace App\Console\Commands;

use App\Agency;
use App\Jobs\RefreshForGTFS;
use App\Jobs\RefreshForNextbus;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class QueueAgency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agency:refresh {agency}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will refresh the specified agency vehicles';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        // Get all agencies
        $agency = Agency::where('slug', $this->argument('agency'))->first();

        // Get time
        $time = time();

        // Create client
        $client = new Client();

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

        $fileName = 'downloads/' . $agency->slug . '-' . $time . '.pb';
        Storage::put($fileName, (string) $response->getBody());

        if ($agency->realtime_type === 'gtfsrt') {
            RefreshForGTFS::dispatch($agency, $fileName, $time)->onQueue('vehicles');
        }

        if ($agency->realtime_type === 'nextbus') {
            RefreshForNextbus::dispatch($agency, $fileName, $time)->onQueue('vehicles');
        }
    }
}
