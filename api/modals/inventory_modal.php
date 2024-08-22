<style>
.asterisk {
    font-size: 22px;
}
</style>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Inventory for <span id="name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary mb-2" id="download-xlsx-inv-details"><i class="fa-solid fa-download"></i> XLSX</button>
                <button class="btn btn-primary mb-2" id="download-pdf-inv-details"><i class="fa-solid fa-download"></i> PDF</button>

                <div class="tabulator-table" id="inventory-details-list-table" style="font-size:14px;"> </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="button" name="submit" class="btn btn-outline-primary" style="color:white"
                    id="add_trainings_detail">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="edit_inventory_details_modal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="edit_stock_form">

                    <div class="tab-pane fade show active" id="user" role="tabpanel">
                        <div class="row">
                            <input type="hidden" name="EDIT_PRODUCT_ID" id="EDIT_PRODUCT_ID" value="">
                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-6">
                                <label class="form-label">Product Code<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" value="<?php echo $row['PRODUCT_CODE']?>"
                                    placeholder="<?php echo $row['PRODUCT_CODE']?>" disabled>
                                <input type="hidden" class="form-control" name="PRODUCT_CODE" id="PRODUCT_CODE"
                                    value="<?php echo $row['PRODUCT_CODE']?>"
                                    placeholder="<?php echo $row['PRODUCT_CODE']?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Product Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" value="<?php echo $row['NAME']?>"
                                    placeholder="<?php echo $row['PRODUCT_CODE']?>" disabled>
                                <input type="hidden" class="form-control" name="PRODUCT_NAME" id="PRODUCT_NAME"
                                    value="<?php echo $row['NAME']?>" placeholder="<?php echo $row['PRODUCT_CODE']?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quantity<span class="require asterisk">*</span></label>
                                <input type="number" class="form-control" name="EDIT_QUANTITY" id="EDIT_QUANTITY">
                            </div>
                                    <input type="hidden" class="form-control" name="EDIT_PRICE" id="EDIT_PRICE" value="<?php echo $row['PRICE']?>">
                                    <input type="hidden" class="form-control" name="EDIT_UNIT" id="EDIT_UNIT" value="<?php echo $row['ON_HAND']?>">
                                    <input type="hidden" class="form-control" name="EDIT_COMPANY" id="EDIT_COMPANY" value="<?php echo $row['SUPPLIER_ID']?>">
                                    <input type="hidden" class="form-control" name="EDIT_DESCRIPTION" id="EDIT_DESCRIPTION" value="<?php echo $row['DESCRIPTION']?>">
                                    <input type="hidden" class="form-control" name="EDIT_CATEGORY_NAME" id="EDIT_CATEGORY_NAME" value="<?php echo $row['CATEGORY_NAME']?>">
                                    <input type="hidden" class="form-control" name="EDIT_SUBCATEGORY_NAME" id="EDIT_SUBCATEGORY_NAME" value="<?php echo $row['SUBCATEGORY_NAME']?>">

                            <div class="col-md-6">
                                <label class="form-label">Expiration Date<span class="require asterisk">*</span></label>
                                <input type="date" class="form-control" name="EDIT_EXPIRY_DATE" id="EDIT_EXPIRY_DATE">
                            </div>

                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="submit" class="btn btn-outline-primary" style="color:white"
                    id="submit_edit_stock">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>
<div class="modal fade" id="delete_inventory_details_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to delete this the stock?</i></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <form method="post" id="delete_stock_form" style="display: inline-block;">
          <input type="hidden" name="DELETE_PRODUCT_ID" id="DELETE_PRODUCT_ID" value="">
          <input type="hidden" name="DELETE_PRODUCT_NAME" id="DELETE_PRODUCT_NAME" value="">
          <input type="hidden" name="DELETE_QUANTITY" id="DELETE_QUANTITY" value="">

          
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button name="" type="button" id="submit_delete_stock" class="btn btn-outline-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
