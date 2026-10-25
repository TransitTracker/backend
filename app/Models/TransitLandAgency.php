<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;

class TransitLandAgency extends Model
{
    use Sushi;

    protected $schema = [
        'id' => 'string',
        'onestop_id' => 'string',
        'agency_name' => 'string',
        'agency_id' => 'string',
        'operator_name' => 'string',
        'operator_short_name' => 'string',
        'operator_onestop_id' => 'string',
        'is_imported' => 'boolean',
        'feed_onestop_id' => 'string',
        'province' => 'string',
    ];

    public function getRows()
    {
        return Cache::get('transitland_agencies_rows', []);
    }

    public static function sushiInsert(array $rows)
    {
        Cache::put('transitland_agencies_rows', $rows, now()->addMinutes(10));
        // Clear sushi cache to force reload
        $instance = new static;
        $cachePath = $instance->sushiCachePath();
        if (file_exists($cachePath)) {
            unlink($cachePath);
        }
    }
}
