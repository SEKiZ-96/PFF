<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait ShowSchedueleOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupShowSchedueleRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/show-scheduele', [
            'as'        => $routeName.'.showScheduele',
            'uses'      => $controller.'@showScheduele',
            'operation' => 'showScheduele',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupShowSchedueleDefaults()
    {
        CRUD::allowAccess('showScheduele');

        CRUD::operation('showScheduele', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'show_scheduele', 'view', 'crud::buttons.show_scheduele');
            // CRUD::addButton('line', 'show_scheduele', 'view', 'crud::buttons.show_scheduele');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function showScheduele()
    {
        CRUD::hasAccessOrFail('showScheduele');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Show Scheduele '.$this->crud->entity_name;

        // load the view
        return view('crud::operations.show_scheduele', $this->data);
    }
}