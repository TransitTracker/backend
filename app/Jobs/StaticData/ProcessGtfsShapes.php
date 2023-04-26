<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Trip;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
use Storage;

class ProcessGtfsShapes implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $shapes;

    public function __construct(private Agency $agency, private string $file)
    {
        $this->shapes = [];
    }

    public function handle()
    {
        // Remove old shapes
        Storage::disk('public')->delete(Storage::disk('public')->files("shapes/{$this->agency->slug}"));

        $shapesReader = Reader::createFromPath($this->file)->setHeaderOffset(0);

        foreach ($shapesReader->getRecords() as $shape) {
            $this->shapes[$shape['shape_id']][] = (object) [
                'coordinates' => [(float) $shape['shape_pt_lon'], (float) $shape['shape_pt_lat']],
                'sequence' => $shape['shape_pt_sequence'],
            ];
        }

        foreach ($this->shapes as $shapeId => $unorderedShape) {
            try {
                usort($unorderedShape, fn ($a, $b) => $a->sequence <=> $b->sequence);

                $coordinates = [];
                foreach ($unorderedShape as $orderedPoint) {
                    array_push($coordinates, $orderedPoint->coordinates);
                }

                $trip = Trip::where(['agency_id' => $this->agency->id, 'shape' => $shapeId])->with(['stopTimes:agency_id,gtfs_trip_id,gtfs_stop_id', 'stopTimes.stop:agency_id,gtfs_stop_id,position'])->first();

                $stops = $trip->stopTimes->map(function ($stopTime) {
                    return (object) [
                        'type' => 'Feature',
                        'properties' => (object) [],
                        'geometry' => $stopTime->stop->position->toArray(),
                    ];
                });

                $geojsonData = (object) [
                    'type' => 'FeatureCollection',
                    'features' => [
                        (object) [
                            'type' => 'Feature',
                            'properties' => (object) [],
                            'geometry' => (object) [
                                'type' => 'LineString',
                                'coordinates' => $coordinates,
                            ],
                        ],
                        ...$stops,
                    ],
                ];

                Storage::disk('public')
                    ->put("shapes/{$this->agency->slug}/{$shapeId}.json", json_encode($geojsonData));
            } catch (\Exception $e) {
            }
        }
    }
}
