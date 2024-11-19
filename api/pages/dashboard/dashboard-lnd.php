<?php
ob_start();
require_once __DIR__ . '/../../config/config.php';
if(!isset($_COOKIE['secure_data'])){
    header("Location: /index");
}
if (!isset($decrypted_array['ACCESS'])) {
    header("Location: /index");
}
?>


<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <?php
    include __DIR__  . "/../../action/global/metadata.php";
    include __DIR__  . "/../../action/global/include_top.php";
    include __DIR__ . "/../../action/global/include_bottom.php";

    ?>
            <?php
            if (isset($_COOKIE['Toast-message'])) {
                ?>
                
                    <script>

                        Toast.fire({
                            icon: "success",
                            title: "<?php echo $_COOKIE['Toast-title']; ?>",
                            text: "<?php echo $_COOKIE['Toast-message']; ?>"
                        });
                    </script>
                
                <?php
                    // Clear cookies after displaying the message
                    setcookie("Toast-title", "", time() - 3600, "/");
                    setcookie("Toast-message", "", time() - 3600, "/");
                }
        ?>
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <?php
        include __DIR__ . "/../../action/global/sidebar.php";
        include __DIR__ . "/../../action/global/header.php"; 
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
                    include __DIR__. "/../../action/global/footer.php";
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
      ?>
    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>
</body>
</html>

<?php
ob_end_flush();
?>
