<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;

trait BulkSetIconOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupBulkSetIconRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/bulk-set-icon', [
            'as'        => $routeName.'.bulkSetIcon',
            'uses'      => $controller.'@bulkSetIcon',
            'operation' => 'bulkSetIcon',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupBulkSetIconDefaults()
    {
        $this->crud->allowAccess('bulkSetIcon');

        $this->crud->operation('list', function () {
            $this->crud->enableBulkActions();
            $this->crud->addButton('top', 'bulkSetIcon', 'view', 'crud::buttons.bulk_set_icon');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkSetIcon()
    {
        $this->crud->hasAccessOrFail('bulkSetIcon');

        $entries = $this->crud->getRequest()->input('entries');
        $icon = $this->crud->getRequest()->input('icon');

        foreach ($entries as $key => $id) {
            if ($entry = $this->crud->model->find($id)) {
                $entry->update([
                    'icon' => $icon,
                ]);
            }
        }

        return response()->json($entries);
    }
}
