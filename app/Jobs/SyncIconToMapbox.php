<?php

namespace App\Jobs;

use App\Enums\VehicleType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SyncIconToMapbox implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Collection $agencies, public VehicleType $vehicleType)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $vehicleIcon = match ($this->vehicleType) {
            VehicleType::Train() => 'm 4.6302254,289.55052 c -0.685998,0 -1.371997,0.0858 -1.371997,0.686 v 1.62924 c 0,0.331 0.269254,0.60025 0.600249,0.60025 l -0.25725,0.25725 v 0.0857 h 0.382445 l 0.342998,-0.343 h 0.646554 l 0.342999,0.343 h 0.342999 v -0.0857 l -0.257249,-0.25725 c 0.330994,0 0.600249,-0.26925 0.600249,-0.60025 v -1.62924 c 0,-0.60025 -0.613969,-0.686 -1.371997,-0.686 z m -0.771748,2.57249 c -0.142345,0 -0.25725,-0.1149 -0.25725,-0.25725 0,-0.14234 0.114905,-0.25724 0.25725,-0.25724 0.142344,0 0.257249,0.1149 0.257249,0.25724 0,0.14235 -0.114905,0.25725 -0.257249,0.25725 z m 0.600248,-1.2005 h -0.857498 v -0.68599 h 0.857498 z m 0.342999,0 v -0.68599 h 0.857498 v 0.68599 z m 0.600249,1.2005 c -0.142345,0 -0.257249,-0.1149 -0.257249,-0.25725 0,-0.14234 0.114904,-0.25724 0.257249,-0.25724 0.142345,0 0.257249,0.1149 0.257249,0.25724 0,0.14235 -0.114904,0.25725 -0.257249,0.25725 z',
            VehicleType::Tram() => 'm 4.2185797,289.73919 -0.5487989,0.4116 0.3429994,0.2744 H 3.6697808 c 0,0 -0.411599,0 -0.411599,0.4116 v 1.37199 h 0.6859984 c 0,0 0,-0.27439 0.2743995,-0.27439 h 1.7835956 v -0.4116 h -0.548798 v -0.8232 h 0.548798 v -0.2744 h -1.577796 l 0.342999,-0.2744 -0.5487986,-0.4116 m -0.6859986,0.9604 h 0.6859986 v 0.8232 H 3.5325811 v -0.8232 m 0.9603972,0 h 0.685999 v 0.8232 h -0.685999 v -0.8232 m -0.9603972,1.09759 h 0.1371997 v 0.2744 H 3.5325811 v -0.2744 m 0.6859986,0.4116 v 0.0686 c 0,0.18934 0.1536635,0.343 0.3429986,0.343 0.1372,0 0.259308,-0.081 0.314188,-0.2058 h 0.194823 c 0.05488,0.12485 0.176988,0.2058 0.314188,0.2058 0.189335,0 0.342999,-0.15366 0.342999,-0.343 v -0.0686 z',
            default => 'm 3.2582432,291.95151 c 0,0.15092 0.06688,0.2864 0.1714958,0.38072 v 0.30527 c 0,0.0943 0.07717,0.17149 0.1714947,0.17149 h 0.1714968 c 0.09432,0 0.1714947,-0.0772 0.1714947,-0.17149 v -0.1715 h 1.3719671 v 0.1715 c 0,0.0943 0.07717,0.17149 0.1714948,0.17149 h 0.1714958 c 0.09432,0 0.1714967,-0.0772 0.1714967,-0.17149 v -0.30527 c 0.1046119,-0.0943 0.1714957,-0.2298 0.1714957,-0.38072 v -1.71495 c 0,-0.60024 -0.6139552,-0.68598 -1.371967,-0.68598 -0.7580109,0 -1.3719651,0.0858 -1.3719651,0.68598 z m 0.6002342,0.1715 c -0.1423409,0 -0.2572437,-0.1149 -0.2572437,-0.25725 0,-0.14234 0.1149028,-0.25724 0.2572437,-0.25724 0.1423418,0 0.2572435,0.1149 0.2572435,0.25724 0,0.14235 -0.1149017,0.25725 -0.2572435,0.25725 z m 1.5434618,0 c -0.1423408,0 -0.2572437,-0.1149 -0.2572437,-0.25725 0,-0.14234 0.1149029,-0.25724 0.2572437,-0.25724 0.1423418,0 0.2572437,0.1149 0.2572437,0.25724 0,0.14235 -0.1149019,0.25725 -0.2572437,0.25725 z m 0.2572437,-1.02897 H 3.6012337 v -0.85748 h 2.0579492 z',
        };

        $filesToImport = collect([]);

        foreach ($this->agencies as $agency) {
            $icon = <<<SVG
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 9.2604162 9.2604169" version="1.1" id="svg6019">
                  <metadata id="metadata6016" />
                  <g id="layer1" transform="translate(0,-287.73957)">
                    <path style="fill:{$agency->color};fill-opacity:1;stroke:{$agency->text_color};stroke-width:0.09146444;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:normal" d="m 4.6302083,287.7853 c -1.7698376,0 -3.2012556,1.43143 -3.2012556,3.20126 0,2.40095 3.2012556,5.9452 3.2012556,5.9452 0,0 3.2012556,-3.54425 3.2012556,-5.9452 0,-1.76983 -1.4314181,-3.20126 -3.2012556,-3.20126 z" />
                    <path style="fill:{$agency->text_color};fill-opacity:1;stroke:none;stroke-width:0.17149575" d="{$vehicleIcon}" />
                  </g>
                </svg>
            SVG;

            $filesToImport->put("tt-{$agency->slug}-{$this->vehicleType->value}", $icon);
        }

        $styles = [
            config('transittracker.mapbox.light_style'),
            config('transittracker.mapbox.dark_style'),
            config('transittracker.mapbox.satellite_style'),
        ];

        foreach ($styles as $style) {
            $http = Http::withQueryParameters(['access_token' => config('transittracker.mapbox.secret_key')]);

            $filesToImport->each(function (string $icon, string $name) use ($http) {
                $http->attach('images', $icon, $name);
            });

            $http->post("https://api.mapbox.com/styles/v1/{$style}/sprite");

            // When adding images, Mapbox requires to update the style
            // This will update the sprite URL in the style JSON, displaying new icons
            // To do this, we first retrieve the original style JSON, then remove the last sprite ID
            // And then re-upload the style so it can generate a new sprite ID
            // See https://docs.mapbox.com/api/maps/styles/#how-to-retrieve-a-sprite-id
            $currentStyle = Http::withQueryParameters(['access_token' => config('transittracker.mapbox.secret_key')])
                ->get("https://api.mapbox.com/styles/v1/{$style}");

            $updatedStyle = $currentStyle->object();
            $updatedStyle->sprite = "mapbox://sprites/{$style}";

            Http::withQueryParameters(['access_token' => config('transittracker.mapbox.secret_key')])
                ->withBody(json_encode($updatedStyle))
                ->patch("https://api.mapbox.com/styles/v1/{$style}");
        }
    }
}
