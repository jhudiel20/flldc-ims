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
    <!-- <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/apex-charts/apex-charts.css" /> -->
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/@form-validation/form-validation.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/dropzone/dropzone.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="<?php BASE_URL; ?>../assets/vendor/libs/spinkit/spinkit.css" />

    <!-- Helpers -->
    <script src="<?php BASE_URL; ?>../assets/vendor/js/helpers.js"></script>
    <script src="<?php BASE_URL; ?>../assets/js/config.js"></script>

    <!-- Console Warning -->
    <script src="<?php BASE_URL; ?>../assets/js/console.js?v=<?php echo FILE_VERSION; ?>"></script>

    <link id="themeStylesheet" href="https://unpkg.com/tabulator-tables@5.6.0/dist/css/tabulator_bootstrap5.min.css" rel="stylesheet"/>
    <script src="https://unpkg.com/tabulator-tables@5.6.0/dist/js/tabulator.min.js"></script>

    <!-- XLSX Script Include -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- PDF Script Includes -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script src="<?php BASE_URL; ?>../assets/js/sweetalert2@11.min.js?v=<?php echo FILE_VERSION; ?>"></script>

    
    <!-- sweetalert@ colored toast js -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        //define column header menu as column visibility toggle
        var headerMenu = function(){
            var menu = [];
            var columns = this.getColumns();

            for(let column of columns){

                //create checkbox element using font awesome icons
                let icon = document.createElement("i");
                icon.classList.add("fas");
                icon.classList.add(column.isVisible() ? "fa-check-square" : "fa-square");

                //build label
                let label = document.createElement("span");
                let title = document.createElement("span");

                title.textContent = " " + column.getDefinition().title;

                label.appendChild(icon);
                label.appendChild(title);

                //create menu item
                menu.push({
                    label:label,
                    action:function(e){
                        //prevent menu closing
                        e.stopPropagation();

                        //toggle current column visibility
                        column.toggle();

                        //change menu item icon
                        if(column.isVisible()){
                            icon.classList.remove("fa-square");
                            icon.classList.add("fa-check-square");
                        }else{
                            icon.classList.remove("fa-check-square");
                            icon.classList.add("fa-square");
                        }
                    }
                });
            }

        return menu;
        };
  
        const currentYear = new Date().getFullYear();
        const currentDate = new Date().toLocaleDateString();
        const formattedDateWithHyphens = currentDate.replace(/\//g, "-");

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
        #layout-navbar {
            z-index: 1050;
            position: fixed;
        }
        .swal2-toast {
            z-index: 1060 !important; /* Ensure Toast appears above navbar */
        }
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
    