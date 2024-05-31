@if ($crud->hasAccess('schedule'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/schedule') }}" class="btn btn-sm btn-link"><i class="la la-calendar"></i> Schedule</a>
@endif