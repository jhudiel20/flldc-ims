<div class="modal fade" id="event_details" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" id="" enctype="multipart/form-data">

                    <div class="tab-pane fade show active" id="USER" role="tabpanel">
                        <div class="row">

                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-6">
                                <label class="form-label">Room Name</label>
                                <input type="text" class="form-control" name="modalRoomName" id="modalRoomName" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" name="modalDate" id="modalDate" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Time</label>
                                <input type="text" class="form-control" name="modalTime" id="modalTime" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Seating Arrangement</label>
                                <input type="text" class="form-control" name="modalSetup" id="modalSetup" disabled>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Requestor</label>
                                <input type="text" class="form-control" name="modalName" id="modalName" disabled>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Email<label>
                                <input type="text" class="form-control" name="modalEmail" id="modalEmail" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No.</label>
                                <input type="text" class="form-control" name="modalContact" id="modalContact" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bussiness Unit</label>
                                <input type="text" class="form-control" name="modalBU" id="modalBU" disabled>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Guest No.<label>
                                <input type="text" class="form-control" name="modalGuest" id="modalGuest" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hdmi<label>
                                <input type="text" class="form-control" name="modalHdmi" id="modalHdmi" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Extension Wire<label>
                                <input type="text" class="form-control" name="modalExtension" id="modalExtension" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Chair No.<label>
                                <input type="text" class="form-control" name="modalChair" id="modalChair" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Table No.<label>
                                <input type="text" class="form-control" name="modalTable" id="modalTable" disabled>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Purpose / Message<label>
                                <textarea class="form-control" name="modalMessage" id="modalMessage" type="text" cols="30" rows="3" disabled></textarea>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>