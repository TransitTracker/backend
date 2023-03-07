<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Gtfs\Stop;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use League\Csv\Reader;
use MatanYadaev\EloquentSpatial\Objects\Point;

class ProcessGtfsStops implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Agency $agency, private string $file)
    {
    }

    public function handle()
    {
        // Remove old stops
        Stop::whereAgencyId($this->agency->id)->delete();

        $stopsReader = Reader::createFromPath($this->file)->setHeaderOffset(0);

        $stopsToUpdate = [];

        foreach ($stopsReader->getRecords() as $stop) {
            // Prepare a new array to update or create the stop model
            $newStop = [];

            if (! array_key_exists('stop_id', $stop)) {
                continue;
            }

            // Fill each required attribute
            $newStop['gtfs_stop_id'] = $stop['stop_id'];
            $newStop['code'] = $stop['stop_code'];
            $newStop['name'] = $stop['stop_name'];
            if (filled($stop['stop_lat']) && filled($stop['stop_lon'])) {
                $newStop['position'] = new Point((float) $stop['stop_lat'], (float) $stop['stop_lon']);
            } else {
                $newStop['position'] = null;
            }

            array_push($stopsToUpdate, $newStop);
        }

        collect($stopsToUpdate)->chunk(1000)->each(function (Collection $chunk) {
            $this->agency->stops()->createMany($chunk->all());
        });

        $stopsReader = null;
    }
}
