<?php

namespace App\Console\Commands\Vin;

use App\Jobs\Vin\DecodeVin;
use App\Models\Vehicle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DecodeVins extends Command
{
    protected $signature = 'vin:decode';

    protected $description = 'Decode all existing vins';

    public function handle()
    {
        $query = Vehicle::exoWithVin()->whereDoesntHave('vinInformationOriginal')->select(['vehicle_id', 'force_vehicle_id']);

        $bar = $this->output->createProgressBar(Vehicle::exoWithVin()->count());

        $bar->start();

        $query->chunk(50, function ($chunk) use ($bar) {
            $vins = $chunk->map(function ($vehicle) {
                return $vehicle->force_vehicle_id ?: $vehicle->vehicle_id;
            })->join(';');

            $response = Http::asForm()->post('https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVINValuesBatch/', [
                'DATA' => $vins,
                'format' => 'JSON',
            ]);

            foreach ($response->json()['Results'] ?? [] as $result) {
                DecodeVin::decodeOne($result);
                $bar->advance();
            }
        });

        $bar->finish();
        $this->output->newLine();

        return Command::SUCCESS;
    }
}
