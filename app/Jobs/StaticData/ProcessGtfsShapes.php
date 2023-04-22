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
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;

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
        $shapesReader = Reader::createFromPath($this->file)->setHeaderOffset(0);

        foreach ($shapesReader->getRecords() as $shape) {
            $this->shapes[$shape['shape_id']][] = (object) [
                'coordinates' => new Point((float) $shape['shape_pt_lat'], (float) $shape['shape_pt_lon']),
                'sequence' => $shape['shape_pt_sequence'],
                'dist_traveled' => $shape['shape_dist_traveled'],
            ];
        }

        $this->agency->shapes()->upsert(collect($this->shapes)->map(function (array $points, string $shapeId) {
            return [
                'gtfs_shape_id' => $shapeId,
                'shape' => new LineString(collect($points)->sortBy('sequence')->pluck('coordinates')->all()),
                'total_distance' => collect($points)->sum('dist_traveled'),
            ];
        })->all(), ['gtfs_shape_id']);
    }
}
