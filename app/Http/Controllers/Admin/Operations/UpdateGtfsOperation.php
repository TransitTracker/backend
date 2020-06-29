<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Agency;
use App\Jobs\CleanGtfsData;
use App\Jobs\DownloadGTFS;
use Illuminate\Support\Facades\Route;

trait UpdateGtfsOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupUpdateGtfsRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/update-gtfs', [
            'as'        => $routeName.'.updateGtfs',
            'uses'      => $controller.'@updateGtfs',
            'operation' => 'updateGtfs',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupUpdateGtfsDefaults()
    {
        $this->crud->allowAccess('updateGtfs');

        $this->crud->operation('list', function () {
            $this->crud->addButton('line', 'updateGtfs', 'view', 'crud::buttons.update_gtfs', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateGtfs($id)
    {
        $this->crud->hasAccessOrFail('updateGtfs');

        $agency = Agency::find($id);
        CleanGtfsData::dispatch($agency)->onQueue('gtfs');
        DownloadGTFS::dispatch($agency)->onQueue('gtfs');

        return response()->json([$id => true]);
    }
}
