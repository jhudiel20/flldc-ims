<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../DBConnection.php';
if (!isset($decrypted_array['ACCESS'])) {
    header("Location: /");
}

if(isset($_POST['submit_year'])){
    if(ctype_digit($_POST['active_year'])){
    $year = $_POST['active_year'];
    }
  }
  if(empty($year)){
    $year = date("Y");
  }

    $total_sales = $conn->prepare("
    SELECT SUM(CAST(prices AS NUMERIC)) AS total_sales FROM reservations
    WHERE reserve_status = 'APPROVED'");
    $total_sales->execute();
    $row_total_sales = $total_sales->fetch(PDO::FETCH_ASSOC);

    $total_guest = $conn->prepare("
    SELECT SUM(CAST(guest AS NUMERIC)) AS total_guest FROM reservations
    WHERE reserve_status = 'APPROVED'");
    $total_guest->execute();
    $row_total_guest = $total_guest->fetch(PDO::FETCH_ASSOC);

    $total_reserve = $conn->prepare("
    SELECT COUNT(id) AS total_reserve FROM reservations
    WHERE reserve_status = 'APPROVED'");
    $total_reserve->execute();
    $row_total_reserve = $total_guest->fetch(PDO::FETCH_ASSOC);

    
?>
<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <?php
    include __DIR__  . "/../../action/global/metadata.php";
    include __DIR__  . "/../../action/global/include_top.php";
    ?>
</head>

<!-- Set Year Modal -->
<div class="modal fade" id="btn_budget_year" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="budget_year" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="budget_year">Set Year: </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post">
                    <input type="text" id="active_year" name="active_year" class="form-control">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit_year" id="submit_year"
                    class="btn btn-outline-primary">Submit</button>
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

<!-- Set Year Modal -->
<div class="modal fade" id="btn_sales_weekly" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="btn_sales_weekly" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Select Start Week: </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post">
                    <input type="date" id="active_week" name="active_week" class="form-control"
                        max="<?php echo date('Y-m-d'); ?>">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit_week" id="submit_week"
                    class="btn btn-outline-primary">Submit</button>
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>

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

                    <div class="row">

                        <!-- Total Revenue in reservation -->
                        <div class="col-lg-6 col-md-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                    <img
                                        src="../assets/img/wallet-info.png"
                                        alt="Credit Card"
                                        class="rounded" />
                                    </div>
                                </div>
                                <span class="d-block">Sales</span>
                                <h4 class="card-title mb-1"><?php echo $row_total_sales['total_sales'] ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- total number guest -->
                        <div class="col-lg-6 col-md-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                    <img
                                        src="../assets/img/user.png"
                                        alt="Credit Card"
                                        class="rounded" />
                                    </div>
                                </div>
                                <span class="d-block">Head Count</span>
                                <h4 class="card-title mb-1"><?php echo $row_total_guest['total_guest'] ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- total number of reservations -->
                        <div class="col-lg-6 col-md-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                    <img
                                        src="../assets/img/bookmark.png"
                                        alt="Credit Card"
                                        class="rounded" />
                                    </div>
                                </div>
                                <span class="d-block">Total reservation</span>
                                <h4 class="card-title mb-1"><?php echo $row_total_reserve['total_reserve'] ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- number of active midwifes -->
                        <div class="col-md-3 col-lg-3 order-2 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="card-title m-0 me-2">Total Active Midwifes</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="p-0 m-0">
                                        <li class="d-flex mb-4 pb-1">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <img src="<?php echo BASE_URL; ?>/assets/img/icons/unicons/user.png"
                                                    alt="User" class="rounded" />
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <!-- <small class="text-muted d-block mb-1">Total Active Patients</small> -->
                                                    <h6 class="mb-0">Midwifes</h6>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    <h6 class="mb-0"><?php echo $row_count_active_midwifes['TOTAL']; ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
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
        include __DIR__ . "/../../action/global/include_bottom.php";
      ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@4.3.0/dist/apexcharts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.6.0/dist/echarts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
</html>