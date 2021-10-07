<?php

namespace App\Jobs\RealtimeData;

use App\Actions\HandleExpiredRealtimeData;
use App\Models\Agency;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckTimestamps implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $agenciesToCheck = Agency::where('refresh_is_active', true)->where('is_active', true)->get();

        foreach ($agenciesToCheck as $agency) {
            if (now()->subMinutes(3)->isBefore(Carbon::parse($agency->timestamp))) {
                continue;
            }

            $action = new HandleExpiredRealtimeData($agency);
            $action->execute();
        }
    }
}
