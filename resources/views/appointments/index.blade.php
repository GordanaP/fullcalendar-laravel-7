@extends('layouts.app')

@section('links')

    <style>
        .holiday, .holiday span.ui-state-default { background-color: coral; }
        .absence, .absence span.ui-state-default { background-color: yellow; }
        .office-day a.ui-state-default {background-color: lightgreen}
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

        /**
         * Appointment
         */
        var drAppListUrl = @json(route('doctors.appointments.list', $doctor));
        var appModal = $('#appSaveModal');
        var appModalTitle = $('#appSaveModal .modal-title');
        var appForm = $('#appSaveForm');
        var appDate = $('#appDate');
        var appTime = $('#appTime');
        var appSaveBtn = $('#appSaveModal .app-save-btn');
        var appDeleteBtn = $('#appDeleteBtn').hide();
        var appStatusRadio = $("input:radio[name=app_status]");
        var appStatusDiv = $('#appStatusDiv').hide();
        var hiddenElems = ['#appDeleteBtn', '#appStatusDiv'];
        var patientExists = @json($patient);
        var patientDetails = $('#patientDetails');
        var patientIdentifier = $('#patientIdentifier');
        var dateTimeInputs = '#appDate, #appTime';
        var patientInputs = '#firstName, #lastName, #birthday';
        var appStatusInput = 'input:radio[name=app_status]';

        if(patientExists) {
            var scheduleAppUrl =  @json(route('doctors.patients.appointments.store', [$doctor, $patient]));
            var scheduleAppFormFields = dateTimeInputs;
        } else {
            var scheduleAppUrl = @json(route('doctors.appointments.store', $doctor));
            var scheduleAppFormFields = dateTimeInputs.concat(', ').concat(patientInputs);
        }

        var errors = [
            'first_name', 'last_name', 'birthday' , 'app_date', 'app_time', 'app_status'
        ];

        appModal.clearContentOnClose(errors, hiddenElems);
        clearErrorOnTriggeringAnEvent();

        /**
         * Business schedule
         */
        var businessOpen = @json(App::make('business-schedule')->theEarliestOpen());
        var businessClose = @json(App::make('business-schedule')->theLatestClose());

        /**
         * Doctor schedule
         */
        var drOfficeDays = @json($doctor->business_days);
        var drOfficeHours = @json(App::make('doctor-schedule')
            ->setDoctor($doctor)->officeHours());
        var drSchedulingTimeSlot = @json($doctor->app_slot);
        var drSlotDuration = formatDateString(drSchedulingTimeSlot, 'mm', 'HH:mm:ss');
        var drAbsences = @json(App::make('doctor-absences')->setDoctor($doctor)->all());
        var drSchedulingTimeSlotsUrl = @json(route('doctors.scheduling.time.slots', $doctor));

        /**
         * Calendar
         */
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
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
                minTime: businessOpen,
                maxTime: businessClose,
                businessHours: drOfficeHours,
                slotDuration: drSlotDuration,
                slotLabelFormat: [{
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: false
                }],
                eventSources: [{
                    id: 'jsonFeedUrl',
                    url: drAppListUrl,
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
                    highlightDoctorAbsences(info, drAbsences);
                },
                selectable: true,
                selectAllow: function(info) {
                    var selectedStart = info.start;
                    return isSelectable(selectedStart, drAbsences);
                },
                selectConstraint: 'businessHours',
                select: function(info) {
                    var selectedStart = info.start;
                    var selectedDate = formatDate(selectedStart, dateFormat);
                    var selectedTime = formatDate(selectedStart, timeFormat);

                    appModal.open();
                    appModalTitle.text('Schedule Appointment');
                    appDate.val(selectedDate);
                    appTime.val(selectedTime);
                    patientDetails.show();
                    patientIdentifier.hide();
                    appSaveBtn.attr('id', 'appStoreBtn').text('Schedule');

                    $.ajax({
                        url: drSchedulingTimeSlotsUrl,
                        type: 'POST',
                        data: {
                            app_date: selectedDate
                        },
                    })
                    .done(function(response) {
                        appTime.timepicker('remove');
                        appTime.timepicker({
                            'timeFormat': 'H:i',
                            'step': drSchedulingTimeSlot,
                            'minTime': response.minTime,
                            'maxTime': response.maxTime,
                            'disableTimeRanges': response.bookedSlots,
                        });
                    });
                },
                eventClick: function(info) {
                    var clicked = info.event;
                    var clickedId = clicked.id;
                    var clickedStart = clicked.start;
                    var clickedDate = formatDate(clickedStart, dateFormat);
                    var clickedTime = formatDate(clickedStart, timeFormat);
                    var clickedStatus = clicked.extendedProps.status;
                    var clickedPatient = clicked.extendedProps.patient;
                    var appModalTitleText =  isPast(clickedStart)
                        ? 'Mark Appointment Status' : 'Reschedule Appointment';
                    var appSaveBtnText =  isPast(clickedStart)
                        ? 'Submit' : 'Reschedule';
                    var disabledStatus = isPast(clickedStart) ? true : false;

                    appModal.open();
                    appModalTitle.text(appModalTitleText);
                    patientDetails.hide();
                    patientIdentifier.show().find('#patientName')
                        .val(clickedPatient.last_name);
                    appDate.val(clickedDate).prop('disabled', disabledStatus);
                    appTime.val(clickedTime).prop('disabled', disabledStatus);
                    appStatusRadio.checkOptionValue(clickedStatus);
                    appSaveBtn.attr('id', 'appUpdateBtn')
                        .text(appSaveBtnText).val(clickedId);
                    toggleEventRelatedHiddenElems(clicked, appDeleteBtn, appStatusDiv);

                    $.ajax({
                        url: drSchedulingTimeSlotsUrl,
                        type: 'POST',
                        data: {
                            app_date: clickedDate
                        },
                    })
                    .done(function(response) {
                        appTime.timepicker('remove');
                        appTime.timepicker({
                            'timeFormat': 'H:i',
                            'step': drSchedulingTimeSlot,
                            'minTime': response.minTime,
                            'maxTime': response.maxTime,
                            'disableTimeRanges': response.bookedSlots,
                        });
                    });
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
                    });
                },
                eventOverlap: false,
                eventAllow: function(dropInfo, draggedEvent) {
                    var droppedStart = dropInfo.start;
                    return isSelectable(droppedStart, drAbsences)
                },
                eventConstraint: 'businessHours',
                views: {
                    timeGrid: {
                        editable: true,
                    },
                }
            });

            calendar.render();

            // Add appointment
            $(document).on('click', '#appStoreBtn', function(){
                var appData = appForm.find(scheduleAppFormFields).serializeArray();

                $.ajax({
                    url: scheduleAppUrl,
                    type: 'POST',
                    data: appData,
                })
                .done(function(response) {
                    addCalendarEvent(response.appointment, calendar)
                    appModal.close();
                })
                .fail(function(response) {
                    var errors = response.responseJSON.errors;
                    displayErrors(errors);
                });
            });

            // Update appointment
            $(document).on('click', '#appUpdateBtn', function() {
                var appId = $(this).val();
                var date = appDate.val();
                var time = appTime.val();
                var appStart = dateTimeString(date, time);
                var fields = isPast(appStart) ? appStatusInput : dateTimeInputs;
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
                .fail(function(response) {
                    var errors = response.responseJSON.errors;
                    displayErrors(errors);
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

            // Datepicker
            appDate.datepicker({
                firstDay: 1,
                dateFormat: "yy-mm-dd",
                minDate: 0,
                changeMonth: true,
                changeYear: true,
                yearRaange: "c-10:c+10",
                beforeShowDay: function(date) {
                    return markDoctorOfficeDays(date, drOfficeDays, drAbsences);
                },
                onSelect: function(date) {
                    appTime.timepicker('remove');
                    // appTime.val('')

                    $.ajax({
                        url: drSchedulingTimeSlotsUrl,
                        type: 'POST',
                        data: {
                            app_date: date
                        },
                    })
                    .done(function(response) {
                        appTime.timepicker({
                            'timeFormat': 'H:i',
                            'step': drSchedulingTimeSlot,
                            'minTime': response.minTime,
                            'maxTime': response.maxTime,
                            'disableTimeRanges': response.bookedSlots,
                        });
                    });
                },
            });
        });

    </script>
@endsection
