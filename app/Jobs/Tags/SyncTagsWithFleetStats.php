<?php

namespace App\Jobs\Tags;

use App\Models\Tag;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SyncTagsWithFleetStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle()
    {
        $garages = (object) [
            'Anjou' => [],
            'Frontenac' => [],
            'LaSalle' => [],
            'Legendre' => [],
            'Mont-Royal' => [],
            'Saint-Denis' => [],
            'Saint-Laurent' => [],
            'Stinson' => [],
        ];

        $response = Http::get('https://fleetstatsapp.com/api/vehicles/stm');

        foreach ($response->json('vehicles') as $fsVehicle) {
            $vehicle = Vehicle::select('id')->firstWhere(['vehicle' => $fsVehicle['fleet_number'], 'agency_id' => 1]);
            if (! $vehicle) {
                continue;
            }

            $garages->{$fsVehicle['allocated_garage']}[] = $vehicle->id;
        }

        foreach ($garages as $garage => $ids) {
            $tag = Tag::firstWhere('label', 'LIKE', "%{$garage}%");
            if (! $tag) {
                continue;
            }

            $tag->vehicles()->sync($ids);
        }
    }
}
