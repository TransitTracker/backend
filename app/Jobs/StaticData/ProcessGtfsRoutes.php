<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Route;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\Csv\Reader;

class ProcessGtfsRoutes implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Agency $agency, private string $file)
    {
    }

    public function handle()
    {
        // Remove old routes
        Route::whereAgencyId($this->agency->id)->delete();

        $routesReader = Reader::createFromPath($this->file)->setHeaderOffset(0);

        $routesToUpdate = [];

        foreach ($routesReader->getRecords() as $route) {
            // Prepare a new array to update or create the route model
            $newRoute = [];

            if (! array_key_exists('route_id', $route)) {
                continue;
            }

            // Fill each required attribute
            $newRoute['agency_id'] = $this->agency->id;
            $newRoute['route_id'] = $route['route_id'];
            $newRoute['short_name'] = $route['route_short_name'];
            $newRoute['long_name'] = $route['route_long_name'];
            $newRoute['color'] = $this->getColor($route, 'route_color', $this->agency->color);
            $newRoute['text_color'] = $this->getColor($route, 'route_text_color', $this->agency->text_color);

            array_push($routesToUpdate, $newRoute);
        }

        collect($routesToUpdate)->chunk(1000)->each(function (Collection $chunk) {
            Route::upsert($chunk->all(), ['agency_id', 'route_id']);
        });

        $routesReader = null;
    }

    private function getColor(array $route, string $field, string $fallback)
    {
        if (! array_key_exists($field, $route)) {
            return $fallback;
        }

        $color = Str::squish($route[$field]);

        if (Str::length($color) === 6) {
            return "#{$color}";
        }

        if (Str::length($color) === 7) {
            return $color;
        }

        return $fallback;
    }
}
