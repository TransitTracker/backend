<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AlertStatus: int implements HasColor, HasDescription, HasIcon, HasLabel
{
    case Draft = 0;

    case Active = 1;

    case Locked = 2;

    case Archived = 3;

    case Hidden = 4;

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Active => 'Active',
            self::Locked => 'Locked',
            self::Archived => 'Archived',
            self::Hidden => 'Hidden',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Active => 'success',
            self::Locked => 'warning',
            self::Archived => 'info',
            self::Hidden => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Draft => 'gmdi-edit',
            self::Active => 'gmdi-campaign',
            self::Locked => 'gmdi-lock',
            self::Archived => 'gmdi-archive',
            self::Hidden => 'gmdi-visibility-off',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Draft => 'The alert is being prepared or edited. It is not visible to users yet.',
            self::Active => 'The alert is currently published and visible at the top of the app.',
            self::Locked => 'The alert is active and visible, but cannot be removed or deactivated by users.',
            self::Archived => 'The alert is no longer active but remains accessible in the alert history.',
            self::Hidden => 'The alert is inactive and completely hidden from users.',
        };
    }
}
