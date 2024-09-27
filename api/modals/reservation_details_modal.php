<div class="modal fade" id="edit_reserve_details_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Are you sure you want to edit the request ? <br>NOTE: This message will be sent to client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="reserve_approval_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" id="ID" name="ID" value="<?php echo $id;?>">
                            <input type="hidden" id="bookingID" name="ID" value="<?php echo $row['booking_id'];?>">
                            <input type="hidden" id="reservationID" name="ID" value="<?php echo $row['reservation_id'];?>">
                            <input type="hidden" id="reserve_status" name="ID" value="<?php echo $row['reserve_status'];?> ">
                            <input type="hidden" id="reserve_date" name="ID" value="<?php echo $row['reserve_date'];?>">
                            <input type="hidden" id="fname" name="ID" value="<?php echo $row['fname']; ?>">
                            <input type="hidden" id="lname" name="ID" value="<?php echo $row['lname']; ?>">
                            <input type="hidden" id="time" name="ID" value="<?php echo $row['time']; ?>">
                            <input type="hidden" id="room" name="ID" value="<?php echo $row['room']; ?>">
                            <input type="hidden" id="setup" name="ID" value="<?php echo $row['setup']; ?>">
                            <input type="hidden" id="businessunit" name="ID" value="<?php echo $row['business_unit']; ?>">
                            <input type="hidden" id="guest" name="ID" value="<?php echo $row['guest']; ?>">
                            <input type="hidden" id="contact" name="ID" value="<?php echo $row['contact']; ?>">
                            <input type="hidden" id="email" name="ID" value="<?php echo $row['email']; ?>">
                            <input type="hidden" id="message" name="ID" value="<?php echo $row['message']; ?>">
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