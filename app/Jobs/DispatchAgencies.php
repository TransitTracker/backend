<?php

namespace App\Jobs;

use App\FailedJobsHistory;
use App\Mail\DispatchFailed;
use App\Mail\JobFailed;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
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
            } catch (Exception $e) {
                $className = get_class($this);

                $lastFailedJob = FailedJobsHistory::firstWhere([
                    'name' => $className,
                    'exception' => $e->getMessage(),
                    'agency_id' => $agency->id,
                ]);

                if ($lastFailedJob) {
                    // last failed job exists in database
                    if (Carbon::now()->diffInMinutes($lastFailedJob->last_failed) > 30) {
                        // last failed job is more than 30 minutes ago
                        Mail::to(env('MAIL_TO'))->send(new DispatchFailed($e, $agency->slug));
                        $lastFailedJob->update([
                            'last_failed' => Carbon::now()
                        ]);
                    }
                } else {
                    // no last failed job
                    Mail::to(env('MAIL_TO'))->send(new DispatchFailed($e, $agency->slug));
                    FailedJobsHistory::create([
                        'name' => $className,
                        'exception' => $e->getCode(),
                        'agency_id' => $agency->id,
                        'last_failed' => Carbon::now()
                    ]);
                }
            }
        }

        // Empty client
        $client = null;
    }

    /**
     * The job failed to process.
     *
     * @param $exception
     * @return void
     */
    public function failed($exception)
    {
        $className = get_class($this);

        $lastFailedJob = FailedJobsHistory::firstWhere([
            'name' => $className,
            'exception' => $exception->getMessage()
        ]);

        if ($lastFailedJob) {
            // last failed job exists in database
            if (Carbon::now()->diffInMinutes($lastFailedJob->last_failed) > 30) {
                // last failed job is more than 30 minutes ago
                Mail::to(env('MAIL_TO'))->send(new JobFailed($className, $exception));
                $lastFailedJob->update([
                    'last_failed' => Carbon::now()
                ]);
            }
        } else {
            // no last failed job
            Mail::to(env('MAIL_TO'))->send(new JobFailed($className, $exception));
            FailedJobsHistory::create([
                'name' => $className,
                'exception' => $exception->getMessage(),
                'last_failed' => Carbon::now()
            ]);
        }
    }
}
