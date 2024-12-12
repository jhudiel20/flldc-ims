<div class="modal fade" id="add_room_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" id="add_room_form" enctype="multipart/form-data">

                    <div class="tab-pane fade show active" id="USER" role="tabpanel">
                        <div class="row">

                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-6">
                                <label class="form-label">Room Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="roomname" id="roomname" placeholder="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Room Type<span class="require asterisk">*</span></label>
                                <select name="roomtype" id="roomtype" class="form-control">
                                    <option value="Meeting-Room">Meeting Room</option>
                                    <option value="Training-Room">Training Room</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Capacity<span class="require asterisk">*</span></label>
                                <input type="number" class="form-control" name="capacity" id="capacity" min="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Floor Number<span class="require asterisk">*</span></label>
                                <input type="number" class="form-control" name="floornumber" id="floornumber">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status<span class="require asterisk">*</span></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="Not-Available">Not Available</option>
                                    <option value="Available">Available</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Features<span class="require asterisk">*</span></label>
                                <textarea type="text" class="form-control" name="features" id="features" cols="20" placeholder="Please enter the features of the room"
                                    rows="3"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Usage<span class="require asterisk">*</span></label>
                                <textarea type="text" class="form-control" name="usage" id="usage" cols="20" placeholder="Please enter the usage of the room"
                                    rows="3"></textarea>
                            </div>
                            <!-- <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <textarea type="text" class="form-control" name="remarks" id="remarks" cols="20"
                                    rows="3"></textarea>
                            </div> -->
                            <div class="col-md-12">
                                <label class="form-label">Room Photo<span
                                        class="require asterisk">*</span></label>
                                <input type="file" class="form-control" name="roomphoto" id="roomphoto">
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-label-secondary">Reset</button>
                <button type="button" name="add_room" class="btn btn-label-primary btn-page-block" id="add_room">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>