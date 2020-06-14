<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backpack\CRUD preferences
    |--------------------------------------------------------------------------
    */

    // --------------------------
    // Default operation settings
    // --------------------------
    'operations' => [

        /*
         * List Operation
         */
        'list' => [
            // Define the size/looks of the content div for all CRUDs
            // To override per view use $this->crud->setListContentClass('class-string')
            'contentClass' => 'col-md-12',

            // enable the datatables-responsive plugin, which hides columns if they don't fit?
            // if not, a horizontal scrollbar will be shown instead
            'responsiveTable' => true,

            // stores pagination and filters in localStorage for two hours
            // whenever the user tries to see that page, backpack loads the previous pagination and filtration
            'persistentTable' => true,

            // show search bar in the top-right corner?
            'searchableTable' => true,

            // the time the table will be persisted in minutes
            // after this the table info is cleared from localStorage.
            // use false to never force localStorage clear. (default)
            // keep in mind: User can clear his localStorage whenever he wants.

            'persistentTableDuration' => false,

            // How many items should be shown by default by the Datatable?
            // This value can be overwritten on a specific CRUD by calling
            // $this->crud->setDefaultPageLength(50);
            'defaultPageLength' => 10,

            // A 1D array of options which will be used for both the displayed option and the value, or
            // A 2D array in which the first array is used to define the value options and the second array the displayed options
            // If a 2D array is used, strings in the right hand array will be automatically run through trans()
            'pageLengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'backpack::crud.all']],

            // How important is it for the action buttons to be visible?
            // - 0 - most important
            // - 1 - as important as bulk buttons
            // - 2-3 - more important than the rest of the columns
            // - 4 - less important than most columns
            'actionsColumnPriority' => 1,

            // Show a "Reset" button next to the List operation subheading
            // (Showing 1 to 25 of 9999 entries. Reset)
            // that allows the user to erase local storage for that datatable,
            // thus clearing any searching, filtering or pagination that has been
            // remembered and persisted using persistentTable
            'resetButton' => true,
        ],

        /*
         * Create Operation
         */
        'create' => [
            // Define the size/looks of the content div for all CRUDs
            // To override per view use $this->crud->setCreateContentClass('class-string')
            'contentClass' => 'col-md-8 bold-labels',

            // When using tabbed forms (create & update), what kind of tabs would you like?
            'tabsType' => 'horizontal', //options: horizontal, vertical

            // How would you like the validation errors to be shown?
            'groupedErrors' => true,
            'inlineErrors'  => true,

            // when the page loads, put the cursor on the first input?
            'autoFocusOnFirstField' => true,

            // Where do you want to redirect the user by default, save?
            // options: save_and_back, save_and_edit, save_and_new
            'defaultSaveAction' => 'save_and_back',

            // When the user chooses "save and back" or "save and new", show a bubble
            // for the fact that the default save action has been changed?
            'showSaveActionChange' => true, //options: true, false

            // Should we show a cancel button to the user?
            'showCancelButton' => true,

            // Before saving the entry, how would you like the request to be stripped?
            // - false - ONLY save inputs that have fields (safest)
            // - [x, y, z] - save ALL inputs, EXCEPT the ones given in this array
            'saveAllInputsExcept' => false,
            // 'saveAllInputsExcept' => ['_token', '_method', 'http_referrer', 'current_tab', 'save_action'],
        ],

        /*
         * Update Operation
         */
        'update' => [
            // Define the size/looks of the content div for all CRUDs
            // To override per view use $this->crud->setEditContentClass('class-string')
            'contentClass'   => 'col-md-8 bold-labels',

            // When using tabbed forms (create & update), what kind of tabs would you like?
            'tabsType' => 'horizontal', //options: horizontal, vertical

            // How would you like the validation errors to be shown?
            'groupedErrors' => true,
            'inlineErrors'  => true,

            // when the page loads, put the cursor on the first input?
            'autoFocusOnFirstField' => true,

            // Where do you want to redirect the user by default, save?
            // options: save_and_back, save_and_edit, save_and_new
            'defaultSaveAction' => 'save_and_back',

            // When the user chooses "save and back" or "save and new", show a bubble
            // for the fact that the default save action has been changed?
            'showSaveActionChange' => true, //options: true, false

            // Should we show a cancel button to the user?
            'showCancelButton' => true,

            // Before saving the entry, how would you like the request to be stripped?
            // - false - Save ONLY inputs that have a field (safest, default);
            // - [x, y, z] - Save ALL inputs, EXCEPT the ones given in this array;
            'saveAllInputsExcept' => false,
            // 'saveAllInputsExcept' => ['_token', '_method', 'http_referrer', 'current_tab', 'save_action'],
        ],

        /*
         * Show Operation
         */
        'show' => [
            // Define the size/looks of the content div for all CRUDs
            // To override per Controller use $this->crud->setShowContentClass('class-string')
            'contentClass' => 'col-md-8',
        ],

        /*
         * Reorder Operation
         */
        'reorder' => [
            // Define the size/looks of the content div for all CRUDs
            // To override per Controller use $this->crud->setReorderContentClass('class-string')
            'contentClass'   => 'col-md-8 col-md-offset-2',
        ],

    ],

    /*
    |-------------------
    | TRANSLATABLE CRUDS
    |-------------------
    */

    'show_translatable_field_icon'     => true,
    'translatable_field_icon_position' => 'right', // left or right

    'locales' => [
        'en' => 'English',
        'fr' => 'French'
    ],

];
