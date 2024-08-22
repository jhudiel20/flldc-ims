<div class="modal fade" id="transaction_status_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Select Status of Transaction ID: <strong><span
                        id="TRANSACTION_ID_TEXT"></span></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="transaction_status_form">
                    <div class="col mb-0">
                        <input type="hidden" name="TRANSACTION_ID" id="TRANSACTION_ID">
                        <label for="nameSmall" class="form-label">Select Transaction Status</label>
                        <select name="TRANSACTION_STATUS" id="TRANSACTION_STATUS" class="form-select">
                            <option value="" disabled hidden selected>Deliver Status</option>
                            <?php foreach (TRANSAC_STATUS as $value) { ?>
                                <option value="<?= $value; ?>"><?= $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col mb-0">
                        <label class="form-label" for="emailSmall">Customer Name</label>
                        <input type="text" class="form-control" id="TRANSACTION_CUSTOMER" name="TRANSACTION_CUSTOMER" disabled>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary" id="submit_delivery_status" >Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="update_transaction_modal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Check the checkbox that you want to update the status to <strong>"DELIVERED & PAID"</strong>.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="checklist_transaction_status_form">
                    <div class="col mb-0">

                    <div class="tabulator-table" id="shipping-checklist-table" style="font-size:14px;"></div>


                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button class="btn btn-outline-primary" data-bs-target="#modalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Save changes</button> -->

                <button type="button" class="btn btn-outline-primary" id="btn_update_delivery_status" >Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
