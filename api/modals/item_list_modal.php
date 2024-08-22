<div class="modal fade" id="add_item_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="add_item_form">

                    <div class="tab-pane fade show active" id="user" role="tabpanel">
                        <div class="row">

                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-6">
                                <label class="form-label">Item Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="ITEM_NAME" id="ITEM_NAME">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Brand<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="BRAND_NAME" id="BRAND_NAME">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Model<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="MODEL" id="MODEL">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quantity<span class="require asterisk">*</span></label>
                                <input type="number" class="form-control" name="QTY" id="QTY"
                                    onKeyPress="if(this.value.length==4) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label py-1">Specs </label>
                                <textarea class="form-control" name="SPECS" id="SPECS" type="text" cols="30"
                                    rows="5"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Price<span class="require asterisk">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" name="PRICE" id="PRICE"
                                        onKeyPress="if(this.value.length==12) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)"
                                        oninput="if(this.value!=''){this.value = parseFloat(this.value.replace(/,/g, '')).toLocaleString('en-US', {style: 'decimal', maximumFractionDigits: 0, minimumFractionDigits: 0})}">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Purchased Date<span class="require asterisk">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">₱</span>
                                    <input type="date" class="form-control" name="PURCHASED_DATE" id="PURCHASED_DATE">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Warranty Date<span class="require asterisk">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">₱</span>
                                    <input type="date" class="form-control" name="WARRANTY_DATE" id="warranty_date">
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <label class="form-label">Supplier<span class="require asterisk">*</span></label>
                                <select name="SUPPLIER" id="SUPPLIER" class="form-select">
                                    <option value="" disabled hidden selected>Supplier</option>
                                    <?php   $supplier_call = mysqli_query($conn,"SELECT * FROM `supplier` ");
                                            while ($r_supplier_call = mysqli_fetch_assoc($supplier_call)) {
                                    ?>
                                            <option value="<?php echo $r_supplier_call['COMPANY_NAME'];?>"><?php echo $r_supplier_call['COMPANY_NAME'];?></option>
                                    <?php } ?>
                                </select>
                            </div> -->
                            <div class="col-md-6 ">
                                <label class="form-label">Product Photo</label>
                                <input class="form-control" type="file" id="PHOTO" name="PHOTO">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category<span class="require asterisk">*</span></label>
                                <select name="CATEGORY" id="CATEGORY" class="form-select">
                                    <option value="" disabled hidden selected>Category Name</option>
                                    <?php   $supplier_call = mysqli_query($conn,"SELECT * FROM `category` WHERE INFO = 'Category' ");
                                            while ($r_supplier_call = mysqli_fetch_assoc($supplier_call)) {
                                    ?>
                                    <option value="<?php echo $r_supplier_call['NAME'];?>">
                                        <?php echo $r_supplier_call['NAME'];?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subcategory</label>
                                <select name="SUBCATEGORY" id="SUBCATEGORY" class="form-select">
                                    <option value="" disabled hidden selected>Subcategory Name</option>
                                    <?php   $supplier_call = mysqli_query($conn,"SELECT * FROM `category` WHERE INFO = 'Subcategory' ");
                                            while ($r_supplier_call = mysqli_fetch_assoc($supplier_call)) {
                                    ?>
                                    <option value="<?php echo $r_supplier_call['NAME'];?>">
                                        <?php echo $r_supplier_call['NAME'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label py-1">Remarks </label>
                                <textarea class="form-control" name="REMARKS" id="REMARKS" type="text" cols="30"
                                    rows="5"></textarea>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                <button type="button" name="submit" class="btn btn-outline-primary"
                    id="submit_add_item">Submit</button>
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>