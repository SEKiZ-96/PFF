@if ($crud->hasAccess('browserprint'))
   <a href="{{ url($crud->route.'/'.$entry->getKey().'/browserprint') }}" target="print_frame" class="btn btn-sm btn-link"><i class="la la-print"></i> Print</a>
@endif