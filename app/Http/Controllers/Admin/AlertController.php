<?php

namespace App\Http\Controllers\Admin;

use App\Alert;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Spatie\ResponseCache\Facades\ResponseCache;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = Alert::all();

        return view('admin.alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.alerts.create');
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
            'title_en' => 'required',
            'title_fr' => 'required',
            'can_be_closed' => 'required',
            'body_en' => 'required',
            'body_fr' => 'required',
            'color' => 'required',
            'icon' => 'required'
        ]);

        $alert = new Alert([
            'title_en' => $request->get('title_en'),
            'title_fr' => $request->get('title_fr'),
            'can_be_closed' => $request->get('can_be_closed'),
            'body_en' => $request->get('body_en'),
            'body_fr' => $request->get('body_fr'),
            'color' => $request->get('color'),
            'icon' => $request->get('icon')
        ]);
        $alert->save();

        return redirect('/admin/alerts')->with('success', 'Alert created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        return view('admin.alerts.edit', compact('alert'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {
        $request->validate([
            'title_en' => 'required',
            'title_fr' => 'required',
            'can_be_closed' => 'required',
            'body_en' => 'required',
            'body_fr' => 'required',
            'color' => 'required',
            'icon' => 'required'
        ]);

        $alert->update([
            'title_en' => $request->get('title_en'),
            'title_fr' => $request->get('title_fr'),
            'can_be_closed' => $request->get('can_be_closed'),
            'body_en' => $request->get('body_en'),
            'body_fr' => $request->get('body_fr'),
            'color' => $request->get('color'),
            'icon' => $request->get('icon')
        ]);

        return redirect('/admin/alerts')->with('success', 'Alert saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alert $alert)
    {
        $alert->delete();

        return redirect('/admin/alerts')->with('success', 'Alert deleted!');
    }

    /**
     * Make all alerts inactive and make specified resource active
     *
     * @param Alert $alert
     * @return Response
     */
    public function active(Alert $alert)
    {
        if ($alert->is_active) {
            $alert->is_active = false;
        } else {
            Alert::where('is_active', 1)->update(['is_active' => false]);
            $alert->is_active = true;
        }

        $alert->save();

        ResponseCache::clear(['alerts']);

        return redirect('/admin/alerts')->with('success', 'Alert is now active!');
    }
}
