<div class="modal fade" id="edit_reserve_details_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Are you sure you want to edit the request ? <br>NOTE: This message will be sent to client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="reserve_details_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" id="ID" name="ID" value="">
                            <input type="hidden" id="bookingID" name="bookingID" value="">
                            <input type="hidden" id="reservationID" name="reservationID" value="">
                            <input type="hidden" id="reserve_status" name="reserve_status" value="">
                            <input type="hidden" id="reserve_date" name="reserve_date" value="">
                            <input type="hidden" id="fname" name="fname" value="">
                            <input type="hidden" id="lname" name="lname" value="">
                            <input type="hidden" id="time" name="time" value="">
                            <input type="hidden" id="room" name="room" value="">
                            <input type="hidden" id="setup" name="setup" value="">
                            <input type="hidden" id="businessunit" name="businessunit" value="">
                            <input type="hidden" id="guest" name="guest" value="">
                            <input type="hidden" id="contact" name="contact" value="">
                            <input type="hidden" id="email" name="email" value="">
                            <input type="hidden" id="message" name="message" value="">
                            <textarea class="form-control" id="reason_message" name="reason_message" rows="5" placeholder="Please provide message" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-label-primary btn-page-block" id="submit_edit_reserve_details">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>