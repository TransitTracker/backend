<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Accepted()
 * @method static static Rejected()
 */
final class RegionImageStatus extends Enum
{
    const Pending = 'pending';

    const Accepted = 'accepted';

    const Rejected = 'rejected';
}
