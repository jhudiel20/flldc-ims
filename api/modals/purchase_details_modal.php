


<div class="modal fade" id="upload-PO_ATTACHMENT-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please upload attachment in PDF/JPG/JPEG/PNG format!!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="dropzone_basic">
                    <input type="file" id="attach" name="attach" class="form-control">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" id="uploaded_item_name" name="uploaded_item_name" class="form-control"
                        value="<?php echo $row['item_name']?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="submit_po_attachments" class="btn btn-label-primary">Upload</button>
                <button class="btn btn-label-primary d-none" type="button" id="submit_icon" disabled>
                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-PO_ATTACHMENT-modal" tabindex="-1">
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
                    <input type="hidden" name="DELETE_ITEM_NAME" id="DELETE_ITEM_NAME"
                        value="<?php echo $row['item_name'] ?>">
                    <input style="width:auto" type="hidden" name="attachment_to_delete" class="form-control"
                        style="margin-bottom:10px" value="<?php echo $row['attachments']; ?>">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" name="delete_po_attachments" id="delete_po_attachments"
                        class="btn btn-label-danger">Delete</button>
                        <button class="btn btn-label-primary d-none" type="button" id="delete_po_icon" disabled>
                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                </form>
            </div>
        </div>
    </div>
</div>