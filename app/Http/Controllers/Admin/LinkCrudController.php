<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LinkRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

/**
 * Class LinkCrudController.
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LinkCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use CloneOperation;

    public function setup()
    {
        $this->crud->setModel('App\Link');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/link');
        $this->crud->setEntityNameStrings('link', 'links');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
                'type' => 'text',
            ],
            [
                'name' => 'internal_title',
                'label' => 'Title',
                'type' => 'text',
            ],
            [
                'name' => 'link',
                'label' => 'Link',
                'type' => 'test',
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(LinkRequest::class);

        $this->crud->addFields([
            [
                'name' => 'internal_title',
                'type' => 'text',
                'label' => 'Internal title',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => 'Title',
            ],
            [
                'name' => 'description',
                'type' => 'text',
                'label' => 'Description',
            ],
            [
                'name' => 'link',
                'type' => 'text',
                'label' => 'Link',
                'hint' => 'You can use the following varibles: <code>:id</code>, <code>:ref</code>, <code>:trip</code>.',
            ],
            [
                'name' => 'vehicles',
                'type' => 'select2_multiple',
                'label' => 'Applies to vehicles',
                'entity' => 'vehicles',
                'attribute' => 'vehicle',
                'hint' => 'Select the right ref, not the id.',
            ],
            [
                'name' => 'agencies',
                'type' => 'select2_multiple',
                'label' => 'Automatically apply to vehicles from these agencies',
                'entity' => 'agencies',
                'attribute' => 'name',
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
