<form id="appSaveForm">

    <!-- Doctor -->
    <div class="form-group">
        <label for="doctor">Doctor:</label>
        <input type="text" class="form-control" id="doctor"
        value="{{ $doctor->full_name ?? null }}" disabled>
    </div>

    <!-- Patient -->
    @if (! isset($patient) )
        <div id="patientDetails">
            <div class="form-group">
                <label for="firstName">Patient First Name:</label>
                <input type="text" class="form-control" placeholder="Patient first name"
                name="first_name" id="firstName">

                <span class="invalid-feedback first_name"></span>
            </div>
            <div class="form-group">
                <label for="lastName">Patient Last Name:</label>
                <input type="text" class="form-control" placeholder="Patient last name"
                name="last_name" id="lastName">

                <span class="invalid-feedback last_name"></span>
            </div>
            <div class="form-group">
                <label for="birthday">Patient Birthday:</label>
                <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                name="birthday" id="birthday">

                <span class="invalid-feedback birthday"></span>
            </div>
        </div>
        <div id="patientIdentifier">
            <div class="form-group">
                <label for="patient">Patient:</label>
                <input type="text" class="form-control" id="patientName" disabled>
            </div>
        </div>
    @else
        <div class="form-group">
            <label for="patient">Patient:</label>
            <input type="text" class="form-control" id="patient"
            value="{{ $patient->full_name ?? null }}" disabled>
        </div>
    @endif

    <!-- Appointment start -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="appDate">Date:</label>
                <input type="text" name="app_date" id="appDate"
                class="form-control" placeholder="yyyy-mm-dd">

                <span class="invalid-feedback app_date"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="appTime">Time:</label>
                <input type="text" name="app_time" id="appTime"
                class="form-control" placeholder="hh::mm">

                <span class="invalid-feedback app_time"></span>
            </div>
        </div>
    </div>

    <!-- Appointment status-->
    <div id="appStatusDiv">
        <label>Status:</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="app_status"
                id="completed" value="completed" checked>
                <label class="form-check-label" for="completed">Completed</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="app_status"
                id="canceled" value="canceled">
                <label class="form-check-label" for="canceled">Canceled</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="app_status"
                id="missed" value="missed">
                <label class="form-check-label" for="missed">Missed</label>
            </div>
        </div>

        <span class="invalid-feedback app_status"></span>
    </div>
</form>