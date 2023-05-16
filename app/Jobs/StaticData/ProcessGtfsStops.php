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
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use League\Csv\Reader;
use MatanYadaev\EloquentSpatial\Objects\Point;

class ProcessGtfsStops implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Agency $agency, private string $file)
    {
    }

    public function handle(): void
    {
        // Remove old stops
        Stop::whereAgencyId($this->agency->id)->delete();

        $stopsReader = Reader::createFromPath($this->file)->setHeaderOffset(0);

        $stopsToUpdate = [];

        foreach ($stopsReader->getRecords() as $stop) {
            if (! array_key_exists('stop_id', $stop)) {
                continue;
            }

            $stopsToUpdate[] = [
                'agency_id' => $this->agency->id,
                'gtfs_stop_id' => $stop['stop_id'],
                'code' => $this->getValue($stop, 'stop_code'),
                'name' => $this->getValue($stop, 'stop_name'),
                'position' => $this->getPosition($stop),
            ];
        }

        collect($stopsToUpdate)->chunk(1000)->each(function (Collection $chunk) {
            $this->agency->stops()->createMany($chunk->all());
        });

        $stopsReader = null;
    }

    private function getPosition(array $stop): Point|null
    {
        if (! filled($stop['stop_lat']) || ! filled($stop['stop_lon'])) {
            return null;
        }

        return new Point((float) $stop['stop_lat'], (float) $stop['stop_lon']);
    }

    private function getValue(array $stop, string $field)
    {
        if (! Arr::exists($stop, $field) || filled($stop[$field])) {
            return null;
        }

        return $stop[$field];
    }
}
