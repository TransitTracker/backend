<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Operations\MakeActiveOperation;
use App\Http\Requests\AlertRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

/**
 * Class AlertCrudController.
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AlertCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use CloneOperation;
    use MakeActiveOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Alert');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/alert');
        $this->crud->setEntityNameStrings('alert', 'alerts');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns(['id', 'title', 'is_active']);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AlertRequest::class);

        $this->crud->addFields([
            [
                'name' => 'title',
                'type' => 'text',
                'label' => 'Title',
            ],
            [
                'name' => 'is_active',
                'type' => 'checkbox',
                'label' => 'Active',
            ],
            [
                'name' => 'can_be_closed',
                'type' => 'checkbox',
                'label' => 'Can be closed',
            ],
            [
                'name' => 'regions',
                'type' => 'select2_multiple',
                'label' => 'Regions',
                'entity' => 'regions',
                'attribute' => 'name',
                'pivot' => true,
            ],
            [
                'name' => 'expiration',
                'type' => 'datetime',
                'label' => 'Expiration',
            ],
            [
                'name' => 'body',
                'type' => 'wysiwyg',
                'label' => 'Body',
            ],
            [
                'name' => 'image',
                'type' => 'upload',
                'label' => 'Image',
                'upload' => true,
            ],
            [
                'name' => 'color',
                'type' => 'select_from_array',
                'label' => 'Color',
                'options' => [
                    'dark' => 'Dark',
                    'accent' => 'Accent',
                    'error' => 'Error',
                    'info' => 'Info',
                    'success' => 'Success',
                    'warning' => 'Warning',
                ],
            ],
            [
                'name' => 'icon',
                'type' => 'select_from_array',
                'label' => 'Icon',
                'options' => [
                    'alert' => 'Alert',
                    'starCircle' => 'Star',
                    'serverNetworkOff' => 'Server off',
                    'check' => 'Check',
                    'update' => 'Update',
                    'information' => 'Information',
                ],
            ],
            [
                'name' => 'action',
                'type' => 'select_from_array',
                'label' => 'Action',
                'options' => [
                    null => 'None',
                    'addRegion' => 'Add region',
                    'addAgency' => 'Add agency',
                    'openUrl' => 'Open URL',
                ],
            ],
            [
                'name' => 'action_parameters',
                'type' => 'textarea',
                'label' => 'Action parameters',
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
