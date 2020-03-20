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
            var eventModal = $('#eventSaveModal');
            var eventForm = $('#eventSaveForm');
            var eventTitle = $('#eventTitle');
            var eventDate = $('#eventDate');
            var eventTime = $('#eventTime');
            var dateFormat = "YYYY-MM-DD";
            var timeFormat = "HH:mm";
            var eventSaveBtn = $('.event-save-btn');
            var eventDeleteBtn = $('#eventDeleteBtn').hide();

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
                    var selectedStart = infoDatert;
                    var selectedDate = formatDate(selectedStart, dateFormat);
                    var selectedTime = formatDate(selectedStart, timeFormat);

                    eventModal.modal('show');
                    eventTitle.val();
                    eventDate.val(selectedDate);
                    eventTime.val(selectedTime);
                    eventSaveBtn.attr('id', 'eventStoreBtn').text('Save');
                    eventDeleteBtn.hide();
                },
                editable: true,
                eventClick: function(info) {
                    var clicked = info.event;
                    var clickedId = clicked.id;
                    var clickedTitle = clicked.title;
                    var clickedStart = clicked.start;
                    var clickedDate = formatDate(clickedStart, dateFormat);
                    var clickedTime = formatDate(clickedStart, timeFormat);

                    eventModal.modal('show');
                    eventTitle.val(clickedTitle);
                    eventDate.val(clickedDate);
                    eventTime.val(clickedTime);
                    eventSaveBtn.attr('id', 'eventUpdateBtn').text('Save changes').val(clickedId);
                    eventDeleteBtn.show().val(clickedId);
                },
            });

            calendar.render();

            // Add event
            $(document).on('click', '#eventStoreBtn', function(){
                var eventData = eventForm.serializeArray();
                var eventStoreUrl = @json(route('events.store'));

                $.ajax({
                    url: eventStoreUrl,
                    type: 'POST',
                    data: eventData,
                })
                .done(function(response) {
                    addCalendarEvent(response.event, calendar)
                    eventModal.modal('hide');
                })
                .fail(function() {
                    console.log("error");
                });
            });

            // Update event
            $(document).on('click', '#eventUpdateBtn', function(){
                var eventId = $(this).val();
                var eventData = eventForm.serializeArray();
                var eventUpdateUrl = '/events/'+eventId;

                $.ajax({
                    url: eventUpdateUrl,
                    type: 'PUT',
                    data: eventData,
                })
                .done(function(response) {
                    updateCalendarEvent(response.event, calendar);
                    eventModal.modal('hide');
                })
                .fail(function() {
                    console.log("error");
                });
            });

            // Delete event
            $(document).on('click', '#eventDeleteBtn', function() {
                var eventId = $(this).val();
                var eventDeleteUrl = '/events/'+ eventId;

                $.ajax({
                    url: eventDeleteUrl,
                    type: 'DELETE',
                })
                .done(function(response) {
                    removeCalendarEvent(eventId, calendar);
                    eventModal.modal('hide');
                })
                .fail(function() {
                    console.log("error");
                });
            });
        });

    </script>
@endsection
