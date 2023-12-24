<?php

namespace App\Jobs;

use App\Enums\AgencyFeature;
use App\Enums\VehicleType;
use App\Models\Agency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SyncMapboxIcons implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PendingRequest $baseClient;
    private string $apiBaseUrl = 'https://api.mapbox.com/styles/v1';

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $styles = config('transittracker.mapbox.styles');

        $agencies = Agency::select(['id', 'color', 'text_color', 'features'])->get();
        $iconsToGenerate = collect();

        $this->baseClient = Http::withQueryParameters(['access_token' => config('transittracker.mapbox.secret_key')]);

        foreach ($agencies as $agency) {
            $iconsToGenerate->push($this->generateIcon(VehicleType::Bus(), $agency));

            if ($agency->features?->contains(AgencyFeature::HasTramIcon)) {
                $iconsToGenerate->push($this->generateIcon(VehicleType::Tram(), $agency));
            }
            if ($agency->features?->contains(AgencyFeature::HasTrainIcon)) {
                $iconsToGenerate->push($this->generateIcon(VehicleType::Train(), $agency));
            }
        }

        $chunks = $iconsToGenerate->chunk(25);

        foreach ($styles as $style) {
            foreach ($chunks as $chunk) {
                $this->uploadIcons($chunk, $style);
            }

            $this->publishChanges($style);
        }
    }

    private function uploadIcons(Collection $iconsChunk, string $style): void
    {
        $newClient = $this->baseClient;

        foreach ($iconsChunk as $item) {
            $newClient->attach("images", $item->content, $item->filename);
        }

        $newClient->post("{$this->apiBaseUrl}/{$style}/sprite");
    }

    private function publishChanges($style): void
    {
        $originalStyle = ($this->baseClient)->get("{$this->apiBaseUrl}/{$style}");

        ($this->baseClient)
            ->withBody(json_encode($originalStyle->object()))
            ->patch("{$this->apiBaseUrl}/{$style}");
    }

    private function generateIcon(VehicleType $type, Agency $agency): object {
        $icon = match ($type->value) {
            VehicleType::Tram => 'm 4.2185797,289.73919 -0.5487989,0.4116 0.3429994,0.2744 H 3.6697808 c 0,0 -0.411599,0 -0.411599,0.4116 v 1.37199 h 0.6859984 c 0,0 0,-0.27439 0.2743995,-0.27439 h 1.7835956 v -0.4116 h -0.548798 v -0.8232 h 0.548798 v -0.2744 h -1.577796 l 0.342999,-0.2744 -0.5487986,-0.4116 m -0.6859986,0.9604 h 0.6859986 v 0.8232 H 3.5325811 v -0.8232 m 0.9603972,0 h 0.685999 v 0.8232 h -0.685999 v -0.8232 m -0.9603972,1.09759 h 0.1371997 v 0.2744 H 3.5325811 v -0.2744 m 0.6859986,0.4116 v 0.0686 c 0,0.18934 0.1536635,0.343 0.3429986,0.343 0.1372,0 0.259308,-0.081 0.314188,-0.2058 h 0.194823 c 0.05488,0.12485 0.176988,0.2058 0.314188,0.2058 0.189335,0 0.342999,-0.15366 0.342999,-0.343 v -0.0686 z',
            VehicleType::Train => 'm 4.6302254,289.55052 c -0.685998,0 -1.371997,0.0858 -1.371997,0.686 v 1.62924 c 0,0.331 0.269254,0.60025 0.600249,0.60025 l -0.25725,0.25725 v 0.0857 h 0.382445 l 0.342998,-0.343 h 0.646554 l 0.342999,0.343 h 0.342999 v -0.0857 l -0.257249,-0.25725 c 0.330994,0 0.600249,-0.26925 0.600249,-0.60025 v -1.62924 c 0,-0.60025 -0.613969,-0.686 -1.371997,-0.686 z m -0.771748,2.57249 c -0.142345,0 -0.25725,-0.1149 -0.25725,-0.25725 0,-0.14234 0.114905,-0.25724 0.25725,-0.25724 0.142344,0 0.257249,0.1149 0.257249,0.25724 0,0.14235 -0.114905,0.25725 -0.257249,0.25725 z m 0.600248,-1.2005 h -0.857498 v -0.68599 h 0.857498 z m 0.342999,0 v -0.68599 h 0.857498 v 0.68599 z m 0.600249,1.2005 c -0.142345,0 -0.257249,-0.1149 -0.257249,-0.25725 0,-0.14234 0.114904,-0.25724 0.257249,-0.25724 0.142345,0 0.257249,0.1149 0.257249,0.25724 0,0.14235 -0.114904,0.25725 -0.257249,0.25725 z',
            // default is also bus
            default => 'm 3.2582413,291.95151 c 0,0.15092 0.06688,0.2864 0.171496,0.38072 v 0.30527 c 0,0.0943 0.07717,0.17149 0.171495,0.17149 h 0.171497 c 0.09432,0 0.171495,-0.0772 0.171495,-0.17149 v -0.1715 h 1.371969 v 0.1715 c 0,0.0943 0.07717,0.17149 0.171495,0.17149 h 0.171496 c 0.09432,0 0.171497,-0.0772 0.171497,-0.17149 v -0.30527 c 0.104612,-0.0943 0.171496,-0.2298 0.171496,-0.38072 v -1.71496 c 0,-0.60023 -0.613956,-0.68598 -1.371969,-0.68598 -0.758012,0 -1.371967,0.0858 -1.371967,0.68598 z m 0.600235,0.1715 c -0.142341,0 -0.257244,-0.1149 -0.257244,-0.25725 0,-0.14234 0.114903,-0.25724 0.257244,-0.25724 0.142342,0 0.257244,0.1149 0.257244,0.25724 0,0.14235 -0.114902,0.25725 -0.257244,0.25725 z m 1.543464,0 c -0.142341,0 -0.257244,-0.1149 -0.257244,-0.25725 0,-0.14234 0.114903,-0.25724 0.257244,-0.25724 0.142342,0 0.257244,0.1149 0.257244,0.25724 0,0.14235 -0.114902,0.25725 -0.257244,0.25725 z m 0.257244,-1.02898 h -2.057952 v -0.85748 h 2.057952 z',
        };

        return (object) [
            'filename' => "tt-{$agency->id}-{$type->value}",
            'content' => Str::squish("<svg xmlns='http://www.w3.org/2000/svg' width='35' height='35' viewBox='0 0 9.2604162 9.2604169'>
                <g transform='translate(0,-287.73957)'>
                    <path
                        style='fill:{$agency->color};stroke:{$agency->text_color};stroke-width:0.1'
                        d='m 4.6302083,287.7853 c -1.76984,0 -3.20126,1.43142 -3.20126,3.20126 0,2.40095 3.20126,5.9452 3.20126,5.9452 0,0 3.20126,-3.54425 3.20126,-5.9452 0,-1.76984 -1.43142,-3.20126 -3.20126,-3.20126 z'/>
                    <path style='fill:{$agency->text_color}'
                        d='{$icon}' />
                </g>
            </svg>"),
        ];
    }
}
