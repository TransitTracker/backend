<?php

namespace App\Services\Vin;

interface VinInterface
{
    public function getAssembly(): string|null;

    public function getEngine(): string|null;

    public function getLength(): int|string|null;

    public function getManufacturer(): string|null;

    public function getModel(): string|null;

    public function getNote(): string|null;

    public function getPropulsion(): string|null;

    public function getSequence(): string|null;

    public function getSource(): string|null;

    public function getYear(): int|null;

    public function hasInfo(): bool;
}
