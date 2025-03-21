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
                            <div class="col-md-4">
                                <label class="form-label">Room Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="roomname" id="roomname" placeholder="">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Room Type<span class="require asterisk">*</span></label>
                                <select name="roomtype" id="roomtype" class="form-control">
                                    <option value="Meeting-Room">Meeting Room</option>
                                    <option value="Training-Room">Training Room</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Price<span class="require asterisk">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" name="price" id="price"
                                        onKeyPress="if(this.value.length==12) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)"
                                        oninput="if(this.value!=''){this.value = parseFloat(this.value.replace(/,/g, '')).toLocaleString('en-US', {style: 'decimal', maximumFractionDigits: 0, minimumFractionDigits: 0})}">
                                    <span class="input-group-text">.00</span>
                                </div>
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


<div class="modal fade" id="room_status_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Select Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="room_status_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" id="ROOMID" name="ROOMID">
                            <input type="hidden" id="ROOMNAME" name="ROOMNAME">
                            <label for="nameWithTitle" class="form-label">Status</label>
                            <select name="STATUS" id="STATUS" class="form-select">
                                <option value="Available">Available</option>
                                <option value="Not Available">Not Available</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-label-primary btn-page-block" id="submit_room_status">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>