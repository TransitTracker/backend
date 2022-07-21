<?php

namespace App\Services\Vin\Interfaces;

use App\Services\Vin\VinBaseInterface;
use Database\Vin\BaseData;
use Database\Vin\Novabus as VinNovabus;

class Unknown extends VinBaseInterface
{

    public function getAssembly(): string|null
    {
        return null;
    }

    public function getEngine(): string|null
    {
        return null;
    }

    public function getLength(): int|null
    {
        return null;
    }

    public function getManufacturer(): string
    {
        $manufacturerCode = substr($this->vin, 0, 3);
        
        if (!array_key_exists($manufacturerCode, BaseData::MANUFACTURERS)) {
            return __('Unknown');
        }

        return BaseData::MANUFACTURERS[$manufacturerCode];
    }

    public function getModel(): string|null
    {
        return null;
    }

    public function getNote(): ?string
    {
        return __('Information for this manufacturer has not yet been entered into Transit Tracker.');
    }

    public function getPropulsion(): string|null
    {
        return null;
    }

    public function getSequence(): string|null
    {
        return null;
    }

    public function getSource(): string|null
    {
        return null;
    }

    public function hasInfo(): bool
    {
        return false;
    }
}
