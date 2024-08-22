<style>
    .asterisk{
        font-size:22px;
    }
    /* a.btn,
a.button,
a[type="button"] {
  color: white;
  text-decoration: none;
} */
</style>
<div class="modal fade" id="add_stocks_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New Stocks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="add_stock_form">

                        <div class="tab-pane fade show active" id="USER" role="tabpanel" >
                            <div class="row">
                                <input type="hidden" id="ID" name="ID" value="<?php echo $id; ?>">
                                <input type="hidden" id="PRODUCT_NAME" name="PRODUCT_NAME" value="<?php echo $row['PRODUCT_NAME']; ?>">
                                <div class="form-message alert alert-danger" role="alert"></div>
                                <div class="col-md-4">
                                    <label class="form-label">Quantity<span class="require asterisk">*</span></label>
                                    <input type="number" class="form-control" name="QUANTITY" id="QUANTITY" >
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Quantity Measurement<span class="require asterisk">*</span></label>
                                    <select name="MEASUREMENT" id="MEASUREMENT" class="form-select">
                                        <option value="" disabled hidden selected>Measurement</option>
                                        <?php foreach (UNIT as $value) { ?>
                                        <option value="<?= $value; ?>"><?= $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label py-2">Expiration Date</label>
                                    <input type="date" class="form-control" name="EXPIRATION" id="EXPIRATION" >
                                </div>
                                <div class="col-md-12 py-2">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" name="REMARKS" id="REMARKS" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>          
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                <button type="button" name="submit_add_stock" class="btn btn-outline-primary" id="submit_add_stock">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
                </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

<div class="modal fade" id="edit_product_stock_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Stock Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="edit_stock_form">

                        <div class="tab-pane fade show active" id="USER" role="tabpanel" >
                            <div class="row">
                                <input type="hidden" id="EDIT_TABLE_ID" name="EDIT_TABLE_ID" value="">
                                <input type="hidden" id="OLD_QUANTITY" name="OLD_QUANTITY" value="">
                                <input type="hidden" id="EDIT_PRODUCT_ID" name="EDIT_PRODUCT_ID" value="">
                                <input type="hidden" id="PRODUCT_NAME" name="PRODUCT_NAME" value="<?php echo $row['PRODUCT_NAME']; ?>">
                                <div class="form-message alert alert-danger" role="alert"></div>
                                <div class="col-md-4">
                                    <label class="form-label">Quantity<span class="require asterisk">*</span></label>
                                    <input type="number" class="form-control" name="EDIT_QUANTITY" id="EDIT_QUANTITY" >
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Quantity Measurement<span class="require asterisk">*</span></label>
                                    <select name="EDIT_MEASUREMENT" id="EDIT_MEASUREMENT" class="form-select">
                                        <option value="" disabled hidden selected>Measurement</option>
                                        <?php foreach (UNIT as $value) { ?>
                                        <option value="<?= $value; ?>"><?= $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label py-2">Expiration Date</label>
                                    <input type="date" class="form-control" name="EDIT_EXPIRATION" id="EDIT_EXPIRATION" >
                                </div>
                                <div class="col-md-12 py-2">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" name="EDIT_REMARKS" id="EDIT_REMARKS" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>          
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="submit_edit_stock" class="btn btn-outline-primary" id="submit_edit_stock">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
                </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

<div class="modal fade" id="delete_product_stock_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete the stock?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_stock_form" style="display: inline-block;">
                    <input type="hidden" name="DELETE_STOCK_ID" id="DELETE_STOCK_ID" value="">
                    <input type="hidden" name="DELETE_TABLE_ID" id="DELETE_TABLE_ID" value="">
                    <input type="hidden" name="DELETE_QUANTITY" id="DELETE_QUANTITY" value="">                  
                    <input type="hidden" name="DELETE_PRODUCT_NAME" id="DELETE_PRODUCT_NAME" value="<?php echo $row['PRODUCT_NAME'] ?>">
                   
                    <button name="" type="button" id="submit_delete_stock" class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- End delete employee photo Modal-->

