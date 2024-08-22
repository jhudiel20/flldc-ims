<div class="modal fade" id="staticBackdropPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit User Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="">
                    <input type="hidden" name="ID" id="id" value="<?php echo $user_id ?>">
                    <div class="form-message alert alert-danger" role="alert"></div>
                    <div class="col-md-12">
                        <label class="form-label">Username<span class="require">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php if($_COOKIE['ACCESS'] != 'ADMIN'){echo $user['USERNAME'];} ?>" onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;">
                    </div>
                    <div class="col-md-12 form-password-toggle">
                        <label class="form-label">New Password<span class="require">*</span></label>
                        <!-- <input type="password" id="password" name="password" value="" class="form-control" onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;"> -->
                        <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password"
                                            onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                    </div>
                    <div class="col-md-12 form-password-toggle">
                        <label class="form-label">Confirm New Password<span class="require">*</span></label>
                        <!-- <input type="password" id="newpassword" name="newpassword" value="" class="form-control" onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;"> -->
                        <div class="input-group input-group-merge">
                                        <input type="password" id="newpassword" class="form-control" name="newpassword"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password"
                                            onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="submit" class="btn btn-outline-primary" id="">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>