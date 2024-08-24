    <!-- Favicon -->
    <link href="<?php BASE_URL; ?>../assets/img/LOGO.png" rel="icon" style="boder-radius:10%">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/css/rtl/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/@form-validation/form-validation.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/dropzone/dropzone.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/animate-css/animate.css" />

    <!-- Helpers -->
    <script src="<?php BASE_URL; ?>../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php BASE_URL; ?>../assets/js/config.js"></script>

    <!-- Console Warning -->
    <script src="<?php BASE_URL; ?>../assets/js/console.js?v=<?php echo FILE_VERSION; ?>"></script>

    <!-- Js -->
    <!-- <script src="<?php BASE_URL; ?>assets/js/sec.js?v=<?php echo FILE_VERSION; ?>"></script> -->

    <!-- TABULATOR -->
    <link id="themeStylesheet"
        href="<?php BASE_URL; ?>../tabulator/dist/css/tabulator_bootstrap5.min.css?v=<?php echo FILE_VERSION; ?>"
        rel="stylesheet"/>
    <script src="<?php BASE_URL; ?>../tabulator/dist/js/tabulator.js?v=<?php echo FILE_VERSION; ?>"></script>

    <!-- XLSX Script Includes -->
    <script src="<?php BASE_URL; ?>../tabulator/dist/js/xlsx.full.min.js?v=<?php echo FILE_VERSION; ?>"></script>
    <!-- PDF Script Includes -->
    <script src="<?php BASE_URL; ?>../tabulator/dist/js/jspdf.umd.min.js?v=<?php echo FILE_VERSION; ?>"></script>
    <script src="<?php BASE_URL; ?>../tabulator/dist/js/jspdf.plugin.autotable.min.js?v=<?php echo FILE_VERSION; ?>"></script>



    <!-- dropify -->
    <!-- <link href="<?php //BASE_URL; ?>../assets/css/dropify.min.css?v=<?php //echo FILE_VERSION; ?>" rel="stylesheet"/> -->

    <!-- <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet"> -->
    <script src="<?php BASE_URL; ?>../assets/js/sweetalert2@11.min.js?v=<?php echo FILE_VERSION; ?>"></script>

    <!-- sweetalert@ colored toast js -->


    <script>
        const currentYear = new Date().getFullYear();
        const currentDate = new Date().toLocaleDateString();
        const formattedDateWithHyphens = currentDate.replace(/\//g, "-");

        const Toast = Swal.mixin({
            toast: true,
            position: "bottom-end",
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 1500,
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
    <style>
        .container {
            max-width: 100%;
            /* Remove fixed width */
        }


        /* Example media query for smaller screens */

        @media (max-width: 768px) {
            .container {
                padding: 10px;
                /* Adjust padding for smaller screens */
            }
        }

        /* ------------------- */
        .require {
            color: red;
        }

        .form-message {
            display: none;
        }

        .message {
            display: none;
            color: red;
            text-align: center;
        }

        .additional-buttons {
            display: block;
            /* Show the additional buttons div */
        }

        .minimize-buttons {
            display: none;
            /* Hide the dropdown button */
        }
        #nav-employee-details {
                    display: none;
                }

        @media screen and (max-width: 768px) {
            .additional-buttons {
                display: none;
                /* Hide the additional buttons div */
            }

            .minimize-buttons {
                display: block;
                /* Show the dropdown button */
            }

            #nav-employee-details {
                display: block;

            }

            #navbar-ex-3 a {
                text-align: left !important;
            }

            #nav-training-details {
                display: block;
            }
        }

        #example-table {
            max-height: 67vh;
            /* 80% of the viewport height */
        }


        .tabulator-table {
            font-weight: bold;
            border: .5px solid #A5AAAE;
        }
    </style>
    