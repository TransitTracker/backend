<?php

namespace App\Jobs;

use App\Models\Agency;
use App\Models\Service;
use App\Models\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CleanGtfsData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     */
    public function __construct(private Agency $agency)
    {
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
