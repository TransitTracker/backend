<?php

namespace App\Services\Vin\Interfaces;

use App\Services\Vin\VinBaseInterface;
use Database\Vin\MCI as VinMCI;
use Illuminate\Support\Arr;

class MCI extends VinBaseInterface
{
    private function joinMultipleOptions(array $options): string
    {
        return Arr::join($options, __(' or '));
    }

    private function getPossibleOptions(string $toSearch, array $array): array
    {
        $options = [];

        foreach ($array as $key => $value) {
            if ($toSearch == $key) {
                \Debugbar::info([$toSearch, $key, $array, $value]);
                $options[] = $value;
            }
        }

        return $options;
    }

    public function getAssembly(): string
    {
        return VinMCI::ASSEMBLY[substr($this->vin, 10, 1)];
    }

    public function getEngine(): string
    {
        $engineCode = substr($this->vin, 6, 1);

        if ($this->getYear() === 2020) {
            return $this->joinMultipleOptions([
                ...$this->getPossibleOptions($engineCode, VinMCI::ENGINE),
                VinMCI::ENGINE_AFTER_2021[$engineCode] ?? null,
            ]);
        }

        if ($this->getYear() > 2020) {
            return VinMCI::ENGINE_AFTER_2021[$engineCode];
        }

        return $this->joinMultipleOptions($this->getPossibleOptions($engineCode, VinMCI::ENGINE));
    }

    public function getLength(): int|string|null
    {
        $lengthCode = substr($this->vin, 5, 1);

        if ($this->getYear() === 2020 && array_key_exists($lengthCode, VinMCI::LENGTH_AFTER_2021)) {
            return VinMCI::LENGTH_AFTER_2021[$lengthCode] . __(' (uncertain)');
        }

        if ($this->getYear() > 2020) {
            return VinMCI::LENGTH_AFTER_2021[$lengthCode];
        }

        return null;
    }

    public function getManufacturer(): string
    {
        return 'Motor Coach Industries';
    }

    public function getModel(): string
    {
        $modelCode4 = substr($this->vin, 3, 1);
        $modelCode5 = substr($this->vin, 4, 1);

        if ($this->getYear() === 2020) {
            return $this->joinMultipleOptions([
                ...$this->getPossibleOptions($modelCode4, VinMCI::MODEL),
                VinMCI::MODEL_AFTER_2021[$modelCode5] ?? null,
            ]);
        }

        if ($this->getYear() > 2020) {
            return VinMCI::MODEL_AFTER_2021[$modelCode5];
        }

        return $this->joinMultipleOptions($this->getPossibleOptions($modelCode4, VinMCI::MODEL));
    }

    public function getNote(): string
    {
        return __('Due to several changes to the VIN structure, there may be multiple options for the same field.');
    }

    public function getPropulsion(): ?string
    {
        $propulsionCode = substr($this->vin, 3, 1);

        if ($this->getYear() === 2020 && array_key_exists($propulsionCode, VinMCI::PROPULSION_AFTER_2021)) {
            return VinMCI::PROPULSION_AFTER_2021[$propulsionCode] . __(' (uncertain)');
        }

        if ($this->getYear() > 2020) {
            return VinMCI::PROPULSION_AFTER_2021[$propulsionCode];
        }

        return null;
    }

    public function getSequence(): string
    {
        return substr($this->vin, 11, 5);
    }

    public function getSource(): string
    {
        return 'https://cptdb.ca/wiki/index.php/Motor_Coach_Industries_Vehicle_Identification_Number_Explanation';
    }
}
