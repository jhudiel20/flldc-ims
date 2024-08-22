<?php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php
if (!isset($_COOKIE['ACCESS'])) {
    header("Location:index.php");
}
?>
<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <?php
    include __DIR__  . "/../action/global/metadata.php";
    include __DIR__  . "/../action/global/include_top.php";
    ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

        <?php
        include __DIR__ . "/../action/global/sidebar.php";
        include __DIR__ . "/../action/global/header.php"; 
        ?>

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container flex-grow-1 container-p-y">

                    <!-- <div class="row h-100"> -->
                    <!-- <div class="card w-100 h-100"> -->
                    <!-- <div class="d-flex align-items-end row h-100"> -->
                    <!-- <div class="col-12 h-100"> -->
                    <!-- <div class="card-body h-100"> -->
                    <iframe width="100%" height="100%"
                        src="https://lookerstudio.google.com/embed/reporting/fac9c54f-6723-42c7-ae03-91d3ea07254a/page/TlJ0C"
                        frameborder="0" style="border:0" allowfullscreen
                        sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
                    <!-- </div> -->
                    <!-- </div> -->
                    <!-- </div> -->
                    <!-- </div> -->
                    <!-- </div> -->


                </div>
                <!-- / Content -->

                <!-- Footer -->
                <?php 
                    include __DIR__. "/../action/global/footer.php";
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
        include __DIR__ . "/../action/global/include_bottom.php";
      ?>
</body>

</html>