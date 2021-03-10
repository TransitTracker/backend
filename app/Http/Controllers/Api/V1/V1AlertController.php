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
        $alert = Alert::active()->first();

        if ($alert) {
            return new AlertResource($alert);
        } else {
            return response()->json(['message' => 'NO_ACTIVE_ALERT'], 200);
        }
    }
}
