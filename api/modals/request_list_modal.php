<div class="modal fade" id="add_request_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="add_request_form">

                    <div class="tab-pane fade show active" id="USER" role="tabpanel">
                        <div class="row">

                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-6">
                                <label class="form-label">Item Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="item_name" id="item_name" placeholder="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quantity<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="quantity" id="quantity"
                                    placeholder="(pcs, cs, pack, unit, etc)">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Purpose<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="purpose" id="purpose">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date Needed<span class="require asterisk">*</span></label>
                                <input type="date" class="form-control" name="date_needed" id="date_needed">
                            </div>
                            <?php if($decrypted_array['ACCESS'] == 'ADMIN'){?>
                            <div class="col-md-12">
                                <label class="form-label">Request by email :<span
                                        class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="email" id="email"
                                    placeholder="fast.com.ph">
                            </div>
                            <?php } ?>
                            <div class="col-md-12">
                                <label class="form-label">Item Description</label>
                                <textarea type="text" class="form-control" name="description" id="description" cols="20"
                                    rows="3"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <textarea type="text" class="form-control" name="remarks" id="remarks" cols="20"
                                    rows="3"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Item Actual Photo<span
                                        class="require asterisk">*</span></label>
                                <input type="file" class="form-control" name="item_photo" id="item_photo" />
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-label-secondary">Reset</button>
                <button type="submit" name="add_request" class="btn btn-label-primary" id="add_request">Submit</button>
                <button class="btn btn-label-primary d-none" type="button" id="request_icon" disabled>
                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>
<div class="modal fade" id="approval_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Select Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="request_approval_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" id="ID" name="ID">
                            <input type="hidden" id="EMAIL" name="EMAIL">
                            <input type="hidden" id="ITEM_NAME" name="ITEM_NAME">
                            <input type="hidden" id="REQUEST_ID" name="REQUEST_ID">
                            <label for="nameWithTitle" class="form-label">Status</label>
                            <select name="approval_status" id="approval_status" class="form-select">
                                <option value="APPROVED">APPROVED</option>
                                <option value="DECLINED">DECLINED</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-label-primary" id="submit_approval">Save changes</button>

                    <button class="btn btn-label-primary d-none" type="button" id="submit_icon" disabled>
                        <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>