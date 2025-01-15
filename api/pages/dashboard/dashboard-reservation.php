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

$current_monthly_sales = $conn->prepare("SELECT SUM(PRICES) AS MONTHLY_SALES
FROM reservations
WHERE YEAR(DATE_CREATED) = YEAR(CURDATE()) AND MONTH(DATE_CREATED) = MONTH(CURDATE()) ;");
$current_monthly_sales->execute();
$row_current_monthly_sales = $current_monthly_sales->fetch(PDO::FETCH_ASSOC);
$row_current_monthly_sales = $row_current_monthly_sales['MONTHLY_SALES'];

$last_month_sales = $conn->prepare("SELECT SUM(PRICES) AS PREVIOUS_MONTH_SALES
FROM reservations
WHERE YEAR(DATE_CREATED) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(DATE_CREATED) = MONTH(CURDATE() - INTERVAL 1 MONTH) ;
");
$last_month_sales->execute();
$row_last_month_sales = $last_month_sales->fetch(PDO::FETCH_ASSOC);
$row_last_month_sales = $row_last_month_sales['PREVIOUS_MONTH_SALES']; 

if ($current_monthly_sales != 0 && $last_month_sales != 0) {
    $percentage_monthly = (($current_monthly_sales - $last_month_sales) / $last_month_sales) * 100;
} else {
    $percentage_monthly = 0; // Avoid division by zero error
}
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

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="avatar flex-shrink-0">
                                                    <img src="./assets/img/icons/unicons/cc-primary.png"
                                                        alt="Credit Card" class="rounded">
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="cardOpt1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                        <a class="dropdown-item" href="javascript:void(0);">View
                                                            More</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="fw-medium d-block mb-1">Monthly Sales</span>
                                            <h4 class="card-title mb-2"><?php echo "₱".number_format($row_current_monthly_sales['MONTHLY_SALES']); ?></h4>
                                            <?php 
                                                if ($percentage_monthly > 0) {
                                                ?> 
                                                    <small class="text-success fw-medium">
                                                    <i class='bx bx-up-arrow-alt'></i>
                                             
                                                    <?php 
                                                } elseif($percentage_monthly < 0) {
                                                    ?>
                                                    <small class="text-danger fw-medium">
                                                    <i class='bx bx-down-arrow-alt'></i>
                                                
                                                    <?php 
                                                } else { ?>
                                                    <small class="text-secondary fw-medium">
                                                    
                                                <?php } ?>
                                                <?php echo number_format($percentage_monthly, 2); ?>% <!-- Display the percentage change -->
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <i class='menu-icon fa-solid fa-truck-fast'></i> Pending Deliveries
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="cardOpt1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                        <a class="dropdown-item" href="shipping_list.php">View
                                                            More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        include __DIR__ . "/../../action/global/include_bottom.php";
      ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@4.3.0/dist/apexcharts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.6.0/dist/echarts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
</html>