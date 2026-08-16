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
use Illuminate\Support\Str;

class SyncTagsWithFleetStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle()
    {
        $this->sync(
            Agency::firstWhere('slug', 'stm'),
            TagType::StmGarage,
            (object) [
                'Anjou' => [],
                'Bellechasse' => [],
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
        $response = Http::get("https://fleetsighter.ca/api/vehicles/{$agency->slug}");

        $fsVehicles = $response->json('vehicles');
        if (empty($fsVehicles)) {
            return;
        }

        $fleetNumbers = collect($fsVehicles)->pluck('fleet_number')->toArray();
        $vehicles = Vehicle::select('id', 'vehicle_id')
            ->where('agency_id', $agency->id)
            ->whereIn('vehicle_id', $fleetNumbers)
            ->get()
            ->keyBy('vehicle_id');

        foreach ($fsVehicles as $fsVehicle) {
            $vehicle = $vehicles->get($fsVehicle['fleet_number']);
            if (! $vehicle) {
                continue;
            }

            $garages->{$fsVehicle['allocated_garage']}[] = $vehicle->id;
        }

        $tags = Tag::where('type', $tagType)->get();

        foreach ($garages as $garage => $ids) {
            $tag = $tags->first(function ($tag) use ($garage) {
                return Str::contains($tag->getRawOriginal('label'), $garage, true);
            });
            if (! $tag) {
                continue;
            }

            $tag->vehicles()->sync($ids);
        }
    }
}
