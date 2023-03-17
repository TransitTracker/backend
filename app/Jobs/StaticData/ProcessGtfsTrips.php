<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Route;
use App\Models\Trip;
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

    public function handle()
    {
        $tripsReader = Reader::createFromPath($this->file)->setHeaderOffset(0);
        $tripsStatement = (new Statement())
            ->offset($this->offset)
            ->limit(50000);
        $tripsRecords = $tripsStatement->process($tripsReader);

        $tripsToUpdate = [];

        foreach ($tripsRecords as $trip) {
            // Find the route and service matching this trip
            $route = Route::firstWhere([['agency_id', $this->agency->id], ['route_id', $trip['route_id']]]);
            $service = $this->agency->services()->firstOrCreate(
                ['service_id' => $trip['service_id']],
                ['start_date' => now(), 'end_date' => now()->addYear()],
            );

            // If there is no service, don't add it
            if ($service) {
                // Prepare a new array to update or create the trip model
                $newTrip = [];

                // Fill each required attribute
                $newTrip['agency_id'] = $this->agency->id;
                $newTrip['trip_id'] = $trip['trip_id'];
                if (array_key_exists('trip_direction_headsign', $trip)) {
                    $newTrip['trip_headsign'] = "{$trip['trip_direction_headsign']} ({$trip['trip_headsign']})";
                } else {
                    $newTrip['trip_headsign'] = $trip['trip_headsign'];
                }

                // Fill optional trip attribute, do not keep trip_short_name for RTC
                if (array_key_exists('trip_short_name', $trip) && $this->agency->slug !== 'rtc') {
                    $newTrip['trip_short_name'] = $trip['trip_short_name'];
                }

                // Fill optional route attributes
                $newTrip['route_color'] = $route->color;
                $newTrip['route_text_color'] = $route->text_color;
                $newTrip['route_short_name'] = $route->short_name;
                $newTrip['route_long_name'] = $route->long_name;

                // Fill optional service attribute
                $newTrip['service_id'] = $service->id;

                // Fill optional block attribute
                if (array_key_exists('block_id', $trip)) {
                    $newTrip['gtfs_block_id'] = $trip['block_id'];

                    // For RTL, only use the block_id before the underscore
                    if ($this->agency === 'rtl') {
                        $newTrip['gtfs_block_id'] = substr($trip['block_id'], 0, strpos($trip['block_id'], '_'));
                    }
                }

                // Fill optional shape attribute
                if (array_key_exists('shape_id', $trip)) {
                    $newTrip['shape'] = $trip['shape_id'];
                }

                // Insert the trip into the array
                array_push($tripsToUpdate, $newTrip);
            }
        }

        collect($tripsToUpdate)->chunk(1000)->each(function (Collection $chunk) {
            Trip::upsert($chunk->all(), ['agency_id', 'trip_id']);
        });

        $tripsReader = null;
    }
}
