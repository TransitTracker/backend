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
    protected $signature = 'static:update {agency? : The slug of the agency} {--f|force : Force the refresh, only works when agency is specified} {--s|select : Select which files to include}';

    protected $description = 'Update the static data of all agencies or the specified agency';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $files = [
            'calendar.txt',
            'routes.txt',
            'stops.txt',
            'stop_times.txt',
            'trips.txt',
            'shapes.txt',
        ];

        if ($this->option('select')) {
            $files = $this->choice('Please select the files to update', $files, null, null, true);
        }

        if ($agencySlug = $this->argument('agency')) {
            $agency = Agency::where('slug', $agencySlug)->firstOrFail();

            if ($this->option('force')) {
                $this->line('Removing latest etag to force download');
                // Reset etag to force download
                $agency->update(['static_etag' => '']);
            }

            $this->createBatch($agency, $files);

            $this->info("Updating {$agency->short_name}");

            return false;
        }

        foreach (Agency::all() as $agency) {
            // Agency without etag will only update on sunday
            if (! $agency->static_etag && ! now()->isSunday()) {
                $this->line("skipping {$agency->short_name}");

                continue;
            }

            $this->createBatch($agency, $files);
        }

        $this->newLine();
        $this->info('Refresh launched!');
    }

    private function createBatch(Agency $agency, array $files)
    {
        $time = now()->toDateString();

        Bus::batch([
            new DownloadStatic($agency, $files),
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
