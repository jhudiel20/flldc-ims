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
    $row_total_reserve = $total_reserve->fetch(PDO::FETCH_ASSOC);

    $total_book = $conn->prepare("
    SELECT COUNT(id) AS total_book FROM reservations");
    $total_book->execute();
    $row_total_book = $total_book->fetch(PDO::FETCH_ASSOC);

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

                    <!-- <div class="row"> -->

                        <!-- Total Revenue in reservation -->
                        <div class="col-md-3 col-sm-6 mb-4">
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
                        <div class="col-md-3 col-sm-6 mb-4">
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
                        <!-- total number of reservations -->
                        <div class="col-md-3 col-sm-6 mb-4">
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
                                <h4 class="card-title mb-1"><?php echo number_format($row_total_reserve['total_reserve']) ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- total bookings -->
                        <div class="col-md-3 col-sm-6 mb-4">
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
                                <span class="d-block">Total Booking</span>
                                <h4 class="card-title mb-1"><?php echo number_format($row_total_book['total_book']) ?></h4>
                                <!-- <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
                                </div>
                            </div>
                        </div>

                    <!-- </div> -->

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
                                    <h5 class="card-title">Head Count</h5>

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

                                    <!-- Bar Chart -->
                                    <canvas id="barChart" style="max-height: 400px;"></canvas>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            new Chart(document.querySelector('#barChart'), {
                                                type: 'bar',
                                                data: {
                                                    labels: <?php echo json_encode($head_months); ?>, // Dynamic month data
                                                    datasets: [{
                                                        label: 'Head Count',
                                                        data: <?php echo json_encode($head); ?>, // Dynamic head count data
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.2)',
                                                            'rgba(255, 159, 64, 0.2)',
                                                            'rgba(255, 205, 86, 0.2)',
                                                            'rgba(75, 192, 192, 0.2)',
                                                            'rgba(54, 162, 235, 0.2)',
                                                            'rgba(153, 102, 255, 0.2)',
                                                            'rgba(201, 203, 207, 0.2)'
                                                        ],
                                                        borderColor: [
                                                            'rgb(255, 99, 132)',
                                                            'rgb(255, 159, 64)',
                                                            'rgb(255, 205, 86)',
                                                            'rgb(75, 192, 192)',
                                                            'rgb(54, 162, 235)',
                                                            'rgb(153, 102, 255)',
                                                            'rgb(201, 203, 207)'
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    }
                                                }
                                            });
                                        });
                                    </script>
                                    <!-- End Bar Chart -->

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