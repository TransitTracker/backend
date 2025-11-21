<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AlertResource;
use App\Models\Alert;
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
        $totalAlerts = (Alert::active()->count() / 10) + 3;

        if (! App::environment('local')) {
            $this->middleware("throttle:{$totalAlerts},1,v2-alerts");
        }

        $this->middleware('cacheResponse');
    }

    public function index()
    {
        $alerts = Alert::visible()
            ->select(['id', 'title', 'subtitle', 'created_at', 'body', 'color', 'icon', 'action', 'action_parameters', 'image', 'category', 'status'])
            ->with(['regions:id,slug'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return AlertResource::collection($alerts);
    }

    public function show(int $alertId)
    {
        $alert = Alert::visible()->findOrFail($alertId);

        return AlertResource::make($alert);
    }
}
