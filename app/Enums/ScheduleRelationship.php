<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static SCHEDULED()
 * @method static static ADDED()
 * @method static static UNSCHEDULED()
 * @method static static CANCELED()
 * @method static static REPLACEMENT()
 * @method static static DUPLICATED()
 * @method static static DELETED()
 */
final class ScheduleRelationship extends Enum implements LocalizedEnum
{
    const SCHEDULED = 0;

    const ADDED = 1;

    const UNSCHEDULED = 2;

    const CANCELED = 3;

    const REPLACEMENT = 5;

    const DUPLICATED = 6;

    const DELETED = 7;
}
