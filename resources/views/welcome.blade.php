@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>

    @include('partials.events._modal')
@endsection

@section('scripts')
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventsListUrl = @json(route('events.list'));
            var eventModal = $('#eventModal');
            var eventForm = $('#eventForm');
            var eventTitle = $('#eventTitle');
            var eventDate = $('#eventDate');
            var eventTime = $('#eventTime');
            var eventSaveBtn = $('.event-save-btn');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth, timeGridWeek, timeGridDay, listDay'
                },
                navLinks: true,
                firstDay: 1,
                eventSources: [{
                    id: 'jsonFeedUrl',
                    url: eventsListUrl,
                }],
                eventSourceSuccess: function(response, xhr) {
                    return response.data;
                },
                selectable: true,
                select: function(info) {
                    var date = moment(info.start).format('YYYY-MM-DD');
                    var time = moment(info.start).format('HH:mm');

                    eventModal.modal('show');
                    eventTitle.val();
                    eventDate.val(date);
                    eventTime.val(time);
                    eventSaveBtn.attr('id', 'eventStore').text('Save');
                },
                editable: true,
                eventClick: function(info) {
                    var event = info.event;
                    var eventId = event.id;
                    var title = event.title;
                    var date = moment(event.start).format('YYYY-MM-DD');
                    var time = moment(event.start).format('HH:mm');

                    eventModal.modal('show');
                    eventTitle.val(title);
                    eventDate.val(date);
                    eventTime.val(time);
                    eventSaveBtn.attr('id', 'eventUpdate').text('Save changes').val(eventId);
                },
            });

            calendar.render();

            // Add event
            $(document).on('click', '#eventStore', function(){
                var eventData = eventForm.serializeArray();
                var eventStoreUrl = @json(route('events.store'));

                $.ajax({
                    url: eventStoreUrl,
                    type: 'POST',
                    data: eventData,
                })
                .done(function(response) {
                    var event = response.event;
                    var eventSource = calendar.getEventSourceById('jsonFeedUrl');

                    calendar.addEvent( event, eventSource);
                    eventModal.modal('hide');
                })
                .fail(function() {
                    console.log("error");
                });
            });

            // Update event
            $(document).on('click', '#eventUpdate', function(){
                var eventId = $(this).val();
                var eventData = eventForm.serializeArray();
                var eventUpdateUrl = '/events/'+eventId;

                $.ajax({
                    url: eventUpdateUrl,
                    type: 'PUT',
                    data: eventData,
                })
                .done(function(response) {
                    var event = response.event;
                    var title = event.title;
                    var start = new Date(event.start);
                    var end = new Date(event.end);
                    var calendarEvent = calendar.getEventById(event.id);

                    calendarEvent.setProp('title', title);
                    calendarEvent.setDates(start, end);
                    eventModal.modal('hide');
                })
                .fail(function() {
                    console.log("error");
                });
            });
        });

    </script>
@endsection
