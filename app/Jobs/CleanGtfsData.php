<?php

namespace App\Jobs;

use App\Agency;
use App\Service;
use App\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CleanGtfsData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $agency;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     */
    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Find expired services
        $oldServices = Service::where([['agency_id', $this->agency->id], ['end_date', '<', now()]])->get();

        // Delete all expired trips
        foreach ($oldServices as $oldService) {
            Trip::where('service_id', $oldService->id)->delete();
            $oldService->delete();
        }
    }
}
