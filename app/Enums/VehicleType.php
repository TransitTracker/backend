<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Route type defined by the GTFS Static standard
 * Source: https://gtfs.org/schedule/reference/#routestxt (under route_type field)
 * @method static static Bus()
 * @method static static Train()
 * @method static static Tram()
 * @method static static Ferry()
 * @method static static CableTram()
 * @method static static AerialLift()
 * @method static static Funicular()
 * @method static static Trolleybus()
 * @method static static Monorail()
 */
final class VehicleType extends Enum
{
    const Tram = 0;

    const Subway = 1;

    const Train = 2;

    const Bus = 3;

    const Ferry = 4;

    const CableTram = 5;

    const AerialLift = 6;

    const Funicular = 7;

    const Trolleybus = 11;

    const Monorail = 12;
}
