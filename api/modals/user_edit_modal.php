<div class="modal fade" id="user_edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit User Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="user_edit_form">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $user_id ?>">
                    <div class="form-message alert alert-danger" role="alert"></div>
                    <div class="col-md-3">
                        <label class="form-label">First Name<span class="require">*</span></label>
                        <input type="text" class="form-control" name="Firstname" value="<?php echo $user['fname']; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Middle Name<span class="require"></span></label>
                        <input type="text" name="Middlename" value="<?php echo $user['mname']; ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Last Name<span class="require">*</span></label>
                        <input type="text" name="Lastname" value="<?php echo $user['lname']; ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Suffix<span class="require"></span></label>
                        <input type="text" name="extn" value="<?php echo $user['ext_name']; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Address<span class="require">*</span></label>
                        <input type="Email" name="Email" value="<?php echo $user['email']; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact No.<span class="require">*</span></label>
                        <input type="text" name="Contact" value="<?php echo $user['contact']; ?>" class="form-control">
                    </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-outline-primary" id="user_edit_info">Submit</button>
                <button class="btn btn-label-primary d-none" type="button" id="request_icon" disabled>
                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>