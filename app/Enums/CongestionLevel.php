<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static UNKNOWN_CONGESTION_LEVEL()
 * @method static static RUNNING_SMOOTHLY()
 * @method static static STOP_AND_GO()
 * @method static static CONGESTION()
 * @method static static SEVERE_CONGESTION()
 */
final class CongestionLevel extends Enum implements LocalizedEnum
{
    const UNKNOWN_CONGESTION_LEVEL = 0;
    const RUNNING_SMOOTHLY = 1;
    const STOP_AND_GO = 2;
    const CONGESTION = 3;
    const SEVERE_CONGESTION = 4;
}
