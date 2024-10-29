<?php 
require_once __DIR__ . '/../api/DBConnection.php';
include 'config/config.php'; 
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Learning and Development IMS">
    <meta http-equiv="refresh" content="" />
    <title><?php echo PAGE_TITLE; ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php BASE_URL; ?>assets/img/LOGO.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="<?php BASE_URL; ?>assets/vendor/js/helpers.js"></script>
    <!-- <script src="<?php //BASE_URL; ?>assets/vendor/js/template-customizer.js"></script> -->
    <script src="<?php BASE_URL; ?>assets/js/config.js"></script>
    <script src="<?php BASE_URL; ?>assets/js/sweetalert.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/css/index.css" />
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
                                    <p class="label-shadow mb-2">Forgot Password</p>
                                    <form id="user_forgot_form" class="mb-3" method="post">
                                        <h4 class="mb-2">Forgot Password? 🔒</h4>
                                        <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                                        <form id="forgot_password_form" class="mb-3" action="" method="post">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input
                                            type="text"
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            placeholder="Enter your email"
                                            autofocus />
                                        </div>
                                        <button type="button" class="btn btn-primary d-grid w-100" id="send_link">Send Reset Link</button>
                                        <button class="btn btn-label-primary d-none w-100" type="button" id="request_emailed_icon" disabled>
                                                <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                Loading...
                                                </button>
                                        </form>
                                        <div class="text-center">
                                            <a href="index" class="d-flex align-items-center justify-content-center">
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
    <script src="<?php BASE_URL; ?>assets/js/sweetalert2@11.min.js"></script>

    <script type="module"> import { inject } from "https://cdn.jsdelivr.net/npm/@vercel/analytics/dist/index.mjs";
      inject();
    </script>
    <!-- Main JS -->
    <script src="<?php BASE_URL; ?>assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?php BASE_URL; ?>assets/js/pages-auth.js"></script>

    <script>
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

        $(document).ready(function() {
            $('#user_login_form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: '/userlogin', // Ensure this path is correct
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#signin_btn').hide();
                        $('#request_icon').removeClass('d-none').prop('disabled', true);
                        },
                    success: function(response) {
                        $('#request_icon').addClass('d-none').prop('disabled', false);
                        $('#signin_btn').show();
                        if (response.success) {
                            Toast.fire({
                                    icon: 'success',
                                    title: response.title,
                                    text: response.message,
                                })
                                .then(function() {
                                    window.location.href = '/dashboard-lnd';
                                });
                        } else {
                            Toast.fire({
                                icon: response.icon,
                                title: response.title,
                                text: response.message,
                            }).then(function() {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', status, error); // Log the error to the console
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred',
                            text: 'Please try again later.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });
        });
    </script>

</html>