


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
                $totalHours = 0;
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
<span>Teacher: <b>{{$tchname}}</b></span>
<span class="float-end">Total Hours: <b>{{$totalHours}}</b></span>
<br>
<table class="table table-striped table-hover table-bordered shadow-sm">
    <thead class="table-dark">
        <tr>
            <th scope="col">Day</th>
            @foreach(['08:30 - 11:00', '11:00 - 13:30', '13:30 - 16:00', '16:00 - 18:30'] as $time)
                <th scope="col">{{ $time }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($daysOfWeek as $day)
            <tr>
                <td><strong>{{ $day }}</strong></td>
                @foreach(['M1', 'M2', 'A1', 'A2'] as $period)
                    <td>
                        @if(isset($groupedSchedules[$day]))
                            @foreach($groupedSchedules[$day] as $schedule)
                                @if($schedule->period == $period || ($schedule->period == 'M' && ($period == 'M1' || $period == 'M2')) || ($schedule->period == 'A' && ($period == 'A1' || $period == 'A2')))
                                    <div class="text-center">
                                        <strong>{{ $schedule->group_name }}</strong><br>
                                        <small>{{ $schedule->room_name }}</small>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
