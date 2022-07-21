<?php

namespace App\Services\Vin\Interfaces;

use App\Services\Vin\VinBaseInterface;
use Database\Vin\Newflyer as VinNewflyer;

class Newflyer extends VinBaseInterface
{
    public function getAssembly(): string
    {
        return VinNewFlyer::ASSEMBLY[substr($this->vin, 10, 1)];
    }

    public function getEngine(): string
    {
        return VinNewFlyer::ENGINE[substr($this->vin, 6, 1)];
    }

    public function getLength(): int
    {
        return VinNewflyer::LENGTH[substr($this->vin, 5, 1)];
    }

    public function getManufacturer(): string
    {
        return 'New Flyer';
    }

    public function getModel(): string
    {
        return VinNewflyer::SERIES[substr($this->vin, 4, 1)].' '.VinNewflyer::BODY_TYPE[substr($this->vin, 5, 1)];
    }

    public function getPropulsion(): string|null
    {
        return VinNewflyer::PROPULSION[substr($this->vin, 3, 1)];
    }

    public function getSequence(): string
    {
        return substr($this->vin, 11, 5);
    }

    public function getSource(): string
    {
        return 'https://cptdb.ca/wiki/index.php/New_Flyer_Vehicle_Identification_Number_Explanation';
    }
}
