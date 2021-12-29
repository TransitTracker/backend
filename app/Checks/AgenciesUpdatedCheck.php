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

        $badAgencies = [];

        foreach ($agenciesToCheck as $agency) {
            if (now()->subMinutes(5)->isBefore(Carbon::createFromTimestamp($agency->timestamp))) {
                continue;
            }

            array_push($badAgencies, $agency->short_name);
        }

        if (count($badAgencies) > 0) {
            $joinedAgencies = implode(', ', $badAgencies);

            return $result->failed("Agencies {$joinedAgencies} have not been updated in the last 5 minutes.");
        }

        $result->shortSummary("{$agenciesToCheck->count()} ag.");

        return $result->ok();
    }
}
