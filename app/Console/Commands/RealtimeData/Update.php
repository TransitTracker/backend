<?php

namespace App\Console\Commands\RealtimeData;

use App\Jobs\RealtimeData\DispatchAgencies;
use App\Models\Agency;
use Illuminate\Console\Command;

class Update extends Command
{
    protected $signature = 'realtime:update {agency? : The slug of the agency} {--f|force : Force the refresh (ignore Cron and refresh_is_active)}';

    protected $description = 'Update the realtime data of all agencies or the specified agency';

    public function handle()
    {
        $forceRefresh = $this->option('force');

        if ($agencySlug = $this->argument('agency')) {
            // Will always return only one (or zero) agencies, since slug is unique
            $agencies = Agency::where('slug', $agencySlug)->get();

            if ($agencies->count() !== 1) {
                $this->error("Unknown agency {$agencySlug}");

                return Command::FAILURE;
            }

            DispatchAgencies::dispatch($agencies, $forceRefresh)->onQueue('vehicles');

            $this->info("Updating {$agencies[0]->short_name}");

            return Command::SUCCESS;
        }

        $agencies = Agency::query();

        if (! $forceRefresh) {
            $agencies->where(['is_active' => true, 'refresh_is_active' => true]);
        }

        DispatchAgencies::dispatch($agencies->get(), $forceRefresh)->onQueue('vehicles');

        $this->newLine();
        $this->info("Refresh launched for {$agencies->count()} agencies!");

        return Command::SUCCESS;
    }
}
