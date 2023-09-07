<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Gtfs\Trip;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use League\Csv\Reader;
use League\Csv\Statement;

class ProcessGtfsTrips implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Agency $agency, private string $file, private int $offset = 0)
    {
    }

    public function handle(): void
    {
        $tripsReader = Reader::createFromPath($this->file)->setHeaderOffset(0);
        $tripsStatement = (new Statement())
            ->offset($this->offset)
            ->limit(25_000);
        $tripsRecords = $tripsStatement->process($tripsReader);

        $tripsToUpdate = [];

        foreach ($tripsRecords as $trip) {
            $tripsToUpdate[] = [
                'agency_id' => $this->agency->id,
                'gtfs_trip_id' => $trip['trip_id'],
                'gtfs_route_id' => $trip['route_id'],
                'gtfs_service_id' => $trip['service_id'],
                'gtfs_block_id' => $this->getField($trip, 'block_id'),
                'gtfs_shape_id' => $this->getField($trip, 'shape_id'),
                'headsign' => $this->getField($trip, 'trip_headsign'),
                'short_name' => $this->getField($trip, 'trip_short_name'),
            ];
        }

        collect($tripsToUpdate)->chunk(1000)->each(function (Collection $chunk) {
            Trip::upsert($chunk->all(), ['agency_id', 'gtfs_trip_id']);
        });

        $tripsReader = null;
    }

    private function getField(array $trip, string $field): ?string
    {
        if (! array_key_exists($field, $trip)) {
            return null;
        }

        // RTC short_name is included in the headsign
        if ($field === 'trip_short_name' && $this->agency->slug === 'rtc') {
            return null;
        }

        // Support for trip_direction_headsign
        if ($field === 'trip_headsign' && array_key_exists('trip_direction_headsign', $trip)) {
            return "{$trip['trip_direction_headsign']} ({$trip['trip_headsign']})";
        }

        // For RTL, exclude everything after _
        if ($field === 'block_id' && $this->agency->slug === 'rtl') {
            return substr($trip['block_id'], 0, strpos($trip['block_id'], '_'));
        }

        return $trip[$field];
    }
}
