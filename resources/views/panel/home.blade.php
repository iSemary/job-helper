@extends('layout.switcher')
@section('switcher')
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.css') }}">
    <div class="row text-white">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner text-center pt-2">
                    <h3>{{ $companies }}</h3>
                    <p>Companies</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner text-center pt-2">
                    <h3>{{ $emailsSent }}</h3>
                    <p>Emails Sent</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner text-center pt-2">
                    <h3>{{ $coverLetters }}</h3>
                    <p>Cover Letters</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner text-center pt-2">
                    <h3>{{ $remindersSent }}</h3>
                    <p>Reminders Sent</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div id="calendarView"></div>
        </div>
    </div>
@endsection
@push('extra-scripts')
    <script src="{{ asset('assets/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var events = `<?= json_encode($calendarCompanies) ?>`;
            events = JSON.parse(events)
            $('#calendarView').fullCalendar({
                events: events,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                eventClick: function(event) {}
            });
        });
    </script>
@endpush
