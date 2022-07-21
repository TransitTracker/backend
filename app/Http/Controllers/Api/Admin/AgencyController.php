<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Artisan;

class AgencyController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('signed');
    }

    public function update(Agency $agency)
    {
        Artisan::call('static:update', [
            'agency' => $agency->slug,
        ]);

        return redirect('/')->with('status', "Static GTFS update for {$agency->short_name} launched!");
    }
}
