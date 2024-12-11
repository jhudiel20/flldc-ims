<div class="modal fade" id="upload-po-attachment-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please upload attachment in PDF/JPG/JPEG/PNG format!!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="upload_po_attachments_form">
                    <input type="file" id="attach" name="attach" class="form-control">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" name="pr_id" id="pr_id" value="<?php echo $row['pr_id']; ?>">
                    <input type="hidden" id="item_name" name="item_name" class="form-control"
                        value="<?php echo $row['item_name']?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="upload_po_attachments_btn" class="btn btn-label-primary btn-page-block">Upload</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-po-attachment-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete the attachment?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_po_attachments_form" style="display: inline-block;">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" name="item_name" id="item_name" value="<?php echo $row['item_name'] ?>">
                    <input type="hidden" name="pr_id" id="pr_id" value="<?php echo $row['pr_id']; ?>">
                    <input style="width:auto" type="hidden" name="attachment_to_delete" class="form-control"
                        style="margin-bottom:10px" value="<?php echo $row['attachments']; ?>">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="delete_po_attachments_btn" id="delete_po_attachments_btn"
                        class="btn btn-label-danger btn-page-block">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_purchase_photo_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete a photo?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_purchase_photo_form" style="display: inline-block;">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" name="pr_id" id="pr_id" value="<?php echo $row['pr_id'] ?>">
                    <input type="hidden" name="item_name" id="item_name" value="<?php echo $row['item_name'] ?>">
                    <input type="hidden" name="item_to_delete" id="item_to_delete" class="form-control" value="<?php echo $row['item_photo']; ?>">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="delete_purchase_photo_btn" class="btn btn-danger btn-page-block">Delete</button>

                </form>
            </div>
        </div>
    </div>
</div>
