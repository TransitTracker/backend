<?php

namespace App\Jobs\RealtimeData;

use App\Models\Agency;
use Cron\CronExpression;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Pool;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DispatchAgencies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Collection $agencies, public bool $forceRefresh = false)
    {
    }

    public function handle()
    {
        // Get the time
        $time = time();

        // Filter agencies in normal mode
        if (! $this->forceRefresh) {
            $this->agencies = $this->agencies->filter(function (Agency $agency) {
                $cron = new CronExpression($agency->cron_schedule);

                return $cron->isDue() && $agency->refresh_is_active;
            });
        }

        // Generate STO key
        if ($sto = $this->agencies->firstWhere('slug', 'sto')) {
            $dateUtc = now()->setTimezone('UTC');
            $hash = strtoupper(hash('sha256', "{$sto->headers['sto_private']}{$dateUtc->format('Ymd')}T{$dateUtc->format('Hi')}Z"));
            $sto->realtime_url = "{$sto->realtime_url}&hash={$hash}";
            $sto->headers = [];
        }

        $responses = Http::pool(function (Pool $pool) {
            return $this->agencies->map(function (Agency $agency) use ($pool) {
                return $pool->as($agency->slug)->withHeaders($agency->headers ?? [])->get($agency->realtime_url);
            });
        });

        foreach ($responses as $agencySlug => $response) {
            if (! $response->ok()) {
                continue;
            }

            $agency = $this->agencies->firstWhere('slug', $agencySlug);

            // Save the feed
            $fileName = "feeds/{$agency->slug}";
            Storage::put($fileName, (string) $response->body());

            if ($agency->realtime_type === 'gtfsrt') {
                GtfsRtHandler::dispatch($agency, $fileName, $time)->onQueue('vehicles');
            }

            if ($agency->realtime_type === 'gtfsrt-debug') {
                GtfsRtDebugHandler::dispatch($agency, $fileName, $time)->onQueue('vehicles');
            }

            if ($agency->realtime_type === 'javascript-gtfsrt') {
                JavascriptGtfsRtHandler::dispatch($agency, $fileName, $time)->onQueue('vehicles');
            }

            if ($agency->realtime_type === 'nextbus-json') {
                NextbusJsonHandler::dispatch($agency, $fileName, $time)->onQueue('vehicles');
            }
        }
    }
}
