<?php 
require_once __DIR__ . '/../api/DBConnection.php';
include 'config/config.php'; 
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="Learning & Development IMS">
    <meta http-equiv="refresh" content="1800;<?php BASE_URL; ?>Actions" />
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
    <link rel="stylesheet" href="<?php BASE_URL; ?>assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
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
    <script src="<?php BASE_URL; ?>assets/js/sweetalert.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        /* end */
    </style>
</head>

<body data-layout="detached" class="bg-image h-100">
	<div id="main-content">
		<div class="text-montserrat">
			<div class="wrapper in">

				<div class="content-page mt-5">
					<div class="content">
						<div class="row justify-content-md-center">
							<div class="col-xs-12  col-sm-12 col-xl-5 col-lg-6 col-md-10">
								<div class="card d-none d-sm-block d-md-block text-white mt-5 h-display">
									<div class="card-body pt-1 pb-1 pl-3">
										<div class="d-flex justify-content-center align-items-center">
											<img src="https://lms.ccc.edu.ph/images/logo-lms.png?v=1.1.8" alt="" height="100">
											<div class="page-title font-weight-normal text-center p-3 fs-xl">
												e-GURO: CCC Learning Management System
											</div>
										</div>
									</div>
								</div>

								<div class="card d-sm-none d-md-none d-lg-none d-xl-none text-white h-display mt-0">
									<div class="card-body text-center pt-1 pb-1 pl-3">
										<div class="d-flex justify-content-center align-items-center">
											<img src="https://lms.ccc.edu.ph/images/logo-mlms.png?v=1.1.8" alt="" height="80">
											<div class="page-title font-weight-normal fs-medium text-center pl-2">e-GURO: CCC Learning Management System</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row justify-content-md-center">
							<div class="col-xs-12  col-sm-12 col-xl-5 col-lg-6 col-md-10">
								<div class="card b-display">
									<div class="card-body">
										<form class="" name='login_form' id="login_form" action="https://lms.ccc.edu.ph/app/login.php?formSubmitted=true" method="POST">
											<h4 id="log_title">SIGN-IN</h4>
											<div class="row">
												<div class="form-group col-xs-12 col-sm-12 col-lg-12">
													<div class="input-group bg-iform">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
														</div>
														<input type="text" class="form-control" name="username" id="username" value="" placeholder="Username" required>
													</div>
												</div>

												<div class="form-group col-xs-12 col-sm-12 col-lg-12 text-center" id="password_div">
													<div class="input-group bg-iform">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1"><i class="fa fa-lock" aria-hidden="true"></i></span>
														</div>
														<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
													</div>
													<span class="float-left" style="font-size:1em;">Login Attempts: 0</span>
												</div>
												<div class="form-group col-xs-12 col-sm-12 col-lg-12 mt-0 pt-0">
													<button type="submit" id="btn_submit" name="submit" value="login" class="btn btn-custom w-100">LOGIN</button>
												</div>
												<div class="form-group col-xs-12 col-sm-12 col-lg-12 text-center" id="forgotlogin">
													<a href="#" id="forgot_action" data-toggle="tooltip" data-html="true" title="To reset your password, please click this link to process your reset." class="text-lgrey" style="font-size:1.1em;"> <i class="fas fa-question-circle"></i><span> Forgot Password / Reset Password</span> </a>
												</div>
												<div class="form-group col-xs-12 col-sm-12 col-lg-12 text-center" id="backlogin" style="display:none;">
													<a href="#" id="back_login" class="text-lgrey" style="font-size:1.1em;"> <i class="fas fa-chevron-left"></i><span> Back to Sign In</span> </a>
												</div>
												<input type="hidden" name="token_login_form"  id="token_login_form" value="10e1b8203714fa6358be4f681a093b615e8faa3a6b686a957566be07a68a145a"/>											</div>
										</form>
									</div>
								</div>
							</div> <!-- end col-->
						</div>
						<!-- END PLACE PAGE CONTENT HERE -->
					</div>
				</div>
				<!-- END CONTENT -->
			</div>
		</div>
		<div class="feedback_toolbar">
			<div class="inside">
				<a href="https://lms.ccc.edu.ph/faq.php" target="_blank" style="color: white;" title="FEEDBACK">
					<i class="fas fa-comment" style="color: white;"></i>
					<span class="toolbox-tooltip">FAQs</span>
				</a>
			</div>
		</div>
	</div>


	<!-- all the js files -->
	<!-- bundle -->
	<!-- Begin of Footer -->
<footer class="sticky-footer p-3 mt-5 mb-0 pb-0" style="margin-top:10px;position: absolute; bottom: 0; width: 100%;  background-color:rgba(0, 16, 77,0.95)!important; z-index:1005;">
  <div class="my-auto">
    <div class="copyright text-center my-auto mx-5">
      <span class="text-center text-white" id="copyright">Copyright &copy; 2021 City College of Calamba. All Rights Reserved.</span>
      <!-- <span class="float-right text-white" id="contact">
        <i class='fas fa-map-marker-alt' style='font-size:12px'></i> Old Municipal Site, Burgos St, Brgy. VII, Poblacion, Calamba City &ensp; <i class='fas fa-phone' style='font-size:12px'></i> (049) 559 8900 | (02) 8 539 5170 &ensp; <i class='fa fa-envelope' style='font-size:12px'></i><mail><a href="mailto:support@ccc.edu.ph" class="text-white"> support@ccc.edu.ph</a></mail>
      </span> -->
    </div>
  </div>
</footer>
<!-- End of Footer -->
</body>

    <script src="<?php echo BASE_URL; ?>assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/vendor/libs/i18n/i18n.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo BASE_URL; ?>assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/vendor/libs/@form-validation/auto-focus.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/sweetalert2@11.min.js"></script>
    <!-- Main JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/pages-auth.js"></script>

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
                    url: '/userlogin.php', // Ensure this path is correct
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