<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Unspecified()
 * @method static static StmGarage()
 * @method static static Operator()
 * @method static static Propulsion()
 */
final class TagType extends Enum implements LocalizedEnum
{
    const Unspecified = 0;

    const StmGarage = 1;

    const Operator = 2;

    const Propulsion = 3;
}
