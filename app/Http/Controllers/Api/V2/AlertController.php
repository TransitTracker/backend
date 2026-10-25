<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AlertResource;
use App\Models\Alert;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Illuminate\Support\Facades\App;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

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
        if (! App::environment('local', 'testing')) {
            $totalAlerts = (Alert::active()->count() / 10) + 3;
            $this->middleware("throttle:{$totalAlerts},1,v2-alerts");
        }

        $this->middleware(CacheResponse::for(days(7), tags: ['alerts']));
    }

    /**
     * List active alerts
     *
     * Retrieve a paginated list of visible alerts (10 per page).
     */
    public function index()
    {
        $alerts = Alert::visible()
            ->select(['id', 'title', 'subtitle', 'created_at', 'body', 'color', 'icon', 'action', 'action_parameters', 'image', 'category', 'status'])
            ->with(['regions' => function ($query) {
                $query->select('slug')->orderBy('order_id');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return AlertResource::collection($alerts);
    }

    /**
     * Get alert details
     *
     * Retrieve details for a specific visible system alert by its ID.
     */
    #[PathParameter('alertId', description: 'Unique identifier of the alert.', type: 'int', example: 1)]
    public function show(int $alertId)
    {
        $alert = Alert::visible()->findOrFail($alertId);

        return AlertResource::make($alert);
    }
}
