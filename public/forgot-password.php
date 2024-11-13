<?php 
require_once __DIR__ . '/../api/DBConnection.php';
include 'config/config.php'; 
?>
<!doctype html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <?php
        include __DIR__ . "/assets/index/metadata.php";
        include __DIR__ . "/assets/index/include_top.php";
    ?>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="container-xxl">
                <div class="row justify-content-md-center mb-3 pt-5">
                    <div class="col-xs-12 col-sm-12 col-xl-5 col-lg-6 col-md-10">
                        <div class="card d-none d-sm-block d-md-block mt-5 h-display card-logo"
                            style="background-color:#0100b7">
                            <div class="card-body pt-1 pb-1 pl-3">
                                <div class="d-flex justify-content-center text-white align-items-center">
                                    <img src="<?php BASE_URL; ?>assets/img/LOGO.png" alt="" height="100">
                                    <b>
                                        <div class="page-title font-weight-normal text-center p-3 fs-xl">
                                            Learning and Development Inventory Management System
                                        </div>
                                    </b>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card d-sm-none d-md-none d-lg-none d-xl-none text-white h-display mt-5 card-logo-mobile" style="background-color:#0100b7">
                            <div class="card-body text-center pt-1 pb-1 pl-3">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="<?php BASE_URL; ?>assets/img/LOGO.png" alt="" height="80">
                                    <b>
                                        <div class="page-title font-weight-normal fs-medium text-center pl-2">
                                            Learning and Development Inventory Management System
                                        </div>
                                    </b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-xs-12 col-sm-12 col-xl-5 col-lg-6 col-md-10">
                        <div class="authentication-inner">
                            <div class="card card-authentication">
                                <div class="card-body">
                                    <!-- <p class="label-shadow mb-2">Forgot Password</p> -->
                                    <form id="forgot_pass_form" class="mb-3" method="post">
                                        <h4 class="label-shadow mb-2">Forgot Password? 🔒</h4>
                                        <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                                        <form id="forgot_password_form" class="mb-3" action="" method="post">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input
                                            type="email"
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            placeholder="Enter your email"
                                            autofocus />
                                        </div>
                                        <button type="submit" class="btn btn-primary d-grid w-100" id="send_link">Send Reset Link</button>
                                        <button class="btn btn-label-primary d-none w-100" type="button" id="request_emailed_icon" disabled>
                                                <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                Loading...
                                                </button>
                                        </form>
                                        <div class="text-center">
                                            <a href="/" class="d-flex align-items-center justify-content-center">
                                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                                Back to login
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layout-overlay layout-menu-toggle"></div>
            <div class="drag-target"></div>
        </div>
    </div>

    <footer class="sticky-footer p-3 mt-5 mb-0 pb-0" style="background-color:#0100b7; margin-top:10px;position:
        absolute; bottom: 0; width: 100%; z-index:1005;">
        <div class="copyright text-center my-auto mx-5">
            <b><span class="text-center text-white">Copyright &copy; 2024 FAST Learning and Development
                    Center. All Rights Reserved.</span>
            </b>
        </div>
    </footer>
</body>
    <?php
        include __DIR__ . "/assets/index/include_bottom.php";
    ?>
</html>