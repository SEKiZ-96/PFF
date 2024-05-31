


@section('header')
<div class="container-fluid d-flex justify-content-between my-3">
    <section class="header-operation animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
        @extends(backpack_view('blank'))
        @if ($crud->hasAccess('list'))
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading-back-button">
            <small><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        </p>
        @endif
        <br>
        <p>

            </p>
        <a style="margin-left:10px;" href="javascript: window.print();" class="btn float-end float-right"><i class="la la-print"></i></a>
        
    </section>
</div>
@endsection

@section('content')
<?php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                function getPeriodLabel($periodCode) {
                    switch ($periodCode) {
                        case 'M':
                            return '08:30 - 13:30';
                        case 'M1':
                            return '08:30 - 11:00';
                        case 'M2':
                            return '11:00 - 13:30';
                        case 'A':
                            return '13:30 - 18:30';
                        case 'A1':
                            return '13:30 - 16:00';
                        case 'A2':
                            return '16:00 - 18:30';
                        default:
                            return null; 
                    }
                }

                function getPeriodStartTime($periodCode) {
                    switch ($periodCode) {
                        case 'M':
                            return '08:30';
                        case 'M1':
                            return '08:30';
                        case 'M2':
                            return '11:00';
                        case 'A':
                            return '13:30';
                        case 'A1':
                            return '13:30';
                        case 'A2':
                            return '16:00';
                        default:
                            return '00:00'; // Default to earliest time for safety
                    }
                }

                // Group schedules by day
                $groupedSchedules = [];
                foreach ($schedules as $schedule) {
                    $groupedSchedules[$schedule->day][] = $schedule;
                }

                // Sort schedules within each day by period start time
                foreach ($groupedSchedules as $day => &$daySchedules) {
                    usort($daySchedules, function($a, $b) {
                        return strcmp(getPeriodStartTime($a->period), getPeriodStartTime($b->period));
                    });
                }
            ?>
<div class="container-fluid printable-content">
<?php
$totalHours = 0;
$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
?>
@foreach($daysOfWeek as $day)
    @if(isset($groupedSchedules[$day]))
        <?php
        $dayTotalHours = 0;
        ?>
        @foreach($groupedSchedules[$day] as $schedule)
            <?php
            // Extract start and end time from period label
            $periodLabelParts = explode(" - ", getPeriodLabel($schedule->period));
            $startTime = strtotime($periodLabelParts[0]);
            $endTime = strtotime($periodLabelParts[1]);
            // Calculate duration in hours
            $duration = ($endTime - $startTime) / 3600;
            // Accumulate total hours for the day
            $dayTotalHours += $duration;
            ?>
        @endforeach
        <?php
        // Accumulate total hours for all days
        $totalHours += $dayTotalHours;
        ?>
    @endif
@endforeach

<span>GROUP: <b>{{$grpname}}</b></span> -
<span class="flot-right">Total Hours: <b>{{ $totalHours }}</b></span>
<br>
<table class="table table-striped table-hover nowrap rounded card-table table-vcenter card d-table shadow-xs border-xs dataTable dtr-inline collapsed has-hidden-columns">
    <thead>
        <tr>
            <th>Day</th>
            <th>Teachers and periods</th>
        </tr>
    </thead>
    <tbody>
        @foreach($daysOfWeek as $day)
            <tr>
                <td>{{ $day }}</td>
                <td>
                    @if(isset($groupedSchedules[$day]))
                        <table class="table table-bordered">
                            @foreach($groupedSchedules[$day] as $schedule)
                                <tr>
                                    <td><b>{{ getPeriodLabel($schedule->period) }}</b></td>
                                    <td style="text-align:center;"><b>{{$schedule->teacher_name }}</b><br><b>{{$schedule->room_name}}</b></td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <table class="table table-bordered">
                            <tr>
                                <td style="text-align:center;"><b>No Schedule</b></td>
                            </tr>
                        </table>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
