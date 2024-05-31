<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait PrintSchedueleOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupPrintSchedueleRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/print-scheduele', [
            'as'        => $routeName.'.printScheduele',
            'uses'      => $controller.'@printScheduele',
            'operation' => 'printScheduele',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupPrintSchedueleDefaults()
    {
        CRUD::allowAccess('printScheduele');

        CRUD::operation('printScheduele', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'print_scheduele', 'view', 'crud::buttons.print_scheduele');
            // CRUD::addButton('line', 'print_scheduele', 'view', 'crud::buttons.print_scheduele');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function printScheduele()
    {
        CRUD::hasAccessOrFail('printScheduele');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Print Scheduele '.$this->crud->entity_name;

        // load the view
        return view('crud::operations.print_scheduele', $this->data);
    }
}