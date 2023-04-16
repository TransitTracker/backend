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
        $chunks = Vehicle::exoWithVin()->select(['id', 'vehicle_id'])->get()->chunk(50);

        $bar = $this->output->createProgressBar(Vehicle::exoWithVin()->count());

        $bar->start();

        foreach ($chunks as $chunk) {
            $response = Http::asForm()->post('https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVINValuesBatch/', [
                'DATA' => $chunk->pluck('vehicle_id')->join(';'),
                'format' => 'JSON',
            ]);
            foreach ($response->json()['Results'] as $result) {
                DecodeVin::dispatchSync($result);
                $bar->advance();
            }
        }

        $bar->finish();

        return Command::SUCCESS;
    }
}
