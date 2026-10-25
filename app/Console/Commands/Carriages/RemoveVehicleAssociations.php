<?php

namespace App\Console\Commands\Carriages;

use App\Models\Agency;
use App\Models\Carriage;
use Illuminate\Console\Command;

class RemoveVehicleAssociations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carriages:remove-vehicle-associations
                            {--agency= : Filter by agency slug or ID}
                            {--dry-run : Simulate the command without removing associations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all associations between carriages and vehicles';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $query = Carriage::query()->whereNotNull('vehicle_id');

        if ($agencyInput = $this->option('agency')) {
            $agency = is_numeric($agencyInput)
                ? Agency::find($agencyInput)
                : Agency::where('slug', $agencyInput)->first();

            if (! $agency) {
                $this->error("Agency [{$agencyInput}] not found.");

                return Command::FAILURE;
            }

            $query->where('agency_id', $agency->id);
        }

        $count = $query->count();

        if ($count === 0) {
            $this->info('No carriages associated with vehicles found.');

            return Command::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->warn("Found {$count} carriage(s) associated with vehicles.");
            $this->info('Dry run: no associations were removed.');

            return Command::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm("Are you sure you want to remove vehicle associations for {$count} carriage(s)?", true)) {
            $this->warn('Operation cancelled.');

            return Command::SUCCESS;
        }

        $query->update([
            'vehicle_id' => null,
        ]);

        $this->info("Successfully removed vehicle associations from {$count} carriage(s).");

        return Command::SUCCESS;
    }
}
