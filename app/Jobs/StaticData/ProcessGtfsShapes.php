<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
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
                'coordinates' => [$shape['shape_pt_lon'], $shape['shape_pt_lat']],
                'sequence' => $shape['shape_pt_sequence'],
            ];
        }

        foreach ($this->shapes as $shapeId => $unorderedShape) {
            usort($unorderedShape, fn($a, $b) => $a->sequence <=> $b->sequence);

            $coordinates = [];
            foreach ($unorderedShape as $orderedPoint) {
                array_push($coordinates, $orderedPoint->coordinates);
            }

            $geojsonData = (object) [
                'type' => 'Feature',
                'properties' => (object) [],
                'geometry' => (object) [
                    'type' => 'LineString',
                    'coordinates' => $coordinates,
                ],
            ];

            Storage::disk('public')
                ->put("shapes/{$this->agency->slug}/{$shapeId}.json", json_encode($geojsonData));
        }
    }
}
