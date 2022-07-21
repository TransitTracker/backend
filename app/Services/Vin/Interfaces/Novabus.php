<?php

namespace App\Services\Vin\Interfaces;

use App\Services\Vin\VinBaseInterface;
use Database\Vin\Novabus as VinNovabus;

class Novabus extends VinBaseInterface
{

    public function getAssembly(): string
    {
        return VinNovabus::ASSEMBLY[substr($this->vin, 10, 1)];
    }

    public function getEngine(): string
    {
        if ($this->getYear() >= 2013) {
            return VinNovabus::ENGINE_AFTER_2013[substr($this->vin, 7, 1)];
        }

        return VinNovabus::ENGINE[substr($this->vin, 7, 1)];
    }

    public function getLength(): int
    {
        return VinNovabus::LENGTH[substr($this->vin, 5, 1)];
    }

    public function getManufacturer(): string
    {
        return 'Nova Bus';
    }

    public function getModel(): string
    {
        return VinNovabus::MODEL[substr($this->vin, 4, 1)];
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
