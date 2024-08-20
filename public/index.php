<?php 
require 'DBConnection.php';
include 'config/config.php'; 

?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="Learning & Development IMS">
    <meta http-equiv="refresh" content="1800;<?php BASE_URL; ?>Actions.php?a=logout" />
    <title><?php echo PAGE_TITLE; ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php BASE_URL; ?>assets/img/LOGO.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="<?php BASE_URL; ?>assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?php BASE_URL; ?>assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php BASE_URL; ?>assets/js/config.js"></script>

    <!-- <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet"> -->
    <script src="<?php BASE_URL; ?>assets/js/sweetalert2@11.min.js?v=<?php echo FILE_VERSION; ?>"></script>

    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    // <!-- sweetalert@ colored toast js -->
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    </script>
    <style>
    /* sweetalert2 colored toast */
    .colored-toast.swal2-icon-success {
        background-color: #27c251 !important;
        color: white;
    }

    .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
        color: white;
    }

    .swal2-error {
        background-color: white;
    }

    .colored-toast.swal2-icon-warning {
        background-color: #f8bb86 !important;
        color: white;
    }

    .colored-toast.swal2-icon-info {
        background-color: #3fc3ee !important;
        color: white;
    }

    .colored-toast.swal2-icon-question {
        background-color: #87adbd !important;
        color: white;
    }

    .colored-toast .swal2-title {
        color: white;
    }

    .colored-toast .swal2-close {
        color: white;
    }

    .colored-toast .swal2-html-container {
        color: white;
    }

    .colored-toast {
        color: white;
    }

    .bg-modify {
        background: linear-gradient(to right, #0000A7, #E40000);
    }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <?php
        // include DOMAIN_PATH . "/action/global/sidebar.php";
        // include DOMAIN_PATH . "/action/global/header.php"; 
        ?>

            <div class="authentication-wrapper authentication-cover">
                <div class="authentication-inner row m-0">
                    <!-- /Left Text -->
                    <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
                        <div class="w-100 d-flex justify-content-center">
                            <img src="<?php BASE_URL; ?>assets/img/illustrations/boy-with-rocket-light.png"
                                class="img-fluid" alt="Login image" width="700"
                                data-app-dark-img="illustrations/boy-with-rocket-dark.png"
                                data-app-light-img="illustrations/boy-with-rocket-light.png" />
                        </div>
                    </div>
                    <!-- /Left Text -->

                    <!-- Login -->
                    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
                        <div class="w-px-400 mx-auto">
                            <!-- Logo -->
                            <div class="app-brand mb-3" style="display: flex; justify-content: center;">
                                <a href="index.html" class="app-brand-link gap-2">
                                    <span class="app-brand-logo demo">

                                        <img src="assets/img/LOGO.png" height="150px" alt=""
                                            style="border-radius:20%" />

                                    </span>
                                    <!-- <span class="app-brand-text demo fw-bold">Learning and Development</span> -->
                                </a>
                            </div>
                            <!-- /Logo -->
                            <!-- <h4 class="mb-2">Welcome to Sneat! 👋</h4> -->
                            <p class="mb-4">SIGN-IN <?php //echo $_SESSION['status']; ?> </p>

                            <form id="user_login" class="mb-3" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Enter your email or username" autofocus />
                                </div>
                                <div class="mb-3 form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Password</label>
                                        <a href="<?php BASE_URL; ?>forgot-password.php">
                                            <small>Forgot Password?</small>
                                        </a>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <!-- <div class="mb-3">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                  </div>
                                </div> -->
                                <button type="button" id="login" class="btn btn-primary d-grid w-100">Sign in</button>
                            </form>

                            <p class="text-center">
                                <span>Not Registered?</span>
                                <a href="auth-register-cover.html">
                                    <span>Create an account</span>
                                </a>
                            </p>

                            <div class="divider my-4">
                                <div class="divider-text">or</div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                                    <i class="tf-icons bx bxl-facebook"></i>
                                </a>

                                <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                                    <i class="tf-icons bx bxl-google-plus"></i>
                                </a>

                                <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                                    <i class="tf-icons bx bxl-twitter"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /Login -->
                </div>
            </div>



            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>

            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>
        </div>
        <!-- / Layout wrapper -->

        <?php
        // include DOMAIN_PATH . "/action/global/include_bottom.php";
      ?>
        <script src="<?php BASE_URL; ?>assets/vendor/libs/jquery/jquery.js"></script>
        <script src="<?php BASE_URL; ?>assets/vendor/libs/popper/popper.js"></script>
        <script src="<?php BASE_URL; ?>assets/vendor/js/bootstrap.js"></script>
        <script src="<?php BASE_URL; ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="<?php BASE_URL; ?>assets/vendor/libs/hammer/hammer.js"></script>
        <script src="<?php BASE_URL; ?>assets/vendor/libs/i18n/i18n.js"></script>
        <script src="<?php BASE_URL; ?>assets/vendor/libs/typeahead-js/typeahead.js"></script>
        <script src="<?php BASE_URL; ?>assets/vendor/js/menu.js"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="<?php BASE_URL; ?>assets/vendor/libs/@form-validation/popular.js"></script>
        <script src="<?php BASE_URL; ?>assets/vendor/libs/@form-validation/bootstrap5.js"></script>
        <script src="<?php BASE_URL; ?>assets/vendor/libs/@form-validation/auto-focus.js"></script>

        <!-- Main JS -->
        <script src="<?php BASE_URL; ?>assets/js/main.js"></script>

        <!-- Page JS -->
        <script src="<?php BASE_URL; ?>assets/js/pages-auth.js"></script>

        <script src="<?php BASE_URL; ?>js/jquery-3.6.0.min.js?v=<?php echo FILE_VERSION; ?>"></script>
</body>

<script>
    document.addEventListener("keydown", function(event) {
    if (event.keyCode === 13) {
        document.getElementById("login").click();
    }
});
$(document).ready(function() {
    var baseUrl = "<?php echo BASE_URL; ?>";
    $('#login').on('click', function() {
        var formdata = new FormData(user_login);
        $.ajax({
            url: baseUrl + "action/userlogin.php",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,

            success: function(response) {
                console.log(response);
                if (response.success) {
                    Toast.fire({
                            icon: 'success',
                            title: response.title,
                            text: response.message,
                        })
                        .then(function() {
                            window.location.href = 'pages/dashboard-lnd.php';
                        });
                } else {
                    Toast.fire({
                        icon: response.icon,
                        title: response.title,
                        text: response.message,
                    })
                }
            }
        })
    });
    // $('#password').keypress(function(event) {
    //     if (event.which === 13) {
    //         event.preventDefault(); // Prevent default form submission
    //         $('#user_login').submit(); // Submit the form
    //     }
    // });
    $('#register').on('click', function() {
        var formdata = new FormData(register_form);


        $.ajax({
            url: <?php BASE_URL; ?> "action/userRegister.php",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,

            success: function(response) {
                console.log(response);
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        window.location.href = 'index.php';
                    });
                } else {
                    $('#register_modal').modal('hide');
                    Toast.fire({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        })
    });
})
</script>
</html>