<?php

namespace App\Jobs;

use App\Models\Alert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAlertsStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $alerts = Alert::whereNotNull('new_status')->get();

        $alerts->each(function (Alert $alert) {
            // Only process change due today
            if (! $alert->new_status_date->isToday()) {
                return;
            }

            $alert->status = $alert->new_status;
            $alert->new_status = null;
            $alert->new_status_date = null;
            $alert->save();
        });
    }
}
