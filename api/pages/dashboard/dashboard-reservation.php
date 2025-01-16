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
    SELECT COUNT(id) AS total_reserve FROM reservations");
    $total_reserve->execute();
    $row_total_reserve = $total_reserve->fetch(PDO::FETCH_ASSOC);

    $total_approved = $conn->prepare("
    SELECT COUNT(id) AS total_approved FROM reservations WHERE reserve_status = 'APPROVED'");
    $total_approved->execute();
    $row_total_approved = $total_approved->fetch(PDO::FETCH_ASSOC);

    $total_declined = $conn->prepare("
    SELECT COUNT(id) AS total_declined FROM reservations WHERE reserve_status = 'DECLINED'");
    $total_declined->execute();
    $row_total_declined = $total_declined->fetch(PDO::FETCH_ASSOC);

    $total_pending = $conn->prepare("
    SELECT COUNT(id) AS total_pending FROM reservations WHERE reserve_status = 'PENDING'");
    $total_pending->execute();
    $row_total_pending = $total_pending->fetch(PDO::FETCH_ASSOC);

    $currentYear = date('Y');
    $selectedYear = isset($_GET['year']) ? $_GET['year'] : $currentYear;
    
    $total_sales_per_month = $conn->prepare("
        SELECT TO_CHAR(reserve_date, 'YYYY-MON') AS month, 
               SUM(CAST(prices AS NUMERIC)) AS total_sales
        FROM reservations
        WHERE reserve_status = 'APPROVED'
          AND EXTRACT(YEAR FROM reserve_date) = :year
        GROUP BY TO_CHAR(reserve_date, 'YYYY-MON')
        ORDER BY MIN(reserve_date) ASC
    ");
    $total_sales_per_month->bindParam(':year', $selectedYear, PDO::PARAM_INT);
    $total_sales_per_month->execute();
    $sales_data = $total_sales_per_month->fetchAll(PDO::FETCH_ASSOC);
    
    // Prepare data for JavaScript
    $months = [];
    $sales = [];
    foreach ($sales_data as $row) {
        $months[] = $row['month'];
        $sales[] = $row['total_sales'];
    }

    $total_head_per_month = $conn->prepare("
        SELECT TO_CHAR(reserve_date, 'YYYY-MON') AS month, 
            COUNT(id) AS total_head
        FROM reservations
        WHERE reserve_status = 'APPROVED'
        AND EXTRACT(YEAR FROM reserve_date) = :year
        GROUP BY TO_CHAR(reserve_date, 'YYYY-MON')
        ORDER BY MIN(reserve_date) ASC
    ");
    $total_head_per_month->bindParam(':year', $selectedYear, PDO::PARAM_INT);
    $total_head_per_month->execute();
    $head_data = $total_head_per_month->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for JavaScript
    $head_months = [];
    $head = [];
    foreach ($head_data as $row) {
        $head_months[] = $row['month'];
        $head[] = $row['total_head'];
    }

    $total_reserve_per_month = $conn->prepare("
        SELECT TO_CHAR(reserve_date, 'YYYY-MON') AS month, 
            COUNT(id) AS total_reserve
        FROM reservations
        AND EXTRACT(YEAR FROM reserve_date) = :year
        GROUP BY TO_CHAR(reserve_date, 'YYYY-MON')
        ORDER BY MIN(reserve_date) ASC
    ");
    $total_reserve_per_month->bindParam(':year', $selectedYear, PDO::PARAM_INT);
    $total_reserve_per_month->execute();
    $reserve_data = $total_reserve_per_month->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for JavaScript
    $reserve_months = [];
    $reserve = [];
    foreach ($reserve_data as $row) {
        $reserve_months[] = $row['month'];
        $reserve[] = $row['total_reserve'];
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
                        <div class="col-md-4 col-sm-6 mb-4">
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
                                <span class="d-block">Revenue</span>
                                <h4 class="card-title mb-1"><?php echo number_format($row_total_sales['total_sales']) ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- total number guest -->
                        <div class="col-md-4 col-sm-6 mb-4">
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
                                <h4 class="card-title mb-1"><?php echo number_format($row_total_guest['total_guest']) ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- total Reservation -->
                        <div class="col-md-4 col-sm-6 mb-4">
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
                                <span class="d-block">Total Reservation</span>
                                <h4 class="card-title mb-1"><?php echo number_format($row_total_reserve['total_reserve']) ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- total approved -->
                        <div class="col-md-4 col-sm-6 mb-4">
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
                                <span class="d-block">Total Approved Reservation</span>
                                <h4 class="card-title mb-1"><?php echo number_format($row_total_approved['total_approved']) ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- total pending -->
                        <div class="col-md-4 col-sm-6 mb-4">
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
                                <span class="d-block">Total Pending Reservation</span>
                                <h4 class="card-title mb-1"><?php echo number_format($row_total_pending['total_pending']) ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- total declined -->
                        <div class="col-md-4 col-sm-6 mb-4">
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
                                <span class="d-block">Total Declined Reservation</span>
                                <h4 class="card-title mb-1"><?php echo number_format($row_total_declined['total_declined']) ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Revenue</h5>

                                    <!-- Year Filter -->
                                    <form method="GET" id="yearFilterForm">
                                        <label for="yearSelect">Select Year: <select name="year" id="yearSelect" class="form-select w-50"  onchange="document.getElementById('yearFilterForm').submit();">
                                        </label>
                                            <?php
                                            $startYear = $currentYear - 5; // Show last 5 years
                                            for ($year = $startYear; $year <= $currentYear; $year++) {
                                                $selected = ($year == $selectedYear) ? 'selected' : '';
                                                echo "<option value=\"$year\" $selected>$year</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                    <!-- End Year Filter -->

                                    <!-- Bar Chart -->
                                    <div id="barChart" style="min-height: 400px;" class="echart"></div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            const months = <?php echo json_encode($months); ?>;
                                            const sales = <?php echo json_encode($sales); ?>;

                                            // Define an array of colors for each bar
                                            const barColors = [
                                                '#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#A1FF33', '#33FFF7', 
                                                '#F733FF', '#33FFDC', '#F7FF33', '#FF9133', '#9133FF', '#FF5733'
                                            ];

                                            echarts.init(document.querySelector("#barChart")).setOption({
                                                xAxis: {
                                                    type: 'category',
                                                    data: months
                                                },
                                                yAxis: {
                                                    type: 'value'
                                                },
                                                series: [{
                                                    data: sales,
                                                    type: 'bar',
                                                    label: {
                                                        show: true, // Enable the label
                                                        position: 'top', // Position the label at the top of the bars
                                                        formatter: '{c}', // Format the label to display the value
                                                        color: '#000' // Set the label color
                                                    },
                                                    itemStyle: {
                                                        color: (params) => {
                                                            // Use the barColors array to assign a color to each bar
                                                            return barColors[params.dataIndex % barColors.length];
                                                        }
                                                    }
                                                }]
                                            });
                                        });
                                    </script>
                                    <!-- End Bar Chart -->

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Count of Reservations</h5>

                                    <!-- Year Filter -->
                                    <form method="GET" id="yearFilterForm">
                                        <label for="yearSelect">Select Year: 
                                            <select name="year" id="yearSelect" class="form-select w-50" onchange="document.getElementById('yearFilterForm').submit();">
                                                <?php
                                                $startYear = $currentYear - 5; // Show last 5 years
                                                for ($year = $startYear; $year <= $currentYear; $year++) {
                                                    $selected = ($year == $selectedYear) ? 'selected' : '';
                                                    echo "<option value=\"$year\" $selected>$year</option>";
                                                }
                                                ?>
                                            </select>
                                        </label>
                                    </form>
                                    <!-- End Year Filter -->

                                    <!-- Polar Area Chart -->
                                    <div id="polarAreaChart"></div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            const selectedYear = <?php echo json_encode($selectedYear); ?>;
                                            const allMonths = [
                                                `${selectedYear}-JAN`, `${selectedYear}-FEB`, `${selectedYear}-MAR`, `${selectedYear}-APR`, 
                                                `${selectedYear}-MAY`, `${selectedYear}-JUN`, `${selectedYear}-JUL`, `${selectedYear}-AUG`, 
                                                `${selectedYear}-SEP`, `${selectedYear}-OCT`, `${selectedYear}-NOV`, `${selectedYear}-DEC`
                                            ];

                                            const reserveData = <?php echo json_encode($reserve); ?>;
                                            const reserveMonths = <?php echo json_encode($reserve_months); ?>;

                                            // Fill missing months with zero reservations
                                            const dataMap = Object.fromEntries(reserveMonths.map((month, index) => [month, reserveData[index]]));
                                            const filledData = allMonths.map(month => dataMap[month] || 0);

                                            new ApexCharts(document.querySelector("#polarAreaChart"), {
                                                series: filledData,
                                                chart: {
                                                    type: 'polarArea',
                                                    height: 350,
                                                    toolbar: {
                                                        show: true
                                                    }
                                                },
                                                labels: allMonths,
                                                stroke: {
                                                    colors: ['#fff']
                                                },
                                                fill: {
                                                    opacity: 0.8
                                                }
                                            }).render();
                                        });
                                    </script>
                                    <!-- End Polar Area Chart -->

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