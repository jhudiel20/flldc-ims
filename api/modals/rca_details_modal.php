<div class="modal fade" id="upload_rca_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please upload attachment in PDF/JPG/JPEG/PNG format!!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="add_rca_attachments_form">
                    <input type="file" id="rca_attach" name="rca_attach" class="form-control">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" name="rca_id" id="rca_id" value="<?php echo $row['rca_id'] ?>">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-label-primary" id="upload_rca_btn">Upload</button>
                <button class="btn btn-label-primary d-none" type="button" id="loading_icon" disabled>
                                                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                                    Loading...
                                                                </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_rca_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete the attachment?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_rca_attachments_form" style="display: inline-block;">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" name="rca_id" id="rca_id" value="<?php echo $row['rca_id'] ?>">
                    <input type="hidden" id="attachment_to_delete" name="attachment_to_delete" class="form-control" style="margin-bottom:10px" value="<?php echo $row['attachments']; ?>">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-label-danger" id="delete_rca_btn">Delete</button>
                    <button class="btn btn-label-danger d-none" type="button" id="loading_icon" disabled>
                                                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                                    Loading...
                                                                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="upload_pcv_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please upload attachment in PDF/JPG/JPEG/PNG format!!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="add_pcv_attachments_form">
                    <input type="file" id="pcv_attach" name="pcv_attach" class="form-control">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" name="pcv_id" id="pcv_id" value="<?php echo $row['rca_id'] ?>">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-label-primary" id="upload_pvc_btn">Upload</button>
                <button class="btn btn-label-primary d-none" type="button" id="loading_icon" disabled>
                                                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                                    Loading...
                                                                </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_pcv_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete the attachment?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_pcv_attachments_form" style="display: inline-block;">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" name="pcv_id" id="pcv_id" value="<?php echo $row['rca_id'] ?>">
                    <input type="hidden" name="attachment_to_delete" id="attachment_to_delete" class="form-control" style="margin-bottom:10px" value="<?php echo $row['attachments']; ?>">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-label-danger" id="delete_pvc_btn" >Delete</button>
                    <button class="btn btn-label-danger d-none" type="button" id="loading_icon" disabled>
                                                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                                    Loading...
                                                                </button>
                </form>
            </div>
        </div>
    </div>
</div>