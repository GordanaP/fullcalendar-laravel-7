<div class="modal" tabindex="-1" role="dialog" id="eventSaveModal">
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
                @include('partials.events._form')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="eventDeleteBtn">
                    Delete
                </button>
                <button type="button" class="btn btn-primary event-save-btn"></button>
                <button type="button" class="btn btn-secondary"
                data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>