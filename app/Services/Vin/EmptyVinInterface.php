<?php

namespace App\Services\Vin;

use App\Services\Vin\VinInterface;

class EmptyVinInterface implements VinInterface
{
    public function __construct()
    {
        return $this->toArray();
    }

    public function getAssembly(): ?string
    {
        return null;
    }

    public function getEngine(): ?string
    {
        return null;
    }

    public function getLength(): int|string|null
    {
        return null;
    }

    public function getManufacturer(): ?string
    {
        return __('Unknown');
    }

    public function getModel(): ?string
    {
        return null;
    }

    public function getNote(): ?string
    {
        return null;
    }

    public function getPropulsion(): ?string
    {
        return null;   
    }

    public function getSequence(): ?string
    {
        return null;
    }

    public function getSource(): ?string
    {
        return null;
    }

    public function getYear(): ?int
    {
        return null;
    }

    public function toArray(): array
    {
        return [
            'assembly' => $this->getAssembly(),
            'engine' => $this->getEngine(),
            'length' => $this->getLength(),
            'manufacturer' => $this->getManufacturer(),
            'model' => $this->getModel(),
            'note' => $this->getNote(),
            'propulsion' => $this->getPropulsion(),
            'sequence' => $this->getSequence(),
            'year' => $this->getYear(),
        ];
    }

    public function hasInfo(): bool
    {
        return false;
    }
}
