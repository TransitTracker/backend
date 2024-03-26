<?php

namespace App\Jobs\Tags;

use App\Enums\TagType;
use App\Models\Agency;
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
        $this->sync(
            Agency::firstWhere('slug', 'stm'),
            TagType::StmGarage,
            (object) [
                'Anjou' => [],
                'Frontenac' => [],
                'LaSalle' => [],
                'Legendre' => [],
                'Mont-Royal' => [],
                'Saint-Denis' => [],
                'Saint-Laurent' => [],
                'Stinson' => [],
            ]
        );

        $this->sync(
            Agency::firstWhere('slug', 'ttc'),
            TagType::TtcGarage,
            (object) [
                'Arrow Road' => [],
                'Birchmount' => [],
                'Eglinton' => [],
                'Malvern' => [],
                'McNicoll' => [],
                'Mount Dennis' => [],
                'Queensway' => [],
                'Wilson' => [],
            ]
        );
    }

    private function sync(Agency $agency, int $tagType, object $garages)
    {
        $response = Http::get("https://fleetstatsapp.com/api/vehicles/{$agency->slug}");
        //        $tags = Tag::whereType($tagType)->select(['id', 'label'])->get();

        foreach ($response->json('vehicles') as $fsVehicle) {
            $vehicle = Vehicle::select('id')->firstWhere(['agency_id' => $agency->id, 'vehicle_id' => $fsVehicle['fleet_number']]);
            if (! $vehicle) {
                continue;
            }

            $garages->{$fsVehicle['allocated_garage']}[] = $vehicle->id;
        }

        foreach ($garages as $garage => $ids) {
            // TODO: retrieve tags only once to optimize
            $tag = Tag::firstWhere([['label', 'LIKE', "%{$garage}%"], ['type', '=', $tagType]]);
            if (! $tag) {
                continue;
            }

            $tag->vehicles()->sync($ids);
        }
    }
}
