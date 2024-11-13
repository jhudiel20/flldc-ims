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

    <script src="<?php BASE_URL; ?>assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="<?php BASE_URL; ?>assets/js/extended-ui-blockui.js"></script>

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
                        $('#signin_btn').addClass('d-none').prop('disabled', false);
                        },
                    success: function(response) {
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