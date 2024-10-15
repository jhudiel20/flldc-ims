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


<div class="modal fade" id="delete-profile-photo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to remove profile photo?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_photo_form" class="nav-link ">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="" type="button" id="photo_delete_btn" class="btn btn-label-danger">Delete</button>
                    <button class="btn btn-label-primary d-none" type="button" id="photo_delete_icon" disabled>
                        <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <input type="hidden" name="user_photo_fname" id="user_photo_fname" value="<?php echo $user['fname'] . ' ' . $user['lname']; ?>">
                    <input type="hidden" name="photo_to_delete" value="<?php echo $user['image']; ?>">
                    <input  type="hidden" name="ID" id="ID" value="<?php echo $user_id?>">
                </form>
            </div>
        </div>
    </div>
</div><!-- End delete profile photo Modal-->