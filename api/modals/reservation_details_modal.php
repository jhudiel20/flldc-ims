<div class="modal fade" id="edit_reserve_details" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Are you want to edit the request ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="reserve_approval_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" id="ID" name="ID" value="">
                            <input type="hidden" id="bookingID" name="ID" value="">
                            <input type="hidden" id="reserve_status" name="ID" value="">
                            <input type="hidden" id="reserve_date" name="ID" value="">
                            <input type="hidden" id="fname" name="ID" value="">
                            <input type="hidden" id="lname" name="ID" value="">
                            <input type="hidden" id="time" name="ID" value="">
                            <input type="hidden" id="setup" name="ID" value="">
                            <input type="hidden" id="businessunit" name="ID" value="">
                            <input type="hidden" id="guest" name="ID" value="">
                            <input type="hidden" id="contact" name="ID" value="">
                            <input type="hidden" id="email" name="ID" value="">
                            <input type="hidden" id="message" name="ID" value="">
                            <textarea class="form-control" id="reason_message" name="reason_message" rows="5" placeholder="Please provide message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-label-primary" id="submit_approval_btn">Save changes</button>

                    <button class="btn btn-label-primary d-none" type="button" id="submit_icon" disabled>
                        <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>