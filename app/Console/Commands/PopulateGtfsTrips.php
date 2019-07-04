<?php

namespace App\Console\Commands;

use App\Agency;
use App\Jobs\PopulateTrip;
use Illuminate\Console\Command;
use League\Csv\Reader;

class PopulateGtfsTrips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gtfs:addtrips {agency} {file} {expiration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add GTFS trips to the database from CSV file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Filter GTFS CSV to remove unused column.
     */
    private function filterUnusedColumns($row)
    {
        unset($row['service_id']);
        unset($row['direction_id']);
        unset($row['shape_id']);
        unset($row['weelchair_accessible']);
        unset($row['note_fr']);
        unset($row['note_en']);
        return $row;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $agency = Agency::where('slug' ,$this->argument('agency'))->firstOrFail();
        $filePath = $this->argument('file');

        $reader = Reader::createFromPath(getcwd() . '/' . $filePath, 'r')->setHeaderOffset(0);

        if ($this->confirm('Do you want to continue? This will add ' . count($reader) . ' trips to the database.')) {
            foreach ($reader->getRecords() as $csvTrip) {
                PopulateTrip::dispatch($csvTrip, $agency, $this->argument('expiration'))->onQueue('gtfs');
            }
            $this->info('Successful! ' . count($reader) . ' trips are being added for ' . $agency->name);
        } else {
            $this->error('Sorry!');
        }

    }
}
