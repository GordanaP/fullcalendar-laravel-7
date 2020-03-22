@extends('layouts.app')

@section('links')

    <style>
        .holiday, .holiday span.ui-state-default { background-color: coral; }
    </style>

@endsection

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

        var eventModal = $('#eventSaveModal');
        var eventForm = $('#eventSaveForm');
        var eventTitle = $('#eventTitle');
        var eventDate = $('#eventDate');
        var eventTime = $('#eventTime');
        var eventSaveBtn = $('.event-save-btn');
        var eventDeleteBtn = $('#eventDeleteBtn').hide();
        var eventOutcomeRadio = $('input:radio[name=outcome]');
        var eventOutcomeDiv = $('#eventOutcomeDiv').hide();
        var hiddenElems = ['#eventDeleteBtn', '#eventOutcomeDiv'];

        eventModal.clearContentOnClose(hiddenElems);

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventsListUrl = @json(route('events.list'));
            var firstWeekDay = 1;
            var eventLimit = 6;
            var dateFormat = "YYYY-MM-DD";
            var timeFormat = "HH:mm";

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth, timeGridWeek, timeGridDay, listDay'
                },
                navLinks: true,
                firstDay: firstWeekDay,
                slotLabelFormat: [
                    {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: false
                    }
                ],
                eventSources: [{
                    id: 'jsonFeedUrl',
                    url: eventsListUrl,
                }],
                eventSourceSuccess: function(response, xhr) {
                    return response.data;
                },
                eventLimit: eventLimit,
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                dayRender: function(info) {
                    highlightHolidays(info);
                },
                selectable: true,
                selectAllow: function(info) {
                    return isSelectable(info.start);
                },
                select: function(info) {
                    var selectedStart = info.start;
                    var selectedDate = formatDate(selectedStart, dateFormat);
                    var selectedTime = formatDate(selectedStart, timeFormat);

                    eventModal.modal('show');
                    eventTitle.val();
                    eventDate.val(selectedDate);
                    eventTime.val(selectedTime);
                    eventSaveBtn.attr('id', 'eventStoreBtn').text('Save');
                },
                eventClick: function(info) {
                    var clicked = info.event;
                    var clickedId = clicked.id;
                    var clickedTitle = clicked.title;
                    var clickedStart = clicked.start;
                    var clickedDate = formatDate(clickedStart, dateFormat);
                    var clickedTime = formatDate(clickedStart, timeFormat);
                    var clickedOutcome = clicked.extendedProps.outcome;
                    var eventSaveBtnText =  isPast(clickedStart) ? 'Submit' : 'Save changes';

                    eventModal.open();
                    eventTitle.val(clickedTitle);
                    eventDate.val(clickedDate);
                    eventTime.val(clickedTime);
                    checkRadioOption(eventOutcomeRadio, clickedOutcome)
                    eventSaveBtn.attr('id', 'eventUpdateBtn')
                        .text(eventSaveBtnText).val(clickedId);

                    toggleEventRelatedHiddenElems(clicked, eventDeleteBtn, eventOutcomeDiv);
                },
                eventDrop:function(info) {
                    var dropped = info.event;
                    var droppedId = dropped.id;
                    var droppedStart = dropped.start;
                    var droppedDate = formatDate(droppedStart, dateFormat);
                    var droppedTime = formatDate(droppedStart, timeFormat);
                    var eventUpdateUrl = '/events/' + droppedId;

                    var droppedData = {
                        event_date: droppedDate,
                        event_time: droppedTime,
                    }

                    $.ajax({
                        url: eventUpdateUrl,
                        type: 'PUT',
                        data: droppedData,
                    })
                    .done(function(response) {
                        console.log("success");
                    })
                    .fail(function() {
                        console.log("error");
                    });
                },
                eventOverlap: false,
                eventAllow: function(dropInfo, draggedEvent) {
                    return isSelectable(dropInfo.start)
                },
            });

            calendar.render();

            // Add event
            $(document).on('click', '#eventStoreBtn', function(){
                var fields = '#eventTitle, #eventDate, #eventTime';
                var eventData = eventForm.find(fields).serializeArray();
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
                var date = eventDate.val();
                var time = eventTime.val();
                var eventStart = date + ' ' + time;
                var fields = isPast(eventStart) ? 'input[name="outcome"]' : '#eventDate, #eventTime';
                var eventData = eventForm.find(fields).serializeArray();
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
