<!-- <style>
a.btn,
a.button,
a[type="button"] {
    color: white;
    text-decoration: none;
}
</style> -->
<div class="modal fade" id="edit_category_info_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Category Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="edit_position_form">
                    <div class="tab-pane fade show active" id="" role="tabpanel">
                        <div class="row">
                            <input type="hidden" name="CATEGORY_ID" id="CATEGORY_ID" value="">
                            <input type="hidden" class="form-control" name="CATEGORY_NAME_OLD" id="CATEGORY_NAME_OLD">
                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-12">
                                <label class="form-label">Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="CATEGORY_NAME" id="CATEGORY_NAME">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Classification<span class="require asterisk">*</span></label>
                                <select name="CATEGORY_INFO" id="CATEGORY_INFO" class="form-select">
                                    <option value="" disabled hidden selected>Classification</option>
                                    <?php foreach (CLASSES as $value) { ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="submit" class="btn btn-outline-primary" id="submit_edit_category_info">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

<div class="modal fade" id="delete_category_info_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete <span id="DELETE_NAME"></span> category  ?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_category_form" style="display: inline-block;">
                    <input type="hidden" name="DELETE_ID" id="DELETE_ID" value="">
                    <input type="hidden" name="VALUE_DELETE_NAME" id="VALUE_DELETE_NAME" value="">
                    <input type="hidden" name="DELETE_INFO" id="DELETE_INFO" value="">

                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="" type="button" id="delete_category_info" class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>