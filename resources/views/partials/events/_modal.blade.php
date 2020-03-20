<div class="modal" tabindex="-1" role="dialog" id="eventModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Modal</h5>
                <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary event-save-btn"></button>
                <button type="button" class="btn btn-secondary"
                data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>