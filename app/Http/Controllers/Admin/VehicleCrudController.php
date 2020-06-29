<?php

namespace App\Http\Controllers\Admin;

use App\Agency;
use App\Http\Controllers\Admin\Operations\BulkSetIconOperation;
use App\Http\Controllers\Admin\Operations\BulkSetLinkOperation;
use App\Vehicle;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

/**
 * Class VehicleCrudController.
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VehicleCrudController extends CrudController
{
    use ListOperation;
    use DeleteOperation;
    use BulkSetIconOperation;
    use BulkSetLinkOperation;

    public function setup()
    {
        $this->crud->setModel('App\Vehicle');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/vehicle');
        $this->crud->setEntityNameStrings('vehicle', 'vehicles');
    }

    protected function setupListOperation()
    {
        $this->crud->enableDetailsRow();
//        $this->crud->setDetailsRowView('crud::vehicle_details_row');

        $this->crud->addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
                'type' => 'text',
            ],
            [
                'name' => 'vehicle',
                'label' => 'Fleet number',
                'type' => 'text',
            ],
            [
                'name' => 'agency',
                'label' => 'Agency',
                'type' => 'relationship',
                'attribute' => 'slug',
            ],
            [
                'name' => 'icon',
                'label' => 'Icon',
                'type' => 'text',
            ],
        ]);

        $this->crud->addFilter(
            ['type' => 'simple', 'name' => 'is_active', 'label' => 'Is active'],
            false,
            function () {
                $this->crud->addClause('active');
            }
        );
        $this->crud->addFilter(
            ['type' => 'dropdown', 'name' => 'icon', 'label' => 'Icon'],
            ['bus' => 'Bus', 'tram' => 'Tram', 'train' => 'Train'],
            function ($value) {
                $this->crud->addClause('where', 'icon', $value);
            }
        );
        $this->crud->addFilter(
            ['type' => 'dropdown', 'name' => 'agency', 'label' => 'Agency'],
            collect(Agency::all())->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            })->all(),
            function ($value) {
                $this->crud->addClause('where', 'agency_id', $value);
            }
        );
    }

    public function showDetailsRow($id)
    {
        $this->crud->hasAccessOrFail('list');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        $this->data['entry'] = Vehicle::find($id);

        return view('crud::vehicle_details_row', $this->data);
    }
}
