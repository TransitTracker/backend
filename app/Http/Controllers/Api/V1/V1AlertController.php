<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlertResource;
use App\Models\Alert;

class V1AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AlertResource|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $alert = Alert::active()->get()->filter(fn ($anAlert) => ! array_key_exists('only-v2', $anAlert->action_parameters->toArray()))->first();

        if ($alert) {
            return new AlertResource($alert);
        } else {
            return response()->json(['message' => 'NO_ACTIVE_ALERT'], 200);
        }
    }
}
