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