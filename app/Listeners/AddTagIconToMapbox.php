<?php

namespace App\Listeners;

use App\Events\TagCreated;
use App\Events\TagUpdated;
use Illuminate\Support\Facades\Http;

class AddTagIconToMapbox
{
    public function __construct()
    {
    }

    public function handle(TagUpdated|TagCreated $event)
    {
        // Do not add to Mapbox if is not shown on map
        if (!$event->tag->show_on_map) { return; }

        $lightIcon = <<<SVG
            <svg style="width:32px;height:32px" viewBox="-4 -4 32 32">
                <circle cx="12" cy="12" r="16" fill="{$event->tag->color}" />
                <path d="{$event->tag->icon}" fill="{$event->tag->text_color}" />
            </svg>
        SVG;
        $lightStyle = config('transittracker.mapbox.light_style');
        
        $darkIcon = <<<SVG
            <svg style="width:32px;height:32px" viewBox="-4 -4 32 32">
                <circle cx="12" cy="12" r="16" fill="{$event->tag->dark_color}" />
                <path d="{$event->tag->icon}" fill="{$event->tag->dark_text_color}" />
            </svg>
        SVG;
        $darkStyle = config('transittracker.mapbox.dark_style');
        
        $token = config('transittracker.mapbox.secret_key');

        Http::withBody($lightIcon, 'text/plain')->put("https://api.mapbox.com/styles/v1/{$lightStyle}/sprite/tt-tags-{$event->tag->id}?access_token={$token}");
        Http::withBody($darkIcon, 'text/plain')->put("https://api.mapbox.com/styles/v1/{$darkStyle}/sprite/tt-tags-{$event->tag->id}?access_token={$token}");
    }
}
