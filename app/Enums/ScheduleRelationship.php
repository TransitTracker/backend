<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static SCHEDULED()
 * @method static static ADDED()
 * @method static static UNSCHEDULED()
 * @method static static CANCELED()
 */
final class ScheduleRelationship extends Enum implements LocalizedEnum
{
    const SCHEDULED = 0;
    const ADDED = 1;
    const UNSCHEDULED = 2;
    const CANCELED = 3;
}
