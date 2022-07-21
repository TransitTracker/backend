<?php

namespace App\Services\Vin;

use App\Services\Vin\Interfaces\MCI;
use App\Services\Vin\Interfaces\Newflyer;
use App\Services\Vin\Interfaces\Novabus;
use App\Services\Vin\Interfaces\Unknown;
use InvalidArgumentException;

class VinManager
{
    public const REGEX = '/^(?<wmi>[0-9A-HJ-NPR-Z]{3})(?<vds>[0-9A-HJ-NPR-Z]{6})(?<vis>[0-9A-HJ-NPR-Z]{8})$/';

    public static function getInfo(string $value)
    {
        $value = strtoupper($value);

        if (!preg_match(self::REGEX, $value)) {
            throw new InvalidArgumentException(sprintf(
                'The value "%s" is not a valid VIN',
                $value
            ));
        }

        $interfaces = [
            '1FY' => Newflyer::class,
            // '1M8' => MCI::class,
            '2FY' => Newflyer::class,
            // '2M9' => MCI::class,
            // '2MG' => MCI::class,
            '2NV' => Novabus::class, 
            // '3BM' => MCI::class,
            '4RK' => Novabus::class,
            '5FY' => Newflyer::class,
        ];

        $manufacturerCode = substr($value, 0, 3);

        $interface = Unknown::class;

        if (array_key_exists($manufacturerCode, $interfaces)) {
            $interface = $interfaces[$manufacturerCode];
        }

        return new $interface($value);
    }

}
