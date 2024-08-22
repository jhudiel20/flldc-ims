<style>
a.btn,
a.button,
a[type="button"] {
    color: white;
    text-decoration: none;
}
</style>
<div class="modal fade" id="edit_supplier_info_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Supplier Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="edit_supplier_form">
                    <div class="tab-pane fade show active" id="" role="tabpanel">
                        <div class="row">
                            <input type="hidden" name="EDIT_SUPPLIER_ID" id="EDIT_SUPPLIER_ID" value="">
                            <input type="hidden" name="EDIT_COMPANY_NAME_OLD" id="EDIT_COMPANY_NAME_OLD" value="">
                            
                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-12">
                                <label class="form-label">Company Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="EDIT_COMPANY_NAME" id="EDIT_COMPANY_NAME">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Company Address/Location<span
                                        class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="EDIT_ADDRESS" id="EDIT_ADDRESS">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Company Phone/Telephone<span
                                        class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="EDIT_PHONE_NUMBER" id="EDIT_PHONE_NUMBER">
                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a type="button" name="submit" class="btn btn-primary" id="submit_edit_supplier_info">Submit</a>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

<div class="modal fade" id="delete_supplier_info_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete <span id="SPAN_COMPANY_NAME"></span> company ?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_category_form" style="display: inline-block;">
                    <input type="hidden" name="DELETE_ID" id="DELETE_ID" value="">
                    <input type="hidden" name="VALUE_DELETE_NAME" id="VALUE_DELETE_NAME" value="">
                    <input type="hidden" name="DELETE_INFO" id="DELETE_INFO" value="">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a name="" type="button" id="delete_category_info" class="btn btn-danger">Delete</a>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="company_products_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Products of <span id="SHOW_COMPANY_NAME"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="add_stock_form">
                <div class="tabulator-table" id="view-products-table" style="font-size:13px"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
                <a type="button" name="submit" class="btn btn-primary" style="color:white"
                    id="submit_add_stock">Submit</a>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>