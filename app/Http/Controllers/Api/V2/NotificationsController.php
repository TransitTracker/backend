<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Spatie\ResponseCache\Attributes\Cache;

class NotificationsController extends Controller
{
    #[Cache(lifetime: 60 * 60, tags: ['agencies'])]
    public function agencies()
    {
        return collect(Vehicle::where('created_at', '>', now()->subWeek())->select(['id', 'agency_id'])->with('agency:id,slug')->get())->groupBy('agency.slug')->map(function ($vehicles) {
            return $vehicles->count();
        });
    }
}
