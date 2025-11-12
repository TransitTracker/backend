<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AlertCategory: int implements HasColor, HasLabel
{
    case Update = 0;

    case NewAgency = 1;

    case Maintenance = 2;

    case StatusUpdate = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::Update => 'Version Update',
            self::NewAgency => 'New Agency',
            self::Maintenance => 'App Maintenacne',
            self::StatusUpdate => 'App Status Update',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Update => 'info',
            self::NewAgency => 'info',
            self::Maintenance => 'warning',
            self::StatusUpdate => 'danger',
        };
    }
}
