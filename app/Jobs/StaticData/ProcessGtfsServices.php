<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;

class ProcessGtfsServices implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Agency $agency, private ?string $file)
    {
    }

    public function handle()
    {
        // Remove old services
        Service::whereAgencyId($this->agency->id)->delete();

        if ($this->file) {
            $servicesReader = Reader::createFromPath($this->file)->setHeaderOffset(0);
        } else {
            $servicesReader = null;
        }

        // Check if there is some services. If not, services will be added on the fly when parsing trips.
        if ($servicesReader && count($servicesReader) >= 1) {
            $services = [];

            foreach ($servicesReader->getRecords() as $service) {
                // If the service is already in the past, don't add it
                if (Carbon::parse($service['end_date'])->isPast()) {
                    continue;
                }

                // Add the service to array
                array_push($services, [
                    'agency_id' => $this->agency->id,
                    'service_id' => $service['service_id'],
                    'start_date' => new Carbon($service['start_date']),
                    'end_date' => new Carbon($service['end_date']),
                ]);
            }

            Service::upsert($services, ['agency_id', 'service_id'], ['start_date', 'end_date']);
        }

        $servicesReader = null;
    }
}
