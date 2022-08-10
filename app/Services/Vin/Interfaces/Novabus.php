<?php

namespace App\Services\Vin\Interfaces;

use App\Services\Vin\VinBaseInterface;
use Database\Vin\Novabus as VinNovabus;

class Novabus extends VinBaseInterface
{
    public function getAssembly(): string
    {
        return $this->getValueFromList(VinNovabus::ASSEMBLY, 11);
    }

    public function getEngine(): string
    {
        if ($this->getYear() >= 2013) {
            return $this->getValueFromList(VinNovabus::ENGINE_AFTER_2013, 8);
        }

        return $this->getValueFromList(VinNovabus::ENGINE, 8);
    }

    public function getLength(): int
    {
        return $this->getValueFromList(VinNovabus::LENGTH, 6);
    }

    public function getManufacturer(): string
    {
        return 'Nova Bus';
    }

    public function getModel(): string
    {
        return $this->getValueFromList(VinNovabus::MODEL, 5);
    }

    public function getPropulsion(): string|null
    {
        return null;
    }

    public function getSequence(): string
    {
        return substr($this->vin, 11, 6);
    }

    public function getSource(): string
    {
        return 'https://cptdb.ca/wiki/index.php/Nova_Bus_Vehicle_Identification_Number_Explanation';
    }
}
