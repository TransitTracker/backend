<?php

namespace App\Console\Commands\RealtimeData;

use App\Jobs\RealtimeData\DispatchAgency;
use App\Models\Agency;
use Illuminate\Console\Command;

class Update extends Command
{
    protected $signature = 'realtime:update {agency? : The slug of the agency} {--f|force : Force the refresh (ignore Cron and refresh_is_active)}';

    protected $description = 'Update the realtime data of all agencies or the specified agency';

    public function handle()
    {
        $forceRefresh = $this->option('force');

        // Start the query
        $agencies = Agency::query();

        // Only include active agencies if refresh not forced
        if (! $forceRefresh) {
            $agencies->where(['is_active' => true, 'refresh_is_active' => true]);
        }

        // Search for a particular agency if specified
        if ($agencySlug = $this->argument('agency')) {
            $agencies->where('slug', $agencySlug);
        }

        $results = $agencies->get();

        // Throw error if no agency has been found
        if (! $results->count()) {
            $this->error("Unknown agency {$agencySlug}");

            return Command::FAILURE;
        }

        foreach ($results as $agency) {
            DispatchAgency::dispatch($agency, $forceRefresh);
        }

        $this->newLine();
        $this->info("Refresh launched for {$agencies->count()} agencies!");

        return Command::SUCCESS;
    }
}
