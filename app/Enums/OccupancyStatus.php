<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static EMPTY()
 * @method static static MANY_SEATS_AVAILABLE()
 * @method static static FEW_SEATS_AVAILABLE()
 * @method static static STANDING_ROOM_ONLY()
 * @method static static CRUSHED_STANDING_ROOM_ONLY()
 * @method static static FULL()
 * @method static static NOT_ACCEPTING_PASSENGERS()
 * @method static static NO_DATA_AVAILABLE()
 * @method static static NOT_BOARDABLE()
 */
final class OccupancyStatus extends Enum implements LocalizedEnum
{
    const EMPTY = 0;

    const MANY_SEATS_AVAILABLE = 1;

    const FEW_SEATS_AVAILABLE = 2;

    const STANDING_ROOM_ONLY = 3;

    const CRUSHED_STANDING_ROOM_ONLY = 4;

    const FULL = 5;

    const NOT_ACCEPTING_PASSENGERS = 6;
    const NO_DATA_AVAILABLE = 7;
    const NOT_BOARDABLE = 8;
}
