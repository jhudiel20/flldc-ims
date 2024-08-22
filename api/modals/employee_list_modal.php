<style>
    a.btn,
a.button,
a[type="button"] {
  color: white;
  text-decoration: none;
}
</style>


<div class="modal fade" id="employee-details-edit-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Employee Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="edit_employee_form">

                    <div class="tab-pane fade show active" id="user" role="tabpanel">
                        <div class="row">
                            <input type="hidden" name="EMPLOYEE_ID" id="EMPLOYEE_ID" value="">
                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-6">
                                <label class="form-label">First Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="FNAME" id="FNAME">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="LNAME" id="LNAME">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">GENDER<span class="require asterisk">*</span></label>
                                <select name="GENDER" id="GENDER" class="form-select">
                                    <option value="" disabled hidden selected>Access</option>
                                    <?php foreach (GENDER as $value) { ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email<span class="require asterisk">*</span></label>
                                <input type="email" class="form-control" name="EMAIL" id="EMAIL">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="CP" id="CP">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role<span class="require asterisk">*</span></label>
                                <select name="JOB" id="JOB" class="form-select">
                                    <option value="" disabled hidden selected>Access</option>
                                    <?php foreach (ROLE as $value) { ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hired Date</label>
                                <input type="date" class="form-control" name="HIRED" id="HIRED">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Province</label>
                                <input type="text" class="form-control" name="PROVINCE" id="PROVINCE">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City/Municipality</label>
                                <input type="text" class="form-control" name="CITY" id="CITY">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Barangay</label>
                                <input type="text" class="form-control" name="BARANGAY" id="BARANGAY">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" name="UNIT" id="UNIT">
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
                <a type="button" name="submit" class="btn btn-primary" id="submit_edit_employee">Submit</a>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

<div class="modal fade" id="delete_employee_info_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete this employee ?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_user_form" style="display: inline-block;">
                    <input type="hidden" name="DELETE_ID" id="DELETE_ID" value="">
                    <input type="hidden" name="DELETE_FNAME" id="DELETE_FNAME" value="">
                    <input type="hidden" name="DELETE_LNAME" id="DELETE_LNAME" value="">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a name="" type="button" id="delete_employee_info" class="btn btn-danger">Delete</a>
                </form>
            </div>
        </div>
    </div>
</div>