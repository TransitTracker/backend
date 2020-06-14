<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Agency;
use App\Jobs\DispatchAgencies;
use Illuminate\Support\Facades\Route;

trait RefreshOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupRefreshRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/refresh', [
            'as'        => $routeName.'.refresh',
            'uses'      => $controller.'@refresh',
            'operation' => 'refresh',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupRefreshDefaults()
    {
        $this->crud->allowAccess('refresh');

        $this->crud->operation(['list', 'show'], function () {
             $this->crud->addButton('line', 'refresh', 'view', 'crud::buttons.refresh', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh($id)
    {
        $this->crud->hasAccessOrFail('refresh');

        DispatchAgencies::dispatch(Agency::where('id', $id)->select('id')->get())->onQueue('vehicles');

        // load the view
        return response()->json([ $id => true ]);
    }
}
