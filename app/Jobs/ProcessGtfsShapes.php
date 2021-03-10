<?php

namespace App\Jobs;

use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
use Storage;

class ProcessGtfsShapes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Agency $agency;
    private string $file;
    private array $shapes;

    /**
     * Create a new job instance.
     *
     * @param Agency $agency
     * @param string $file
     */
    public function __construct(Agency $agency, string $file)
    {
        $this->agency = $agency;
        $this->file = $file;
        $this->shapes = [];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shapesReader = Reader::createFromPath($this->file)->setHeaderOffset(0);

        foreach ($shapesReader->getRecords() as $shape) {
            $this->shapes[$shape['shape_id']][] = (object) [
                'coordinates' => [$shape['shape_pt_lon'], $shape['shape_pt_lat']],
                'sequence' => $shape['shape_pt_sequence'],
            ];
        }

        foreach ($this->shapes as $shapeId => $unorderedShape) {
            usort($unorderedShape, function ($a, $b) {
                return $a->sequence <=> $b->sequence;
            });

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
