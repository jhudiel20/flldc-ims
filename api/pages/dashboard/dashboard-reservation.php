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
    $selectedYearReserve = isset($_GET['yearSelectReserve']) ? $_GET['yearSelectReserve'] : $currentYear;
    $selectedYearRevenue = isset($_GET['yearSelectRevenue']) ? $_GET['yearSelectRevenue'] : $currentYear;
    $selectedYearRevenueBU = isset($_GET['yearSelectRevenueBU']) ? $_GET['yearSelectRevenueBU'] : $currentYear;
    $selectedYearHead = isset($_GET['yearSelectHead']) ? $_GET['yearSelectHead'] : $currentYear;

    function generateMonths($year) {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M Y', strtotime("$year-$i-01"));
        }
        return $months;
    }
    $all_months_reserve = generateMonths($selectedYearReserve);
    $all_months_revenue = generateMonths($selectedYearRevenue);
    $all_months_revenueBU = generateMonths($selectedYearRevenueBU);
    $all_months_head = generateMonths($selectedYearHead);
    ################################################################################

    // Initialize sales array with zero sales for all months
    $sales = array_fill(0, 12, 0); // 12 months with 0 sales
    
    $total_sales_per_month = $conn->prepare("
        SELECT TO_CHAR(reserve_date, 'Mon YYYY') AS month, 
               SUM(CAST(prices AS NUMERIC)) AS total_sales
        FROM reservations
        WHERE reserve_status = 'APPROVED'
          AND EXTRACT(YEAR FROM reserve_date) = :year
        GROUP BY TO_CHAR(reserve_date, 'Mon YYYY')
        ORDER BY MIN(reserve_date) ASC
    ");
    $total_sales_per_month->bindParam(':year', $selectedYearRevenue, PDO::PARAM_INT);
    $total_sales_per_month->execute();
    $sales_data = $total_sales_per_month->fetchAll(PDO::FETCH_ASSOC);
    
    // Prepare data for JavaScript
    $sales_months = [];
    $sales = [];
    // Initialize all months with zero sales
    foreach ($all_months_revenue as $month) {
        $sales_months[] = $month;
        $sales[] = 0; // Default to 0 sales
    }
    // Update sales data for months that have sales
    foreach ($sales_data as $row) {
        $monthIndex = array_search($row['month'], $sales_months);
        if ($monthIndex !== false) {
            $sales[$monthIndex] = $row['total_sales']; // Replace zero with actual sales
        }
    }
    ################################################################################

    // Initialize reserve array with zero sales for all months
    $revenuePerBU = array_fill(0, 12, 0); // 12 months with 0 sales

    $totalRevenuePerBU = $conn->prepare("
        SELECT TO_CHAR(reserve_date, 'Mon YYYY') AS month, 
            SUM(CAST(prices AS NUMERIC)) AS total_sales,
            business_unit
        FROM reservations
        WHERE reserve_status = 'APPROVED'
        AND EXTRACT(YEAR FROM reserve_date) = :year
        GROUP BY TO_CHAR(reserve_date, 'Mon YYYY'), business_unit
        ORDER BY MIN(reserve_date) ASC
    ");
    $totalRevenuePerBU->bindParam(':year', $selectedYearRevenueBU, PDO::PARAM_INT);
    $totalRevenuePerBU->execute();
    $revenuePerBUDataResults = $totalRevenuePerBU->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for JavaScript
    $monthsListBU = [];
    $revenuePerBU = [];
    // Initialize all months with zero sales
    foreach ($all_months_revenueBU as $month) {
        $monthsListBU[] = $month;
        $revenuePerBU[] = 0; // Default to 0 sales
    }

    $selectBU = [];
    foreach ($revenuePerBUDataResults as $row) {
        $selectBU[] = $row['business_unit'];
    }

    // Update reserve data for months that have sales
    foreach ($revenuePerBUDataResults as $row) {
        $monthIndex = array_search($row['month'], $monthsListBU);
        if ($monthIndex !== false) {
            $revenuePerBU[$monthIndex] = $row['total_sales']; // Replace zero with actual reserve count
        }
    }
    $selectBU = array_unique($selectBU);
    $selectBUJSON = json_encode($selectBU ?: []);

    ################################################################################

    // Initialize reserve array with zero sales for all months
    $reserveData = array_fill(0, 12, 0); // 12 months with 0 sales

    $totalReservePerMonth = $conn->prepare("
        SELECT TO_CHAR(reserve_date, 'Mon YYYY') AS month, 
            COUNT(id) AS total_reserve
        FROM reservations
        WHERE EXTRACT(YEAR FROM reserve_date) = :year
        GROUP BY TO_CHAR(reserve_date, 'Mon YYYY')
        ORDER BY MIN(reserve_date) ASC
    ");
    $totalReservePerMonth->bindParam(':year', $selectedYearReserve, PDO::PARAM_INT);
    $totalReservePerMonth->execute();
    $reserveDataResults = $totalReservePerMonth->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for JavaScript
    $monthsList = [];
    $reserveData = [];
    // Initialize all months with zero sales
    foreach ($all_months_reserve as $month) {
        $monthsList[] = $month;
        $reserveData[] = 0; // Default to 0 sales
    }

    // Update reserve data for months that have sales
    foreach ($reserveDataResults as $row) {
        $monthIndex = array_search($row['month'], $monthsList);
        if ($monthIndex !== false) {
            $reserveData[$monthIndex] = $row['total_reserve']; // Replace zero with actual reserve count
        }
    }

    // Prepare the data for JavaScript
    $reservesJSON = json_encode($reserveData); // Encode actual sales data
    $monthsJSON = json_encode($monthsList);

    ################################################################################

    // Initialize reserve array with zero sales for all months
    $headData = array_fill(0, 12, 0); // 12 months with 0 sales

    $totalHeadPerMonth = $conn->prepare("
        SELECT TO_CHAR(reserve_date, 'Mon YYYY') AS month, 
            SUM(CAST(guest AS NUMERIC)) AS total_head
        FROM reservations 
        WHERE reserve_status = 'APPROVED'
        AND EXTRACT(YEAR FROM reserve_date) = :year
        GROUP BY TO_CHAR(reserve_date, 'Mon YYYY')
        ORDER BY MIN(reserve_date) ASC
    ");
    $totalHeadPerMonth->bindParam(':year', $selectedYearHead, PDO::PARAM_INT);
    $totalHeadPerMonth->execute();
    $HeadDataResults = $totalHeadPerMonth->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for JavaScript
    $HeadmonthsList = [];
    $HeadData = [];
    // Initialize all months with zero sales
    foreach ($all_months_head as $month) {
        $HeadmonthsList[] = $month;
        $HeadData[] = 0; // Default to 0 sales
    }

    // Update reserve data for months that have sales
    foreach ($HeadDataResults as $row) {
        $monthIndex = array_search($row['month'], $HeadmonthsList);
        if ($monthIndex !== false) {
            $HeadData[$monthIndex] = $row['total_head']; // Replace zero with actual reserve count
        }
    }

    // Prepare the data for JavaScript
    $headJSON = json_encode($HeadData); // Encode actual sales data
    $HeadmonthsJSON = json_encode($HeadmonthsList);
    
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

                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Revenue</h5>
                                            <!-- <small class="text-muted">Commercial networks</small> -->
                                    </div>
                                        <!-- Year Filter -->
                                    <div class="dropdown">
                                            <form method="GET" id="yearFilterRevenue">
                                                    <select name="yearSelectRevenue" id="yearSelectRevenue" class="form-select" onchange="document.getElementById('yearFilterRevenue').submit();">
                                                        <?php
                                                        $startYear = $currentYear - 5; // Show last 5 years
                                                        for ($year = $startYear; $year <= $currentYear; $year++) {
                                                            $selected = ($year == $selectedYearRevenue) ? 'selected' : '';
                                                            echo "<option value=\"$year\" $selected>$year</option>";
                                                        }
                                                        ?>
                                                    </select>
                                            </form>
                                    </div>
                                        <!-- End Year Filter -->
                                </div>
                                <div class="card-body">

                                <!-- Column Chart -->
                                <div id="columnChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const sales_months = <?php echo json_encode($sales_months); ?>;
                                        let sales = <?php echo json_encode($sales); ?>;
                                    new ApexCharts(document.querySelector("#columnChart"), {
                                        series: [{
                                        name: 'Revenue',
                                        data: sales
                                        }],
                                        chart: {
                                        type: 'bar',
                                        height: 350
                                        },
                                        plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            columnWidth: '55%',
                                            endingShape: 'rounded'
                                        },
                                        },
                                        dataLabels: {
                                        enabled: false
                                        },
                                        stroke: {
                                        show: true,
                                        width: 2,
                                        colors: ['transparent']
                                        },
                                        xaxis: {
                                        categories: sales_months,
                                        },
                                        yaxis: {
                                        title: {
                                            text: '₱ (pesos)'
                                        }
                                        },
                                        fill: {
                                        opacity: 1
                                        },
                                        tooltip: {
                                        y: {
                                            formatter: function(val) {
                                            return "₱ " + val + " pesos"
                                            }
                                        }
                                        }
                                    }).render();
                                    });
                                </script>
                                <!-- End Column Chart -->

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title mb-0">Revenue Per BU</h5>
                                                <!-- <small class="text-muted">Commercial networks</small> -->
                                        </div>
                                            <!-- Year Filter -->
                                        <div class="dropdown">
                                                <form method="GET" id="yearFilterRevenueBU">
                                                        <select name="yearSelectRevenueBU" id="yearSelectRevenueBU" class="form-select" onchange="document.getElementById('yearFilterRevenueBU').submit();">
                                                            <?php
                                                            $startYear = $currentYear - 5; // Show last 5 years
                                                            for ($year = $startYear; $year <= $currentYear; $year++) {
                                                                $selected = ($year == $selectedYearRevenueBU) ? 'selected' : '';
                                                                echo "<option value=\"$year\" $selected>$year</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                </form>
                                        </div>
                                            <!-- End Year Filter -->
                                </div>
                                <div class="card-body">

                                <!-- Column Chart -->
                                <div id="columnChart1"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        let selectBU = <?php echo $selectBUJSON; ?>;
                                        let revenuePerBU = <?php echo json_encode($revenuePerBU); ?>;
                                        const monthsBUJSON = <?php echo json_encode($monthsListBU); ?>;
                                    new ApexCharts(document.querySelector("#columnChart1"), {
                                        series: selectBU.map(bu => ({
                                            name: bu,
                                            data: revenuePerBU.filter((_, index) => selectBU[index] === bu),
                                        })),
                                        chart: {
                                        type: 'bar',
                                        height: 350
                                        },
                                        plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            columnWidth: '55%',
                                            endingShape: 'rounded'
                                        },
                                        },
                                        dataLabels: {
                                        enabled: false
                                        },
                                        stroke: {
                                        show: true,
                                        width: 2,
                                        colors: ['transparent']
                                        },
                                        xaxis: {
                                        categories: monthsBUJSON,
                                        },
                                        yaxis: {
                                        title: {
                                            text: '₱ (pesos)'
                                        }
                                        },
                                        fill: {
                                        opacity: 1
                                        },
                                        tooltip: {
                                        y: {
                                            formatter: function(val) {
                                            return "₱ " + val + " pesos"
                                            }
                                        }
                                        }
                                    }).render();
                                    });
                                </script>
                                <!-- End Column Chart -->

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Reservations</h5>
                                            <!-- <small class="text-muted">Commercial networks</small> -->
                                    </div>
                                        <!-- Year Filter -->
                                    <div class="dropdown">
                                            <form method="GET" id="yearFilterReserve">
                                                    <select name="yearSelectReserve" id="yearSelectReserve" class="form-select" onchange="document.getElementById('yearFilterReserve').submit();">
                                                        <?php
                                                        $startYear = $currentYear - 5; // Show last 5 years
                                                        for ($year = $startYear; $year <= $currentYear; $year++) {
                                                            $selected = ($year == $selectedYearReserve) ? 'selected' : '';
                                                            echo "<option value=\"$year\" $selected>$year</option>";
                                                        }
                                                        ?>
                                                    </select>
                                            </form>
                                    </div>
                                        <!-- End Year Filter -->
                                </div>

                                <div class="card-body">
                                <!-- Line Chart -->
                                <div id="areaChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const months = <?php echo $monthsJSON; ?>;
                                        let reserves = <?php echo $reservesJSON; ?>;

                                        // Check if reserves is an array, if not, initialize it
                                        if (!Array.isArray(reserves)) {
                                            reserves = [];
                                        }

                                        if (reserves.length === 0) {
                                            months.push("No Data");
                                            reserves.push(0);
                                        }

                                    new ApexCharts(document.querySelector("#areaChart"), {
                                        series: [{
                                        name: "Total",
                                        data: reserves
                                        }],
                                        chart: {
                                        height: 350,
                                        type: 'area',
                                        zoom: {
                                            enabled: false
                                        }
                                        },
                                        dataLabels: {
                                        enabled: false
                                        },
                                        stroke: {
                                        curve: 'straight'
                                        },
                                        subtitle: {
                                            text: 'Submitted Reservations',
                                            align: 'left'
                                        },
                                        grid: {
                                        row: {
                                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                            opacity: 0.5
                                        },
                                        },
                                        xaxis: {
                                        categories: months,
                                        }
                                    }).render();
                                    });
                                </script>
                                <!-- End Line Chart -->

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Head Count</h5>
                                            <!-- <small class="text-muted">Commercial networks</small> -->
                                    </div>
                                        <!-- Year Filter -->
                                    <div class="dropdown">
                                            <form method="GET" id="yearFilterHead">
                                                    <select name="yearSelectHead" id="yearSelectHead" class="form-select" onchange="document.getElementById('yearFilterHead').submit();">
                                                        <?php
                                                        $startYear = $currentYear - 5; // Show last 5 years
                                                        for ($year = $startYear; $year <= $currentYear; $year++) {
                                                            $selected = ($year == $selectedYearHead) ? 'selected' : '';
                                                            echo "<option value=\"$year\" $selected>$year</option>";
                                                        }
                                                        ?>
                                                    </select>
                                            </form>
                                    </div>
                                        <!-- End Year Filter -->
                                </div>

                                <div class="card-body">
                                <!-- Line Chart -->
                                <div id="areaChart1"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const head = <?php echo $headJSON; ?>;
                                        let headmonths = <?php echo $HeadmonthsJSON; ?>;

                                    new ApexCharts(document.querySelector("#areaChart1"), {
                                        series: [{
                                        name: "Total",
                                        data: head
                                        }],
                                        chart: {
                                        height: 350,
                                        type: 'area',
                                        zoom: {
                                            enabled: false
                                        }
                                        },
                                        dataLabels: {
                                        enabled: false
                                        },
                                        stroke: {
                                        curve: 'straight'
                                        },
                                        subtitle: {
                                            text: 'Head Count',
                                            align: 'left'
                                        },
                                        grid: {
                                        row: {
                                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                            opacity: 0.5
                                        },
                                        },
                                        xaxis: {
                                        categories: headmonths,
                                        }
                                    }).render();
                                    });
                                </script>
                                <!-- End Line Chart -->

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