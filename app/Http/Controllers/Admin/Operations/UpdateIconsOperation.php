<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\Agency;
use App\Jobs\UpdateMapboxIcons;
use Illuminate\Support\Facades\Route;

trait UpdateIconsOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupUpdateIconsRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/update-icons', [
            'as'        => $routeName.'.updateIcons',
            'uses'      => $controller.'@updateIcons',
            'operation' => 'updateIcons',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupUpdateiconsDefaults()
    {
        $this->crud->allowAccess('updateIcons');

        $this->crud->operation('list', function () {
            $this->crud->addButton('line', 'updateIcons', 'view', 'crud::buttons.update_icons', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateIcons($id)
    {
        $this->crud->hasAccessOrFail('updateIcons');

        $agency = Agency::find($id);
        UpdateMapboxIcons::dispatch($agency)->onQueue('gtfs');

        return response()->json([$id => true]);
    }
}
