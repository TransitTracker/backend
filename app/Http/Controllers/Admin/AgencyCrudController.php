<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Operations\RefreshOperation;
use App\Http\Controllers\Admin\Operations\UpdateGtfsOperation;
use App\Http\Controllers\Admin\Operations\UpdateIconsOperation;
use App\Http\Requests\AgencyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

/**
 * Class AgencyCrudController.
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AgencyCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use UpdateIconsOperation;
    use UpdateGtfsOperation;
    use RefreshOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Agency');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/agency');
        $this->crud->setEntityNameStrings('agency', 'agencies');
    }

    protected function setupListOperation()
    {
        $this->crud->setColumns(['id', 'name', 'slug', 'is_active']);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AgencyRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'type' => 'text',
                'label' => 'Name',
            ],
            [
                'name' => 'short_name',
                'type' => 'text',
                'label' => 'Short name',
            ],
            [
                'name' => 'slug',
                'type' => 'text',
                'label' => 'Slug',
            ],
            [
                'name' => 'is_active',
                'type' => 'checkbox',
                'label' => 'Active',
                'tab' => 'General',
            ],
            [
                'name' => 'refresh_is_active',
                'type' => 'checkbox',
                'label' => 'Refresh active?',
                'tab' => 'General',
            ],
            [
                'name' => 'regions',
                'type' => 'select2_multiple',
                'label' => 'Regions',
                'entity' => 'regions',
                'attribute' => 'name',
                'pivot' => true,
                'tab' => 'General',
            ],
            [
                'name' => 'color',
                'type' => 'color_picker',
                'label' => 'Color',
                'tab' => 'General',
            ],
            [
                'name' => 'text_color',
                'type' => 'color_picker',
                'label' => 'Text color',
                'tab' => 'General',
            ],
            [
                'name' => 'vehicles_type',
                'type' => 'select_from_array',
                'label' => 'Vehicles type',
                'tab' => 'General',
                'options' => ['bus' => 'Bus', 'train' => 'Train', 'tram' => 'Tram'],
                'allows_null' => false,
                'default' => 'bus',
            ],
            [
                'name' => 'links',
                'type' => 'select2_multiple',
                'label' => 'Automatically applied links',
                'entity' => 'links',
                'attribute' => 'title',
                'tab' => 'General',
            ],
            [
                'name' => 'static_gtfs_url',
                'type' => 'text',
                'label' => 'Static GTFS URL',
                'tab' => 'Feed',
            ],
            [
                'name' => 'cron_schedule',
                'type' => 'text',
                'label' => 'Cron schedule',
                'tab' => 'Feed',
                'default' => '* * * * *',
                'hint' => 'Format: min hour dayOfMonth month dayOfWeek'
            ],
            [
                'name' => 'realtime_method',
                'type' => 'select_from_array',
                'label' => 'Realtime method',
                'tab' => 'Feed',
                'options' => ['get' => 'GET', 'post' => 'POST'],
                'allows_null' => false,
                'default' => 'GET',
                'fake' => true,
                'store_in' => 'realtime_options',
            ],
            [
                'name' => 'realtime_url',
                'type' => 'text',
                'label' => 'Realtime URL',
                'tab' => 'Feed',
            ],
            [
                'name' => 'realtime_type',
                'type' => 'select_from_array',
                'label' => 'Realtime type',
                'options' => ['gtfsrt' => 'GTFSRT Vehicle Position', 'nextbus' => 'Nextbus'],
                'tab' => 'Feed',
                'allows_null' => false,
                'default' => 'gtfsrt',
            ],
            [
                'name' => 'download_method',
                'type' => 'text',
                'label' => 'Download method',
                'tab' => 'Feed',
                'fake' => true,
                'store_in' => 'realtime_options',
            ],
            [
                'name' => 'header_name',
                'type' => 'text',
                'label' => 'Header name',
                'tab' => 'Feed',
                'fake' => true,
                'store_in' => 'realtime_options',
            ],
            [
                'name' => 'header_value',
                'type' => 'text',
                'label' => 'Header value',
                'tab' => 'Feed',
                'fake' => true,
                'store_in' => 'realtime_options',
            ],
            [
                'name' => 'param_name',
                'type' => 'text',
                'label' => 'Param name',
                'tab' => 'Feed',
                'fake' => true,
                'store_in' => 'realtime_options',
            ],
            [
                'name' => 'param_value',
                'type' => 'text',
                'label' => 'Param value',
                'tab' => 'Feed',
                'fake' => true,
                'store_in' => 'realtime_options',
            ],
            [
                'name' => 'license_title',
                'type' => 'text',
                'label' => 'License title',
                'tab' => 'License',
                'fake' => true,
                'store_in' => 'license',
            ],
            [
                'name' => 'license_url',
                'type' => 'text',
                'label' => 'License URL',
                'tab' => 'License',
                'fake' => true,
                'store_in' => 'license',
            ],
            [
                'name' => 'is_downloadable',
                'type' => 'checkbox',
                'label' => 'Downloadble',
                'tab' => 'License',
                'fake' => true,
                'store_in' => 'license',
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
