<?php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

?>

<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <?php
    include DOMAIN_PATH . "/action/global/metadata.php";
    include DOMAIN_PATH . "/action/global/include_top.php";
    ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <?php
        include DOMAIN_PATH . "/action/global/sidebar.php";
        include DOMAIN_PATH . "/action/global/header.php"; 
        ?>

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container flex-grow-1 container-p-y">
                    
                    <div class="row h-100">
                        <div class="card w-100 h-100">
                            <div class="d-flex align-items-end row h-100">
                                <div class="col-12 h-100">
                                    <div class="card-body h-100">
                                        <iframe
                                            src="https://metabase.fast.com.ph/public/dashboard/fe7bb127-7e28-4eaa-90b2-66de912b0268"
                                            frameborder="0"
                                            width="100%"
                                            height="100%"
                                            allowtransparency="true"
                                        ></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
                <!-- / Content -->

                <!-- Footer -->
                <?php 
                    include FOOTER_PATH;
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
        include DOMAIN_PATH . "/action/global/include_bottom.php";
      ?>
    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>
</body>

</html>