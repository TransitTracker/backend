<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Alert;
use Illuminate\Support\Facades\Route;

trait MakeActiveOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupMakeActiveRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/make-active', [
            'as'        => $routeName.'.makeActive',
            'uses'      => $controller.'@makeActive',
            'operation' => 'makeActive',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupMakeActiveDefaults()
    {
        $this->crud->allowAccess('makeActive');

        $this->crud->operation(['list', 'show'], function () {
            $this->crud->addButton('line', 'makeActive', 'view', 'crud::buttons.make_active', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeActive($id)
    {
        $this->crud->hasAccessOrFail('makeActive');

        $alert = $this->crud->model->findOrFail($id);
        $originalState = $alert->is_active;

        Alert::where('is_active', true)->update([
            'is_active' => false,
        ]);

        $alert->is_active = ! $originalState;

        return response()->json([$alert->id => $alert->is_active]);
    }
}
