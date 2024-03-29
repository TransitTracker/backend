<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AlertResource;
use App\Models\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Knuckles\Scribe\Attributes\Group;

#[Group('Alerts')]
class AlertController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $totalAlerts = ceil(1.5 * Alert::active()->count());

        if (! App::environment('local')) {
            $this->middleware("throttle:{$totalAlerts},1,v2-alerts");
        }

        $this->middleware('cacheResponse');
    }

    public function index()
    {
        $alerts = Alert::active()->get();

        return AlertResource::collection($alerts->filter(fn ($alert) => ! array_key_exists('only-v1', $alert->action_parameters->toArray())));
    }

    public function show(Alert $alert)
    {
        if (! $alert->is_active or Carbon::parse($alert->expiration)->isPast()) {
            return response()->json(['message' => 'Alert is inactive or expired.'], 403);
        }

        return AlertResource::make($alert);
    }
}
