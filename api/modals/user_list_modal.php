<div class="modal fade" id="add_user_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="add_user_form">

                    <div class="tab-pane fade show active" id="USER" role="tabpanel">
                        <div class="row">

                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-3">
                                <label class="form-label">First Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="fname" id="fname">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="mname" id="mname">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Last Name<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="lname" id="lname">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">Suffix</label>
                                <input type="text" class="form-control" name="suffix" id="suffix">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email<span class="require asterisk">*</span></label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No.<span class="require asterisk">*</span></label>
                                <input type="number" class="form-control" name="contact" id="contact"
                                    onkeypress="if(this.value.length==11) return false; return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Access<span class="require asterisk">*</span></label>
                                <select name="access" id="access" class="form-select">
                                    <option value="" disabled hidden selected>Access</option>
                                    <?php foreach (ACCESS as $value) { ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="username" id="username">
                            </div>
                            <div class="col-md-6 form-password-toggle">
                                <label class="form-label">Password<span class="require asterisk">*</span></label>
                                <!-- <input type="" class="form-control" name="password" id="password" > -->
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password"
                                        onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                        </div>
                    </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-label-secondary">Reset</button>
                <button type="button" name="add_user_btn" class="btn btn-label-primary" id="add_user_btn">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

<!-- ######################################################## USER ADD MODAL ########################################################################################################## -->

<div class="modal fade" id="change_room_access_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Please select the reservation access for the user (<span id="fullname"></span>) ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="change_room_access_form">

                    <div class="tab-pane fade show active" id="USER" role="tabpanel">
                        <div class="row">

                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-12">
                                <input type="hidden" id="access_id" name="access_id">
                                <input type="hidden" id="fullname" name="fullname">
                                <input type="hidden" id="old_access" name="old_access">
                                <select name="new_access" id="new_access" class="form-select">
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="ENCODER">ENCODER</option>
                                    <option value="USER">USER</option>
                                </select>
                            </div>

                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="change_access_info" class="btn btn-label-primary btn-page-block" id="change_access_info">Submit</button>
                <!-- <button class="btn btn-label-primary d-none" type="button" id="add_user_icon" disabled>
                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button> -->
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>