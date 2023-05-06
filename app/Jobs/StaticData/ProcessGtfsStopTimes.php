<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Gtfs\StopTime;
use App\Models\Gtfs\Trip;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class ProcessGtfsStopTimes implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Agency $agency, private string $file, private int $offset = 0)
    {
    }

    public function handle(): void
    {
        $supportsBlocks = (bool) Trip::where('agency_id', $this->agency->id)->whereNotNull('gtfs_block_id')->count();
        $tripIdToImport = Trip::select(['gtfs_shape_id', DB::raw('MIN(gtfs_trip_id) as gtfs_trip_id')])->where('agency_id', $this->agency->id)->groupBy('gtfs_shape_id')->pluck('gtfs_trip_id');

        $reader = Reader::createFromPath($this->file)->setHeaderOffset(0);
        $statement = (new Statement())
            ->offset($this->offset)
            ->limit(100_000);

        $toCreate = [];

        foreach ($statement->process($reader) as $record) {
            // If there is no trip_id or arrival_time, skip
            if (! Arr::exists($record, 'trip_id') || ! Arr::exists($record, 'arrival_time')) {
                continue;
            }

            $shouldNotImportThisTrip = $tripIdToImport->doesntContain($record['trip_id']);

            // For agencies that do not support blocks, only import StopTimes for one trip per shape
            // of for agencies that do support blocks, import first StopTimes for all trip (normally 1, or 0 for some special agencies...)
            if (
                (! $supportsBlocks && $shouldNotImportThisTrip) ||
                ($supportsBlocks && $shouldNotImportThisTrip && $record['stop_sequence'] !== '0' && $record['stop_sequence'] !== '1')
            ) {
                continue;
            }

            $toCreate[] = [
                'agency_id' => $this->agency->id,
                'gtfs_trip_id' => $record['trip_id'],
                'gtfs_stop_id' => $record['stop_id'],
                'departure' => $record['departure_time'],
                'sequence' => (int) $record['stop_sequence'],
            ];
        }

        collect($toCreate)->chunk(500)->each(function (Collection $chunk) {
            info('Chunk of '.$chunk->count());
            StopTime::upsert($chunk->all(), ['agency_id', 'gtfs_trip_id', 'sequence'], ['gtfs_stop_id', 'departure']);
        });

        $reader = null;
    }
}
