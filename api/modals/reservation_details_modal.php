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
                            <input type="text" id="ID" name="ID" value="">
                            <input type="text" id="bookingID" name="bookingID" value="">
                            <input type="text" id="reservationID" name="reservationID" value="">
                            <input type="text" id="reserve_status" name="reserve_status" value="">
                            <input type="text" id="reserve_date" name="reserve_date" value="">
                            <input type="text" id="fname" name="fname" value="">
                            <input type="text" id="lname" name="lname" value="">
                            <input type="text" id="time" name="time" value="">
                            <input type="text" id="room" name="room" value="">
                            <input type="text" id="setup" name="setup" value="">
                            <input type="text" id="businessunit" name="businessunit" value="">
                            <input type="text" id="guest" name="guest" value="">
                            <input type="text" id="contact" name="contact" value="">
                            <input type="text" id="email" name="email" value="">
                            <input type="text" id="message" name="message" value="">
                            <textarea class="form-control" id="reason_message" name="reason_message" rows="5" placeholder="Please provide message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-label-primary" id="submit_edit_reserve_details">Proceed</button>

                    <button class="btn btn-label-primary d-none" type="button" id="submit_icon" disabled>
                        <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>