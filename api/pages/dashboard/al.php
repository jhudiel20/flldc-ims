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
                        </div>    // $total_head_per_month = $conn->prepare("
    //     SELECT TO_CHAR(reserve_date, 'YYYY-MON') AS month, 
    //         COUNT(id) AS total_head
    //     FROM reservations
    //     WHERE reserve_status = 'APPROVED'
    //     AND EXTRACT(YEAR FROM reserve_date) = :year
    //     GROUP BY TO_CHAR(reserve_date, 'YYYY-MON')
    //     ORDER BY MIN(reserve_date) ASC
    // ");
    // $total_head_per_month->bindParam(':year', $selectedYear, PDO::PARAM_INT);
    // $total_head_per_month->execute();
    // $head_data = $total_head_per_month->fetchAll(PDO::FETCH_ASSOC);

    // // Prepare data for JavaScript
    // $head_months = [];
    // $head = [];
    // foreach ($head_data as $row) {
    //     $head_months[] = $row['month'];
    //     $head[] = $row['total_head'];
    // }

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