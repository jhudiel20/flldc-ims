<div class="modal fade" id="edit_item_info_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Item for : <span id="ITEM_NAME_SPAN"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="edit_product_form">

                    <div class="tab-pane fade show active" id="user" role="tabpanel">
                        <div class="row">
                            <input type="text" name="EDIT_ID" id="EDIT_ID" value="">
                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-6">
                                <label class="form-label">Item Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="EDIT_ITEM_NAME" id="EDIT_ITEM_NAME">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Brand Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="EDIT_BRAND_NAME" id="EDIT_BRAND_NAME">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Model<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="EDIT_MODEL" id="EDIT_MODEL">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quantity<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="EDIT_QUANTITY" id="EDIT_QUANTITY">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Specification</label>
                                <textarea class="form-control" name="EDIT_SPECS" id="EDIT_SPECS" cols="" rows="5" value="" placeholder=""></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Price<span class="require asterisk">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" name="PRICE" id="PRICE"
                                        onKeyPress="if(this.value.length==12) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)"
                                        oninput="if(this.value!=''){this.value = parseFloat(this.value.replace(/,/g, '')).toLocaleString('en-US', {style: 'decimal', maximumFractionDigits: 0, minimumFractionDigits: 0})}">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <label class="form-label">Unit type<span class="require asterisk">*</span></label>
                                <select name="TYPE" id="TYPE" class="form-select">
                                    <option value="" disabled hidden selected>Measurement</option>
                                    <?php foreach (UNIT as $value) { ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div> -->
                            <!-- <div class="col-md-12">
                                <label class="form-label">Supplier<span class="require asterisk">*</span></label>
                                <select name="SUPPLIER_NAME" id="SUPPLIER_NAME" class="form-select">
                                    <option value="" disabled hidden selected>Supplier</option>
                                    <?php   $supplier_call = mysqli_query($conn,"SELECT * FROM `supplier` ");
                                            while ($r_supplier_call = mysqli_fetch_assoc($supplier_call)) {
                                    ?>
                                            <option value="<?php echo $r_supplier_call['COMPANY_NAME'];?>"><?php echo $r_supplier_call['COMPANY_NAME'];?></option>
                                    <?php } ?>
                                </select>
                            </div> -->
                         
                            <div class="col-md-6">
                                <label class="form-label">Purchased Date<span class="require asterisk">*</span></label>
                                <input type="date" class="form-control" name="EDIT_PURCHASED_DATE" id="EDIT_PURCHASED_DATE">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Warranty Date<span class="require asterisk">*</span></label>
                                <input type="date" class="form-control" name="EDIT_WARRANTY_DATE" id="EDIT_WARRANTY_DATE">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category<span class="require asterisk">*</span></label>
                                <select class="form-select" name="EDIT_CATEGORY_NAME" id="EDIT_CATEGORY_NAME">
                                    <option value="" disabled hidden selected>Category Name</option>
                                    <?php   $supplier_call = mysqli_query($conn,"SELECT * FROM `category` WHERE INFO = 'Category' ");
                                            while ($r_supplier_call = mysqli_fetch_assoc($supplier_call)) {
                                    ?>
                                            <option value="<?php echo $r_supplier_call['NAME'];?>"><?php echo $r_supplier_call['NAME'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subcategory<span class="require asterisk">*</span></label>
                                <select class="form-select" name="EDIT_SUBCATEGORY_NAME" id="EDIT_SUBCATEGORY_NAME" >
                                    <option value="" disabled hidden selected>Subcategory Name</option>
                                    <?php   $supplier_call = mysqli_query($conn,"SELECT * FROM `category` WHERE INFO = 'Subcategory' ");
                                            while ($r_supplier_call = mysqli_fetch_assoc($supplier_call)) {
                                    ?>
                                            <option value="<?php echo $r_supplier_call['NAME'];?>"><?php echo $r_supplier_call['NAME'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                        </div>
                    </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="submit" class="btn btn-outline-primary" id="submit_edit_product">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

<div class="modal fade" id="delete_product_info_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete (<span id="DELETE_PRODUCT_NAME_SPAN"></span>) product ? All of the stocks of the product will be deleted !</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_product_form" style="display: inline-block;">
                    <input type="hidden" name="DELETE_PRODUCT_ID" id="DELETE_PRODUCT_ID" value="">
                    <input type="hidden" name="DELETE_PRODUCT_NAME" id="DELETE_PRODUCT_NAME" value="">
                    <input type="hidden" name="DELETE_PRODUCT_CODE" id="DELETE_PRODUCT_CODE" value="">
              

                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="delete_product_info" class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>