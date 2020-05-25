<?php

namespace App\Jobs;

use App\Agency;
use App\Service;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;

class ProcessGtfsServices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Agency $agency;
    private string $file;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param string $file
     */
    public function __construct(Agency $agency, string $file)
    {
        $this->agency = $agency;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $servicesReader = Reader::createFromPath($this->file)->setHeaderOffset(0);
        foreach ($servicesReader->getRecords() as $service) {
            // If the service is already finish, don't add it
            if (Carbon::create($service['end_date'])->isPast()) {
                break;
            }

            // Prepare a new array to update or create the service model
            $newService = [];

            // Fill each required attribute
            $newService['service_id'] = $service['service_id'];
            $startDate = new Carbon($service['start_date']);
            $newService['start_date'] = $startDate;
            $endDate = new Carbon($service['end_date']);
            $newService['end_date'] = $endDate;

            // Create or update the service model
            Service::updateOrCreate(['service_id' => $service['service_id'], 'agency_id' => $this->agency->id], $newService);
        }
        $servicesReader = null;
    }
}
