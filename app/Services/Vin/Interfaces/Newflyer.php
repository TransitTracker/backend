<?php

namespace App\Services\Vin\Interfaces;

use App\Services\Vin\VinBaseInterface;
use Database\Vin\Newflyer as VinNewflyer;

class Newflyer extends VinBaseInterface
{
    public function getAssembly(): string
    {
        return $this->getValueFromList(VinNewFlyer::ASSEMBLY, 11);
    }

    public function getEngine(): string
    {
        return $this->getValueFromList(VinNewFlyer::ENGINE, 7);
    }

    public function getLength(): int
    {
        return $this->getValueFromList(VinNewFlyer::LENGTH, 6);
    }

    public function getManufacturer(): string
    {
        return 'New Flyer';
    }

    public function getModel(): string
    {
        return $this->getValueFromList(VinNewFlyer::SERIES, 5).' '.$this->getValueFromList(VinNewFlyer::BODY_TYPE, 6);
    }

    public function getPropulsion(): string|null
    {
        return $this->getValueFromList(VinNewFlyer::PROPULSION, 4);
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
