<?php

namespace App\Console\Commands\StaticData;

use App\Jobs\StaticData\DownloadStatic;
use App\Models\Agency;
use App\Models\User;
use App\Notifications\StaticDataUpdated;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;

class Update extends Command
{
    protected $signature = 'static:update {agency? : The slug of the agency}';

    protected $description = 'Update the static data of all agencies or the specified agency';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if ($agencySlug = $this->argument('agency')) {
            $agency = Agency::where('slug', $agencySlug)->firstOrFail();

            $this->createBatch($agency);

            return $this->info("Updating {$agency->short_name}");
        }

        foreach (Agency::all() as $agency) {
            // Agency without etag will only update on sunday
            if (! $agency->static_etag && ! now()->isSunday()) {
                $this->line("skipping {$agency->short_name}");
                continue;
            }

            $this->createBatch($agency);
        }

        $this->newLine();
        $this->info('Refresh launched!');
    }

    private function createBatch(Agency $agency)
    {
        $time = now()->toDateString();

        Bus::batch([
            new DownloadStatic($agency),
        ])
            ->onQueue('gtfs')
            ->name("{$agency->short_name} static refresh {$time}")
            ->finally(function (Batch $batch) use ($agency) {
                if ($batch->cancelled()) {
                    return;
                }

                Notification::send([User::first()], new StaticDataUpdated($agency));
            })
            ->dispatch();
    }
}
