<?php 

require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:/");
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
                                                            <img src="https://raw.githubusercontent.com/jhudiel20/flldc-user-image/main/images/<?php echo empty($user['image']) ? 'user.png' : $user['image']; ?>" alt="user-avatar"
                                                                class="d-block rounded"
                                                                height="100"
                                                                width="100"
                                                                id="uploadedAvatar">
                                                            <div class="button-wrapper">
                                                                <form class="" method="POST" id="upload_photo_form" enctype="multipart/form-data" style="display: inline-block;">
                                                                    <label for="upload" class="" tabindex="0">
                                                                        <input type="file" name="image" id="" class="form-control mb-1">
                                                                        <input type="hidden" name="user_submit_name" id="user_submit_name" value="<?php echo $user['fname'] . ' ' . $user['lname']; ?>">
                                                                        <input type="hidden" name="ID" id="ID" value="<?php echo $user_id ?>">  
                                                                        <button type="submit" id="submit_photo_btn" value="Upload" class="btn btn-label-primary"><i class="fa-solid fa-upload"></i> Upload</button>
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
                                                        <form id="formAccountSettings" method="POST" onsubmit="return false">
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
                                                        <input type="hidden" name="id" id="id" value="<?php echo $user_id ?>">
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
                                                            <button type="submit" class="btn btn-primary me-2" id="user_change_username_btn">Save changes</button>
                                                        </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <hr class="my-4 mb-3" />

                                                <h5 class="card-header">Change Password</h5>
                                                <div class="card-body">
                                                    <form  method="post" id="user_password_form">
                                                        <input type="hidden" name="id" id="id" value="<?php echo $user_id ?>">
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
                                                            <button type="submit" class="btn btn-primary me-2" id="user_change_pass_btn">Save changes</button>
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
                    include __DIR__ . "/../modals/acc-settings_modal.php";
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
