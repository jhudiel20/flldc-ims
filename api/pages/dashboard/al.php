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

                        

                    </div>


                    