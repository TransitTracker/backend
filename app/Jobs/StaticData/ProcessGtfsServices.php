<?php

namespace App\Jobs\StaticData;

use App\Models\Agency;
use App\Models\Gtfs\Service;
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

    public function __construct(private Agency $agency, private string $file)
    {
    }

    public function handle(): void
    {
        // Remove old services
        Service::whereAgencyId($this->agency->id)->delete();

        $servicesReader = Reader::createFromPath($this->file)->setHeaderOffset(0);

        if (count($servicesReader) >= 1) {
            $services = [];

            foreach ($servicesReader->getRecords() as $service) {
                // If the service is already in the past, don't add it
                if (Carbon::parse($service['end_date'])->isPast()) {
                    continue;
                }

                // Add the service to array
                $services[] = [
                    'agency_id' => $this->agency->id,
                    'gtfs_service_id' => $service['service_id'],
                    'monday' => $service['monday'],
                    'tuesday' => $service['tuesday'],
                    'wednesday' => $service['wednesday'],
                    'thursday' => $service['thursday'],
                    'friday' => $service['friday'],
                    'saturday' => $service['saturday'],
                    'sunday' => $service['sunday'],
                    'start_date' => new Carbon($service['start_date']),
                    'end_date' => new Carbon($service['end_date']),
                ];
            }

            Service::upsert($services, ['agency_id', 'gtfs_service_id'], ['start_date', 'end_date']);
        }

        $servicesReader = null;
    }
}
