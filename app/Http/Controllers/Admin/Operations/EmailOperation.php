<?php

namespace App\Http\Controllers\Admin\Operations;
use App\Models\TimeSchedule;
use App\Models\Teacher;
use App\Models\Group;
use App\Models\Room;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;


trait EmailOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupEmailRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{group}/schedule', [
            'as'        => $routeName.'.schedule',
            'uses'      => $controller.'@schedule',
            'operation' => 'schedule',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupEmailDefaults()
    {
        CRUD::allowAccess('schedule');

        CRUD::operation('schedule', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            CRUD::addButton('line', 'schedule', 'view', 'crud::buttons.schedule');
        });
    }
    public function getPrintViewAttribute(){
        return "crud::operations.schedule_form";
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function schedule($id)
    {
        CRUD::hasAccessOrFail('schedule');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Schedule '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();

        // Find the schedule by ID
        // $schedule = TimeSchedule::findOrFail($id);

        // Get the group value
        $group = $id;

        // Fetch all schedules with the same group value
        $schedules = TimeSchedule::where('group', $group)->get();

        // Initialize group name variable
        $grpname = Group::where('id', $group)->value('group_name');

        foreach ($schedules as $schedule) {
            $schedule->teacher_name = Teacher::where('id', $schedule->teacher)->value('teacher_name');
            $schedule->group_name = Group::where('id', $schedule->group)->value('group_name');
            $schedule->room_name = Room::where('id', $schedule->room)->value('room_name');

            // Set group name for the first schedule
            if (empty($grpname)) {
                // $grpname = $schedule->group_name;
            }
        }

        // Pass the schedules and group name to the view
        $this->data['schedules'] = $schedules;
        $this->data['grpname'] = $grpname;

        // load the view
        return view('crud::operations.schedule_form', $this->data);
    }

}
