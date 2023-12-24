<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PredictedBlocks()
 */
final class AgencyFeature extends Enum
{
    const PredictedBlocks = 'predictedBlocks';
    // By default, only bus icons are generated for Mapbox
    const HasTramIcon = 'hasTramIcon';
    const HasTrainIcon = 'hasTrainIcon';
}
