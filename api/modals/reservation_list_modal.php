<div class="modal fade" id="approval_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Select Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="reserve_approval_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" id="ID" name="ID">
                            <input type="hidden" id="EMAIL" name="EMAIL">
                            <label for="nameWithTitle" class="form-label">Status</label>
                            <select name="approval_status" id="approval_status" class="form-select">
                                <option value="APPROVED">APPROVED</option>
                                <option value="DECLINED">DECLINED</option>
                            </select>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Please provide message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-label-primary" id="submit_approval_btn">Save changes</button>

                    <button class="btn btn-label-primary d-none" type="button" id="submit_icon" disabled>
                        <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>