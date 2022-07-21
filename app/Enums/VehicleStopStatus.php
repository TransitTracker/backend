<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static INCOMING_AT()
 * @method static static STOPPED_AT()
 * @method static static IN_TRANSIT_TO()
 */
final class VehicleStopStatus extends Enum implements LocalizedEnum
{
    const INCOMING_AT = 0;

    const STOPPED_AT = 1;

    const IN_TRANSIT_TO = 2;
}
