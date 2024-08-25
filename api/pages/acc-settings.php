<?php 

require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if (isset($_COOKIE['secure_data'])) {
    $decrypted_array = decrypt_cookie($_COOKIE['secure_data'], $encryption_key, $cipher_method);
}
if (!isset($decrypted_array['ACCESS'])) {
    header("Location:index.php");
}

$user_id = $decrypted_array['ID'];

$stmt = $conn->prepare("SELECT * FROM user_account WHERE ID = :user_id");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);


?>
<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <?php
    include __DIR__ . "/../action/global/metadata.php";
    include __DIR__ . "/../action/global/include_top.php";
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <?php
        include __DIR__ . "/../action/global/sidebar.php";
        include __DIR__ . "/../action/global/header.php"; 
        ?>

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                    <div class="container flex-grow-1 container-p-y">
                        <h4 id="section-title" class="py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="nav-align-top mb-2">
                                        <ul class="nav nav-pills flex-column flex-md-row mb-3" role="tablist">
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                            data-bs-target="#profile-info" aria-controls="navs-justified-profile-info"
                                                            aria-selected="true">
                                                            <i class="bx bx-user me-1"></i> Account
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                            data-bs-target="#security-info" aria-controls="navs-justified-security-info"
                                                            aria-selected="false">
                                                            <i class="bx bx-lock-alt me-1"></i> Security
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade" id="profile-info" role="tabpanel">
                                                <div class="card-body mb-4">
                                                    <h5 class="card-header">Profile Details</h5>
                                                    <!-- Account -->
                                                    <div class="card-body mb-3">
                                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                                        <img src="/image_proxy.php?file=<?php echo urlencode($user['image'] ?? 'default.png'); ?>" alt="user-avatar"
                                                                class="d-block rounded"
                                                                height="100"
                                                                width="100"
                                                                id="uploadedAvatar">
                                                            <div class="button-wrapper">
                                                                <form class="" method="POST" id="upload_photo_form" enctype="multipart/form-data" style="display: inline-block;">
                                                                    <label for="upload" class="" tabindex="0">
                                                                        <input type="file" name="image" id="" class="form-control mb-1">
                                                                        <input type="text" name="user_submit_name" id="user_submit_name" value="<?php echo $user['fname'] . ' ' . $user['lname']; ?>">
                                                                        <input type="text" name="ID" id="ID" value="<?php echo $user_id ?>">  
                                                                        <button type="submit" id="submit_photo" value="Upload" class="btn btn-label-primary"><i class="fa-solid fa-upload"></i> Upload</button>
                                                                </form>
                                                                <form style="display: inline-block;" class="mt-1">          
                                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#delete-profile-photo" class="btn btn-label-danger"><i class="fas fa-fw fa-trash"></i> Delete</button>
                                                                </form>
                                                                    </label>


                                                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="my-0 mb-3" />
                                                    <div class="card-body">
                                                        <form id="formAccountSettings" method="GET" onsubmit="return false">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label for="firstName" class="form-label">Full Name</label>
                                                                <input
                                                                    class="form-control"
                                                                    type="text"
                                                                    id="firstName"
                                                                    name="firstName"
                                                                    value="<?php echo $user['fname'] . ' ' . $user['mname'] . ' ' . $user['lname'] . ' ' . $user['ext_name'];?>"
                                                                    autofocus
                                                                    disabled />
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="lastName" class="form-label">Access Level</label>
                                                                <input class="form-control" type="text" value="<?php echo $user['access']; ?>" disabled/>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="email" class="form-label">E-mail</label>
                                                                <input
                                                                    class="form-control"
                                                                    type="text"
                                                                    id="email"
                                                                    name="email"
                                                                    value="<?php echo $user['email']; ?>"
                                                                    disabled />
                                                            </div>
                                                            <!-- <div class="mb-3 col-md-6">
                                                            <label for="organization" class="form-label">Organization</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="organization"
                                                                name="organization"
                                                                value="ThemeSelection" />
                                                            </div> -->
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                                                <div class="input-group input-group-merge">
                                                                    <!-- <span class="input-group-text">US (+1)</span> -->
                                                                    <input
                                                                    type="text"
                                                                    id="phoneNumber"
                                                                    name="phoneNumber"
                                                                    class="form-control"
                                                                    value="<?php echo $user['contact']; ?>"
                                                                    disabled />
                                                                </div>
                                                            </div>
                                                            <!-- <div class="mb-3 col-md-6">
                                                            <label for="address" class="form-label">Address</label>
                                                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" />
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                            <label for="state" class="form-label">State</label>
                                                            <input class="form-control" type="text" id="state" name="state" placeholder="California" />
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                            <label for="zipCode" class="form-label">Zip Code</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="zipCode"
                                                                name="zipCode"
                                                                placeholder="231465"
                                                                maxlength="6" />
                                                            </div> -->
                                                            <!-- <div class="mb-3 col-md-6">
                                                            <label class="form-label" for="country">Country</label>
                                                            <select id="country" class="select2 form-select">
                                                                <option value="">Select</option>
                                                                <option value="Australia">Australia</option>
                                                                <option value="Bangladesh">Bangladesh</option>
                                                                <option value="Belarus">Belarus</option>
                                                                <option value="Brazil">Brazil</option>
                                                                <option value="Canada">Canada</option>
                                                                <option value="China">China</option>
                                                                <option value="France">France</option>
                                                                <option value="Germany">Germany</option>
                                                                <option value="India">India</option>
                                                                <option value="Indonesia">Indonesia</option>
                                                                <option value="Israel">Israel</option>
                                                                <option value="Italy">Italy</option>
                                                                <option value="Japan">Japan</option>
                                                                <option value="Korea">Korea, Republic of</option>
                                                                <option value="Mexico">Mexico</option>
                                                                <option value="Philippines">Philippines</option>
                                                                <option value="Russia">Russian Federation</option>
                                                                <option value="South Africa">South Africa</option>
                                                                <option value="Thailand">Thailand</option>
                                                                <option value="Turkey">Turkey</option>
                                                                <option value="Ukraine">Ukraine</option>
                                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                                <option value="United Kingdom">United Kingdom</option>
                                                                <option value="United States">United States</option>
                                                            </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                            <label for="language" class="form-label">Language</label>
                                                            <select id="language" class="select2 form-select">
                                                                <option value="">Select Language</option>
                                                                <option value="en">English</option>
                                                                <option value="fr">French</option>
                                                                <option value="de">German</option>
                                                                <option value="pt">Portuguese</option>
                                                            </select>
                                                            </div> -->
                                                            <!-- <div class="mb-3 col-md-6">
                                                            <label for="timeZones" class="form-label">Timezone</label>
                                                            <select id="timeZones" class="select2 form-select">
                                                                <option value="">Select Timezone</option>
                                                                <option value="-12">(GMT-12:00) International Date Line West</option>
                                                                <option value="-11">(GMT-11:00) Midway Island, Samoa</option>
                                                                <option value="-10">(GMT-10:00) Hawaii</option>
                                                                <option value="-9">(GMT-09:00) Alaska</option>
                                                                <option value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
                                                                <option value="-8">(GMT-08:00) Tijuana, Baja California</option>
                                                                <option value="-7">(GMT-07:00) Arizona</option>
                                                                <option value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                                                <option value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
                                                                <option value="-6">(GMT-06:00) Central America</option>
                                                                <option value="-6">(GMT-06:00) Central Time (US & Canada)</option>
                                                                <option value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                                                <option value="-6">(GMT-06:00) Saskatchewan</option>
                                                                <option value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                                                <option value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
                                                                <option value="-5">(GMT-05:00) Indiana (East)</option>
                                                                <option value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
                                                                <option value="-4">(GMT-04:00) Caracas, La Paz</option>
                                                            </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                            <label for="currency" class="form-label">Currency</label>
                                                            <select id="currency" class="select2 form-select">
                                                                <option value="">Select Currency</option>
                                                                <option value="usd">USD</option>
                                                                <option value="euro">Euro</option>
                                                                <option value="pound">Pound</option>
                                                                <option value="bitcoin">Bitcoin</option>
                                                            </select>
                                                            </div> -->
                                                        </div>
                                                        <div class="mt-2">
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#user_edit_modal" class="btn btn-label-primary w-100">Edit</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <!-- /Account -->
                                                </div>
                                                <hr class="my-0 mb-3" />
                                                        <h5 class="card-header mb-2">Delete Account</h5>
                                                        <div class="card-body">
                                                            <div class="mb-3 col-12 mb-0">
                                                                <div class="alert alert-warning">
                                                                    <h6 class="alert-heading fw-medium mb-1">Are you sure you want to delete your account?</h6>
                                                                    <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                                                                </div>
                                                            </div>
                                                            <form id="formAccountDeactivation" onsubmit="return false">
                                                                <div class="form-check mb-3">
                                                                    <input
                                                                    class="form-check-input"
                                                                    type="checkbox"
                                                                    name="accountActivation"
                                                                    id="accountActivation" />
                                                                    <label class="form-check-label" for="accountActivation"
                                                                    >I confirm my account deactivation</label
                                                                    >
                                                                </div>
                                                                <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                                                            </form>
                                                        </div>
                                            </div>
                                            <div class="tab-pane fade" id="security-info" role="tabpanel">
                                                <h5 class="card-header">Change Username</h5>
                                                <div class="card-body">
                                                    <form  method="post" id="change_username_form">
                                                        <input type="hidden" name="ID" id="id" value="<?php echo $user_id ?>">
                                                        <div class="row">
                                                        <div class="mb-3 col-md-6 form-password-toggle">
                                                            <label class="form-label" for="newPassword">Current Username</label>
                                                            <div class="input-group input-group-merge">
                                                                <input
                                                                    class="form-control"
                                                                    type="text"
                                                                    id="currentusername"
                                                                    name="currentusername"
                                                                    onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;" />
                                                                <!-- <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span> -->
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md-6 form-password-toggle">
                                                            <label class="form-label" for="confirmPassword">New Username</label>
                                                            <div class="input-group input-group-merge">
                                                                <input
                                                                    class="form-control"
                                                                    type="text"
                                                                    name="username"
                                                                    id="username"
                                                                    onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;"  />
                                                                <!-- <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-4">
                                                            <p class="fw-medium mt-2">Username Requirements:</p>
                                                            <ul class="ps-3 mb-0">
                                                            <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-12 mt-1">
                                                            <button type="button" class="btn btn-primary me-2" id="user_change_username">Save changes</button>
                                                            <!-- <button type="reset" class="btn btn-label-secondary">Cancel</button> -->
                                                        </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <hr class="my-4 mb-3" />

                                                <h5 class="card-header">Change Password</h5>
                                                <div class="card-body">
                                                    <form  method="post" id="user_password_form">
                                                        <input type="hidden" name="ID" id="id" value="<?php echo $user_id ?>">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6 form-password-toggle">
                                                                <label class="form-label" for="currentPassword">Current Password</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input
                                                                        class="form-control"
                                                                        type="password"
                                                                        name="currentpassword"
                                                                        id="currentpassword"
                                                                        onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;" 
                                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        <div class="mb-3 col-md-6 form-password-toggle">
                                                            <label class="form-label" for="newPassword">New Password</label>
                                                            <div class="input-group input-group-merge">
                                                                <input
                                                                    class="form-control"
                                                                    type="password"
                                                                    id="password"
                                                                    name="password"
                                                                    onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;" 
                                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md-6 form-password-toggle">
                                                            <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                                            <div class="input-group input-group-merge">
                                                                <input
                                                                    class="form-control"
                                                                    type="password"
                                                                    name="newpassword"
                                                                    id="newpassword"
                                                                    onKeyPress="if(event.charCode === 39 || event.charCode === 34) return false;" 
                                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-4">
                                                            <p class="fw-medium mt-2">Password Requirements:</p>
                                                            <ul class="ps-3 mb-0">
                                                            <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                                                            <li class="mb-1">At least one lowercase and one uppercase character</li>
                                                            <li>At least one number</li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-12 mt-1">
                                                            <button type="button" class="btn btn-primary me-2" id="user_change_pass">Save changes</button>
                                                            <!-- <button type="reset" class="btn btn-label-secondary">Cancel</button> -->
                                                        </div>
                                                        </div>
                                                    </form>
                                                </div>
                                        
                                                <!--/ Change Password -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                <!-- / Content -->

                <!-- Footer -->
                <?php 
                    include __DIR__ . "/../modals/user_edit_password_modal.php";
                    include __DIR__ . "/../modals/user_edit_modal.php";
                    include __DIR__. "/../action/global/footer.php";
                ?>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>



    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->



    <?php
        include __DIR__ . "/../action/global/include_bottom.php";
      ?>
