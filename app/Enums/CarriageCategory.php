<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CarriageCategory: int implements HasLabel
{
    case Locomotive = 0;

    case Coach = 1;

    case CabCar = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::Locomotive => 'Locomotive',
            self::Coach => 'Coach',
            self::CabCar => 'Cab Car',
        };
    }
}
