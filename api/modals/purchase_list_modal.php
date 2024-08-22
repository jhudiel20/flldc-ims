<div class="modal fade" id="add_pr_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="add_pr_form">

                        <div class="tab-pane fade show active" id="USER" role="tabpanel" >
                            <div class="row">

                                <div class="form-message alert alert-danger" role="alert"></div>
                                <div class="col-md-12">
                                    <label class="form-label">Item Name<span class="require asterisk">*</span></label>
                                    <input type="text" class="form-control" name="item_name" id="item_name" >
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Quantity<span class="require asterisk">*</span></label>
                                    <input type="text" class="form-control" name="quantity" id="quantity" >
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Status<span class="require asterisk">*</span></label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="" disabled hidden selected>Status</option>
                                        <?php foreach (PR_STATUS as $value) { ?>
                                            <option value="<?= $value; ?>"><?= $value; ?></option>
                                        <?php } ?>
                                    </select>  
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Remarks</label>
                                    <textarea type="text" class="form-control" name="remarks" id="fname" cols="30" rows="5" ></textarea>
                                </div>
                            </div>
                        </div>
                   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                <button type="button" name="submit" class="btn btn-outline-primary" id="add_pr">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
                </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>