</body>

<script>
        $(document).ready(function() {

            (function() {
                $('#user_edit_form').on('submit', function(e) {
                    e.preventDefault();            
                    $.ajax({
                        url: "/user_edit_info.php",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        beforeSend: function() {
                            $('#user_edit_info').hide();
                            $('#request_icon').removeClass('d-none').prop('disabled', true);
                        },
                        success: function(response) {
                            $('#request_icon').addClass('d-none').prop('disabled', false);
                            $('#user_edit_info').show();
                            console.log(response);
                            if (response.success) {
                                $('#staticBackdrop').modal('hide');
                                $('#user_edit_form')[0].reset();
                                swal({
                                    icon: 'success',
                                    title: response.title,
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    icon: 'warning',
                                    title: response.title,
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                })
                                $(".form-message").html(response.message);
                                $(".form-message").css("display", "block");
                            }
                        }
                    });
                })
            })();

                $('#user_change_pass').on('click', function() {
                    var formdata = new FormData(user_password_form);

                    $.ajax({
                        url: "/user_change_pass.php",
                        method: "POST",
                        data: formdata,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,

                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                $('#user_password_form')[0].reset();
                                swal({
                                    icon: 'success',
                                    title: response.title,
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    icon: 'warning',
                                    title: response.title,
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                })
                                $(".form-message").html(response.message);
                                $(".form-message").css("display", "block");
                            }
                        }
                    });
                });
                $('#user_change_username').on('click', function() {
                    var formdata = new FormData(elementById('#'));

                    $.ajax({
                        url: "../action/user_change_username.php",
                        method: "POST",
                        data: formdata,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,

                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                $('#change_username_form')[0].reset();
                                swal({
                                    icon: 'success',
                                    title: response.title,
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    icon: 'warning',
                                    title: response.title,
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                })
                                $(".form-message").html(response.message);
                                $(".form-message").css("display", "block");
                            }
                        }
                    });
                });

                $('#upload_photo_form').on('submit', function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        url: "/upload_user_photo.php",
                        method: "POST",
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                swal({
                                    icon: 'success',
                                    title: response.title,
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                }).then(function() {
                                    location.reload();
                                });

                            } else {
                                swal({
                                    icon: 'warning',
                                    title: response.title,
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                })
                            }
                        }
                    });
                });

            $('#photo_delete').on('click', function() {
                var formdata = new FormData(delete_photo);

                $.ajax({
                    url:"../action/delete_user_photo.php",
                    method: "POST",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#delete-profile-photo').modal('hide');
                            swal({
                                icon: 'success',
                                title: response.title,
                                text: response.message,
                                buttons: false,
                                timer: 2000,
                            }).then(function() {
                                location.reload();
                            });

                        } else {
                            $('#delete-profile-photo').modal('hide');
                            swal({
                                icon: 'warning',
                                title: response.title,
                                text: response.message,
                                buttons: false,
                                timer: 2000,
                            }).then(function() {
                                location.reload();
                            });
                        }
                    }
                });
            })

        }); 

        document.addEventListener("DOMContentLoaded", function() {
            // Get the active tab for the first set of tabs from localStorage or set a default value
            let activeTab = localStorage.getItem("activeTab") || "#profile-info";
            const sectionTitle = document.getElementById('section-title');

            function updateSectionTitle(tab) {
                if(tab === '#profile-info'){
                    sectionTitle.innerHTML = '<span class="text-muted fw-light">Account Settings /</span> Account';
                } else {
                    sectionTitle.innerHTML = '<span class="text-muted fw-light">Account Settings /</span> Security';
                }
            }
            // Initial title update based on active tab
            updateSectionTitle(activeTab);

            // Set the active tab for the first set of tabs only if the screen width is greater than 768px
            if (window.innerWidth > 768) {
                $('.nav-align-top .nav-link[data-bs-target="' + activeTab + '"]').tab('show');
            }

            // Save the active tab for the first set of tabs to localStorage when a tab is clicked
            $('.nav-align-top .nav-link').on('shown.bs.tab', function(e) {
                let newActiveTab1 = $(e.target).attr("data-bs-target");
                localStorage.setItem("activeTab", newActiveTab1);
                updateSectionTitle(newActiveTab1);
            });

            console.log(activeTab);
        });
</script>

</html>
<div class="modal fade" id="delete-profile-photo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to remove profile photo?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_photo" class="nav-link ">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="" type="button" id="photo_delete" class="btn btn-label-danger">Delete</button>
                    <input type="hidden" name="user_photo_fname" id="user_photo_fname" value="<?php echo $user['fname'] . ' ' . $user['lname']; ?>">
                    <input type="hidden" name="photo_to_delete" value="<?php echo $user['image']; ?>">
                    <input  type="hidden" name="ID" id="ID" value="<?php echo $user_id?>">
                </form>
            </div>
        </div>
    </div>
</div><!-- End delete profile photo Modal-->