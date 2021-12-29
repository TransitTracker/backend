<?php

namespace App\Checks;

use App\Models\Agency;
use Carbon\Carbon;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class AgenciesUpdatedCheck extends Check
{
    public function run(): Result
    {
        $result = Result::make();

        $agenciesToCheck = Agency::where([['refresh_is_active', true], ['is_active', true]])->select(['timestamp', 'short_name'])->get();

        foreach ($agenciesToCheck as $agency) {
            if (now()->subMinutes(3)->isBefore(Carbon::createFromTimestamp($agency->timestamp))) {
                continue;
            }

            return $result->failed("Agency {$agency->short_name} has not been updated in the last 3 minutes.");
        }

        $result->shortSummary("{$agenciesToCheck->count()} ag.");

        return $result->ok;
    }
}
