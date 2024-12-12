<div class="modal fade" id="edit_user_info_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit User Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="edit_user_form">

                    <div class="tab-pane fade show active" id="user" role="tabpanel">
                        <div class="row">
                            <input type="hidden" name="ID" id="ID" value="">
                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-3">
                                <label class="form-label">First Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="FNAME" id="FNAME">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="MNAME" id="MNAME">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Last Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="LNAME" id="LNAME">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Suffix</label>
                                <input type="text" class="form-control" name="SUFFIX" id="SUFFIX">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email<span class="require asterisk">*</span></label>
                                <input type="email" class="form-control" name="EMAIL" id="EMAIL">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact<span class="require asterisk">*</span></label>
                                <input type="number" class="form-control" name="CONTACT" id="CONTACT" onkeydown="return /[0-9]/.test(event.key)">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Access<span class="require asterisk">*</span></label>
                                <select name="ACCESS" id="ACCESS" class="form-select">
                                    <option value="" disabled hidden selected>Access</option>
                                    <?php foreach (ACCESS as $value) { ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                        </div>
                    </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-label-secondary">Reset</button>
                <button type="button" name="edit_userlist_info_btn" class="btn btn-label-primary" id="edit_userlist_info_btn">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

<div class="modal fade" id="clear_attempts_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        remove the attempts of this user account ?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="clear_attempts_form" style="display: inline-block;">
                    <input type="hidden" name="clear_id" id="clear_id" value="">

                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="submit_clear_attempts_btn" type="button" id="submit_clear_attempts_btn" class="btn btn-label-primary">Clear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_user_info_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete this user account ?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_user_form" style="display: inline-block;">
                    <input type="hidden" name="DELETE_ID" id="DELETE_ID" value="">
                    <input type="hidden" name="DELETE_FNAME" id="DELETE_FNAME" value="">
                    <input type="hidden" name="DELETE_LNAME" id="DELETE_LNAME" value="">

                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="delete_userlist_info_btn" type="button" id="delete_userlist_info_btn" class="btn btn-label-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approval_account_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to approve the account registration?</i></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <form method="post" id="approvalForm" style="display: inline-block;">
          <input type="hidden" name="IDuser" id="IDuser" value="">
          <input type="hidden" name="First_Name" id="First_Name" value="">
          <input type="hidden" name="Last_Name" id="Last_Name" value="">

          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button name="approved_acc_info_btn" type="button" id="approved_acc_info_btn" class="btn btn-label-success">Approved</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="disapproval_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to disapprove the account registration?</i></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <form method="post" id="disapprovalForm" style="display: inline-block;">
          <input type="hidden" name="Disapproved_Fname" id="Disapproved_Fname" value="">
          <input type="hidden" name="Disapproved_Lname" id="Disapproved_Lname" value="">
          <input type="hidden" name="UserID" id="UserID" value="">

          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button name="disapproved_acc_info_btn" type="button" id="disapproved_acc_info_btn" class="btn btn-label-danger">Disapproved</button>
        </form>
      </div>
    </div>
  </div>
</div>
