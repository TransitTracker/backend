<?php

namespace App\Jobs\Vin;

use App\Models\Vin\Information;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DecodeVin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private array $vins)
    {
    }

    public function handle()
    {
        $response = Http::asForm()->post('https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVINValuesBatch/', [
            'DATA' => implode(',', $this->vins),
            'format' => 'JSON',
        ]);

        foreach ($response->json()['Results'] as $result) {
            $this->decodeOne($result);
        }
    }

    public function decodeOne(array $result)
    {
        $assembly = $this->transformString($result['PlantCity']) . ', ' . $this->transformString($result['PlantState']) . ', ' . $this->transformString($result['PlantCountry']);
        $model = Information::updateOrCreate(['vin' => $result['VIN']], [
            'make' => $this->transformString($result['Make']),
            'model' => $result['Model'],
            'year' => intval($result['ModelYear']),
            'length' => intval($result['BusLength']),
            'engine' => "{$result['EngineManufacturer']} {$result['EngineModel']}",
            'assembly' => $assembly,
            'fuel' => $result['FuelTypePrimary'],
            'sequence' => Str::substr($result['VIN'], strlen($result['VehicleDescriptor'])),
        ]);

        $model->others = collect($result)
            ->forget([
                'VIN', 'VehicleDescriptor', 'ErrorCode', 'ErrorText', 'Make', 'MakeID', 'ManufacturerId', 'Model', 'ModelID', 'ModelYear', 'BusLength', 'EngineManufacturer', 'EngineModel',
                'PlantCity', 'PlantState', 'PlantCountry', 'FuelTypePrimary',
            ])
            ->filter(function ($value) {
                return $value !== '' && $value !== 'Not Applicable';
            })
            ->mapWithKeys(function ($item, $key) {
                return [
                    $this->transformString($key, true) => $item,
                ];
            });

        $model->save();
    }

    private function transformString(string $string, bool $ignoreOneWord = false): string
    {
        if (Str::wordCount($string) === 1 && !$ignoreOneWord) {
            return str($string)->lower()->ucfirst()->value;
        }

        return str($string)
            ->headline()
            ->replace('Usa', 'USA')
            ->replace('C C', 'CC')
            ->replace('C I', 'CI')
            ->replace('H P', 'HP')
            ->replace('K W', 'KW')
            ->value;
    }
}
