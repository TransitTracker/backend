<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Gtfs\Shape;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;

class ProcessGtfsShapes implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $shapes = [];

    public function __construct(private Agency $agency, private string $file) {}

    public function handle(): void
    {
        $shapesReader = Reader::createFromPath($this->file)->setHeaderOffset(0);

        foreach ($shapesReader->getRecords() as $shape) {
            if (! array_key_exists('shape_id', $shape) || ! filled($shape['shape_pt_lat']) || ! filled($shape['shape_pt_lon'])) {
                continue;
            }

            $this->shapes[$shape['shape_id']][] = (object) [
                'coordinates' => new Point((float) $shape['shape_pt_lat'], (float) $shape['shape_pt_lon']),
                'sequence' => $shape['shape_pt_sequence'],
                'dist_traveled' => array_key_exists('shape_dist_traveled', $shape) ? (float) $shape['shape_dist_traveled'] : 0,
            ];
        }

        $shapesToUpsert = collect($this->shapes)
            ->filter(fn (array $points) => count($points) >= 2)
            ->map(function (array $points, string $shapeId) {
                return [
                    'agency_id' => $this->agency->id,
                    'gtfs_shape_id' => $shapeId,
                    'shape' => (new LineString(collect($points)->sortBy('sequence')->pluck('coordinates')->all()))->toSqlExpression(DB::connection()),
                    'total_distance' => collect($points)->max('dist_traveled'),
                ];
            })
            ->values();

        if ($shapesToUpsert->isEmpty()) {
            return;
        }

        $shapesToUpsert->chunk(1000)->each(function (Collection $chunk) {
            Shape::upsert($chunk->all(), ['agency_id', 'gtfs_shape_id']);
        });

        $shapesReader = null;
    }
}
