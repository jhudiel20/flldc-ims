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
                                <input type="text" class="form-control" name="modalRoomName" id="modalRoomName" >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" name="modalDate" id="modalDate" >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Time</label>
                                <input type="text" class="form-control" name="modalTime" id="modalTime" >
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