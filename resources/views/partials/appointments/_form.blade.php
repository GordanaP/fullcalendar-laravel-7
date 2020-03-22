<form id="appSaveForm">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="app_title" id="appTitle"
        class="form-control" placeholder="Appointment title">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="appDate">Date:</label>
                <input type="text" name="app_date" id="appDate"
                class="form-control" placeholder="yyyy-mm-dd">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="appTime">Time:</label>
                <input type="text" name="app_time" id="appTime"
                class="form-control" placeholder="hh::mm">
            </div>
        </div>
    </div>

    <div id="appStatusDiv">
        <label>Status:</label>
        <div class="form-group pb-0">
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
    </div>
</form>