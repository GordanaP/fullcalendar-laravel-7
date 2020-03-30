@extends('layouts.app')

@section('links')

    <style>
        .holiday, .holiday span.ui-state-default { background-color: coral; }
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <button class="btn bg-blue-400 rounded-full mb-3 text-white" id="scheduleAppBtn">
                Schedule appointment <i class="fa fa-calendar-alt ml-2"></i>
            </button>

            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>
    </div>

    @include('partials.appointments._modal')

    @include('partials.patients._patient-type-modal')

@endsection

@section('scripts')
    <script>

        /**
         * Appointment
         */
        var appListUrl = @json(route('appointments.list'));
        var scheduleAppBtn = '#scheduleAppBtn';

        /**
         * Patient
         */
        var patientTypeModal = $('#patientTypeModal');
        var patientTypeRadioInput = 'input:radio[name="patient_type"]';
        var existingPatient = 'existing';
        var patientTypeRadio = $('input:radio[name="patient_type"]');
        var selectPatientTypeBtn = '#selectPatientTypeBtn';
        var patientIndexUrl = @json(route('patients.index'));

        patientTypeModal.on("hidden.bs.modal", function() {
            patientTypeRadio.checkOptionValue(existingPatient);
        });

        /**
         * Doctor
         */
        var doctorIndexUrl = @json(route('doctors.index'));

        /**
         * Business schedule
         */
        var businessOpen = @json(App::make('business-schedule')->theEarliestOpen());
        var businessClose = @json(App::make('business-schedule')->theLatestClose());
        var businessHours = @json(App::make('business-schedule')->businessHours());

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
                    right: 'listDay'
                },
                navLinks: true,
                firstDay: firstWeekDay,
                minTime: businessOpen,
                maxTime: businessClose,
                businessHours: businessHours,
                slotLabelFormat: [{
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: false
                }],
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
            });

            calendar.render();
        });

        $(document).on('click', scheduleAppBtn, function() {
            patientTypeModal.open();
        });

        $(document).on('click', selectPatientTypeBtn, function() {
            var checked = $(patientTypeRadioInput + ':checked').val();
            checked == existingPatient
                ? redirectTo(patientIndexUrl) : redirectTo(doctorIndexUrl);
        });

    </script>
@endsection
