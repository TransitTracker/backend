<?php

namespace App\Http\Controllers\Admin;

use App\Agency;
use App\Http\Controllers\Controller;
use App\Jobs\DownloadGTFS;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agencies = Agency::all();

        return view('admin.agencies.index', compact('agencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.agencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'vehicles_type' => 'required',
            'color' => 'required',
            'text_color' => 'required',
            'static_gtfs_url' => 'required',
            'realtime_url' => 'required',
            'realtime_type' => 'required'
        ]);

        $realtimeOptions = [
            'header' => [
                $request->get('realtime_options_header_name') => $request->get('realtime_options_header_value')
            ],
            'param' => [
                $request->get('realtime_options_param_name') => $request->get('realtime_options_param_value')
            ]
        ];

        $agency = new Agency([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'vehicles_type' => $request->get('vehicles_type'),
            'color' => $request->get('color'),
            'text_color' => $request->get('text_color'),
            'static_gtfs_url' => $request->get('static_gtfs_url'),
            'realtime_url' => $request->get('realtime_url'),
            'realtime_type' => $request->get('realtime_type'),
            'realtime_options' => json_encode($realtimeOptions),
            'is_active' => false,
        ]);
        $agency->save();

        return redirect('/admin/agencies')->with('success', 'Agency saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function show(Agency $agency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function edit(Agency $agency)
    {
        return view('admin.agencies.edit', compact('agency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agency $agency)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'vehicles_type' => 'required',
            'color' => 'required',
            'text_color' => 'required',
            'static_gtfs_url' => 'required',
            'realtime_method' => 'required',
            'realtime_url' => 'required',
            'realtime_type' => 'required'
        ]);

        $realtimeOptions = [
            'method' => $request->get('realtime_method'),
            'header' => [
                $request->get('realtime_options_header_name') => $request->get('realtime_options_header_value')
            ],
            'param' => [
                $request->get('realtime_options_param_name') => $request->get('realtime_options_param_value')
            ]
        ];

        $agency->update([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'vehicles_type' => $request->get('vehicles_type'),
            'color' => $request->get('color'),
            'text_color' => $request->get('text_color'),
            'static_gtfs_url' => $request->get('static_gtfs_url'),
            'realtime_url' => $request->get('realtime_url'),
            'realtime_type' => $request->get('realtime_type'),
            'realtime_options' => json_encode($realtimeOptions),
            'is_active' => $request->get('is_active'),
        ]);

        return redirect('/admin/agencies')->with('success', 'Agency saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency)
    {
        $agency->delete();

        return redirect('/admin/agencies')->with('success', 'Agency deleted!');
    }

    /**
     * Refresh the vehicles for the specified agency
     *
     * @param Agency $agency
     * @return Response
     */
    public function refresh(Agency $agency)
    {
        Artisan::call('agency:refresh', [
            'agency' => $agency->slug
        ]);

        return redirect('/admin/agencies')->with('success', 'Vehicles will be refresh soon!');
    }

    /**
     * Clean and update the GTFS data for the specified agency
     *
     * @param Agency $agency
     * @return Response
     */
    public function gtfsCleanAndUpdate(Agency $agency)
    {
        DownloadGTFS::dispatch($agency)->onQueue('gtfs');
        return redirect('/admin/agencies')->with('success', 'Work is scheduled');
    }

    /**
     * Delete the GTFS data for the specified agency
     *
     * @param Agency $agency
     * @return Response
     */
    public function gtfsDelete(Agency $agency)
    {
        return redirect('/admin/agencies')->with('success', 'Work is scheduled');
    }

    /**
     * Clean the GTFS data for the specified agency
     *
     * @param Agency $agency
     * @return Response
     */
    public function gtfsClean(Agency $agency)
    {
        return redirect('/admin/agencies')->with('success', 'Work is scheduled');
    }
}
