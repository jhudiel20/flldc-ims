<?php 
require_once __DIR__ . '/../api/DBConnection.php';
include 'config/config.php'; 

$code = $_GET['code'];
$code = decrypted_string($code);

if(empty($code)){
  header("location:/");
}

$sql = $conn->prepare("SELECT EMAIL FROM user_account WHERE reset_token = :code ");
$sql->bindParam(':code', $code, PDO::PARAM_STR);
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

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
                                    <h4 class="mb-2">Reset Password 🔒</h4>
                                    <p class="mb-4">for <span class="fw-medium"><?php echo $row['email'];?></span></p>
                                    <form id="change_password_form" class="mb-3" method="post">
                                        <input type="hidden" value="<?php echo $code; ?>" id="code" name="code">

                                        <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                                        <form id="change_pass_form" class="mb-3" action="" method="post">
                                        <div class="mb-3 form-password-toggle">
                                            <label class="form-label" for="password">New Password</label>
                                            <div class="input-group input-group-merge">
                                                <input
                                                    type="password"
                                                    id="password"
                                                    class="form-control"
                                                    name="password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" />
                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 form-password-toggle">
                                            <label class="form-label" for="confirm-password">Confirm Password</label>
                                            <div class="input-group input-group-merge">
                                                <input
                                                    type="password"
                                                    id="confirmpassword"
                                                    class="form-control"
                                                    name="confirmpassword"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" />
                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary d-grid w-100 mb-3" id="set_password">Set new password</button>
                                        <button class="btn btn-label-primary d-none w-100" type="button" id="set_pass_icon" disabled>
                                                <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                Loading...
                                                </button>
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