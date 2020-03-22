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

    @include('partials.appointments._modal')
@endsection

@section('scripts')
    <script>

        var appModal = $('#appSaveModal');
        var appModalTitle = $('.modal-title');
        var appTitle = $('#appTitle');
        var appForm = $('#appSaveForm');
        var appDate = $('#appDate');
        var appTime = $('#appTime');
        var appSaveBtn = $('.app-save-btn');
        var appDeleteBtn = $('#appDeleteBtn').hide();
        var appStatusRadio = $("input:radio[name=app_status]");
        var appStatusDiv = $('#appStatusDiv').hide();
        var hiddenElems = ['#appDeleteBtn', '#appStatusDiv'];

        appModal.clearContentOnClose(hiddenElems);

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var appListUrl = @json(route('appointments.list'));
            var firstWeekDay = 1;
            var eventLimit = 6;
            var dateFormat = "YYYY-MM-DD";
            var timeFormat = "HH:mm";

            var businessOpen = @json(App::make('business-schedule')->theEarliestOpen());
            var businessClose = @json(App::make('business-schedule')->theLatestClose());
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth, timeGridWeek, timeGridDay, listDay'
                },
                navLinks: true,
                firstDay: firstWeekDay,
                minTime: businessOpen,
                maxTime: businessClose,
                slotLabelFormat: [
                    {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: false
                    }
                ],
                eventSources: [{
                    id: 'jsonFeedUrl',
                    url: appListUrl,
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
                    var selectedTime = viewDependentEventTime(info, businessOpen)

                    appModal.open();
                    appModalTitle.text('Schedule Appointment');
                    appTitle.val();
                    appDate.val(selectedDate);
                    appTime.val(selectedTime);
                    appSaveBtn.attr('id', 'appStoreBtn').text('Schedule');
                },
                eventClick: function(info) {
                    var clicked = info.event;
                    var clickedId = clicked.id;
                    var clickedTitle = clicked.title;
                    var clickedStart = clicked.start;
                    var clickedDate = formatDate(clickedStart, dateFormat);
                    var clickedTime = formatDate(clickedStart, timeFormat);
                    var clickedStatus = clicked.extendedProps.status;
                    var appSaveBtnText =  isPast(clickedStart) ? 'Submit' : 'Reschedule';
                    var appModalTitleText =  isPast(clickedStart)
                        ? 'Mark Appointment Status' : 'Reschedule Appointment';

                    appModal.open();
                    appModalTitle.text(appModalTitleText);
                    appTitle.val(clickedTitle);
                    appDate.val(clickedDate);
                    appTime.val(clickedTime);
                    checkRadioOption(appStatusRadio, clickedStatus)
                    appSaveBtn.attr('id', 'appUpdateBtn')
                        .text(appSaveBtnText).val(clickedId);

                    toggleEventRelatedHiddenElems(clicked, appDeleteBtn, appStatusDiv);
                },
                eventDrop:function(info) {
                    var dropped = info.event;
                    var droppedId = dropped.id;
                    var droppedStart = dropped.start;
                    var droppedDate = formatDate(droppedStart, dateFormat);
                    var droppedTime = formatDate(droppedStart, timeFormat);
                    var appUpdateUrl = '/appointments/' + droppedId;

                    var droppedData = {
                        app_date: droppedDate,
                        app_time: droppedTime,
                    }

                    $.ajax({
                        url: appUpdateUrl,
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

            // Add appointment
            $(document).on('click', '#appStoreBtn', function(){
                var fields = '#appTitle, #appDate, #appTime';
                var appData = appForm.find(fields).serializeArray();
                var appStoreUrl = @json(route('appointments.store'));

                $.ajax({
                    url: appStoreUrl,
                    type: 'POST',
                    data: appData,
                })
                .done(function(response) {
                    addCalendarEvent(response.appointment, calendar)
                    appModal.close();
                })
                .fail(function() {
                    console.log("error");
                });
            });

            // Update appointment
            $(document).on('click', '#appUpdateBtn', function(){
                var appId = $(this).val();
                var date = appDate.val();
                var time = appTime.val();
                var appStart = dateTimeString(date, time);
                var fields = isPast(appStart) ? 'input[name="app_status"]' : '#appDate, #appTime';
                var appData = appForm.find(fields).serializeArray();
                var appUpdateUrl = '/appointments/'+appId;

                $.ajax({
                    url: appUpdateUrl,
                    type: 'PUT',
                    data: appData,
                })
                .done(function(response) {
                    updateCalendarEvent(response.appointment, calendar);
                    appModal.close();
                })
                .fail(function() {
                    console.log("error");
                });
            });

            // Delete appointment
            $(document).on('click', '#appDeleteBtn', function() {
                var appId = $(this).val();
                var appDeleteUrl = '/appointments/'+ appId;

                $.ajax({
                    url: appDeleteUrl,
                    type: 'DELETE',
                })
                .done(function(response) {
                    removeCalendarEvent(appId, calendar);
                    appModal.close();
                })
                .fail(function() {
                    console.log("error");
                });
            });
        });

    </script>
@endsection
