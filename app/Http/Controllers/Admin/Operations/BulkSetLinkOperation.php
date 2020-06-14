<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;

trait BulkSetLinkOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupBulkSetLinkRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/bulk-set-link', [
            'as'        => $routeName.'.bulkSetLink',
            'uses'      => $controller.'@bulkSetLink',
            'operation' => 'bulkSetLink',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupBulkSetLinkDefaults()
    {
        $this->crud->allowAccess('bulkSetLink');

        $this->crud->operation('list', function () {
            $this->crud->enableBulkActions();
            $this->crud->addButton('top', 'bulkSetLink', 'view', 'crud::buttons.bulk_set_link');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkSetLink()
    {
        $this->crud->hasAccessOrFail('bulkSetLink');

        $entries = $this->crud->getRequest()->input('entries');
        $link = $this->crud->getRequest()->input('link');

        foreach ($entries as $key => $id) {
            if ($entry = $this->crud->model->find($id)) {
                $entry->links()->attach($link);
            }
        }

        return response()->json($entries);
    }
}
