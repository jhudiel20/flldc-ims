<?php 
require_once __DIR__ . '/../api/DBConnection.php';
include 'config/config.php'; 
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

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
                                    <p class="label-shadow mb-2">SIGN-IN</p>
                                    <form id="user_login_form" class="mb-3" method="post">
                                        <div class="mb-3">
                                            <label for="username" class="form-label label-shadow">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Enter your email or username" />
                                        </div>
                                        <div class="mb-3 form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label label-shadow" for="password">Password</label>
                                                <a href="<?php BASE_URL; ?>forgot-password">
                                                    <small>Forgot Password?</small>
                                                </a>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" class="form-control"
                                                    name="password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 btn-page-block" id="signin_btn">Sign
                                            in</button>
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