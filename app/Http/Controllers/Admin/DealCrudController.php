<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DealRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DealCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DealCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Deal::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/deal');
        CRUD::setEntityNameStrings('deal', 'deals');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('submission_date');
        CRUD::column('deal_name');
        CRUD::column('sales_stage');
        CRUD::column('iso');
        CRUD::column('account');

        CRUD::addFilter([
            'name'  => 'iso',
            'type'  => 'select2',
            'label' => 'ISO'
        ], function() {
            return \App\Models\Iso::all()->pluck('business_name', 'id')->toArray();
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'iso_id', $value);
        });

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'name' => 'account',
            'label' => 'Account',
        ]);
        CRUD::addColumn([
            'name' => 'iso',
            'label' => 'ISO',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DealRequest::class);

        CRUD::field('submission_date');
        CRUD::field('deal_name');
        CRUD::addField([
            'name' => 'sales_stage',
            'label' => 'Sales Stage',
            'type'        => 'select_from_array',
            'options'     => [
                'new_deal' => 'New Deal',
                'missing_info' => 'Missing Info',
                'deal_won' => 'Deal Won',
                'deal_lost' => 'Deal Lost',
            ],
            'allows_null' => false,
            'default'     => 'new_deal',
        ]);
        CRUD::addField([
            'name' => 'account', // the method on your model that defines the relationship
            'label' => 'Account',
            'type' => 'relationship',
            'model' => "App\Models\Account"
        ]);
        CRUD::addField([
            'name' => 'iso', // the method on your model that defines the relationship
            'label' => 'ISO',
            'type' => 'relationship',
            'model' => "App\Models\Iso"
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
