<?php

namespace App\Jobs;

use App\Agency;
use App\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessGtfsService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $agency;
    private $service;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param $service
     */
    public function __construct(Agency $agency, $service)
    {
        $this->agency = $agency;
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Prepare a new array to update or create the service model
        $newService = [];

        // Fill each required attribute
        $newService['service_id'] = $this->service['service_id'];
        $newService['start_date'] = $this->service['start_date'];
        $newService['end_date'] = $this->service['end_date'];

        // Create or update the route model
        Service::updateOrCreate(['service_id' => $this->service['service_id'], 'agency_id' => $this->agency->id], $newService);
    }
}
