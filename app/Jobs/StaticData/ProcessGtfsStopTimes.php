<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use League\Csv\Reader;
use League\Csv\Statement;

class ProcessGtfsStopTimes implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Agency $agency, private string $file, private int $offset = 0)
    {
    }

    public function handle()
    {
        $reader = Reader::createFromPath($this->file)->setHeaderOffset(0);
        $statement = (new Statement())
            ->offset($this->offset)
            ->limit(50000);

        $toCreate = [];

        foreach ($statement->process($reader) as $record) {
            // If there is no trip_id or arrival_time, skip
            if (! Arr::exists($record, 'trip_id') || ! Arr::exists($record, 'arrival_time')) {
                continue;
            }

            array_push($toCreate, [
                'gtfs_trip_id' => $record['trip_id'],
                'gtfs_stop_id' => $record['stop_id'],
                'departure' => $record['departure_time'],
                'sequence' => $record['stop_sequence'],
            ]);
        }

        collect($toCreate)->chunk(1000)->each(function (Collection $chunk) {
            $this->agency->stopTimes()->createMany($chunk->all());
        });

        $reader = null;
    }
}
