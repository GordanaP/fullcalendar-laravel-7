<form id="eventSaveForm">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="event_title" id="eventTitle"
        class="form-control" placeholder="Event title">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="eventDate">Date:</label>
                <input type="text" name="event_date" id="eventDate"
                class="form-control" placeholder="yyyy-mm-dd">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="eventTime">Time:</label>
                <input type="text" name="event_time" id="eventTime"
                class="form-control" placeholder="hh::mm">
            </div>
        </div>
    </div>

    <div id="eventOutcomeDiv">
        <label>Outcome:</label>
        <div class="form-group pb-0">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="outcome"
                id="completed" value="completed" checked>
                <label class="form-check-label" for="completed">Completed</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="outcome"
                id="canceled" value="canceled">
                <label class="form-check-label" for="canceled">Canceled</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="outcome"
                id="missed" value="missed">
                <label class="form-check-label" for="missed">Missed</label>
            </div>
        </div>
    </div>
</form>