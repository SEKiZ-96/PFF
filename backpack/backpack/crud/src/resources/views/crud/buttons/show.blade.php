<!-- resources/views/vendor/backpack/crud/show.blade.php -->
@extends(backpack_view('blank'))

@section('content')
    <h2>Group Schedule</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Teacher</th>
                <th>Room</th>
                <th>Day</th>
                <th>Period</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->teacher }}</td>
                    <td>{{ $schedule->room }}</td>
                    <td>{{ $schedule->day }}</td>
                    <td>{{ $schedule->period }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
