<?php

namespace App\Jobs\Vin;

use App\Models\Vin\Information;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class DecodeVin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private array $result)
    {
    }

    public function handle()
    {
        $assembly = $this->transformString($this->result['PlantCity']).', '.$this->transformString($this->result['PlantState']).', '.$this->transformString($this->result['PlantCountry']);
        $model = Information::updateOrCreate(['vin' => $this->result['VIN']], [
            'make' => $this->transformString($this->result['Make']),
            'model' => $this->result['Model'],
            'year' => intval($this->result['ModelYear']),
            'length' => intval($this->result['BusLength']),
            'engine' => "{$this->result['EngineManufacturer']} {$this->result['EngineModel']}",
            'assembly' => $assembly,
            'fuel' => $this->result['FuelTypePrimary'],
            'sequence' => Str::substr($this->result['VIN'], strlen($this->result['VehicleDescriptor'])),
        ]);

        $model->others = collect($this->result)
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
        if (Str::wordCount($string) === 1 && ! $ignoreOneWord) {
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
