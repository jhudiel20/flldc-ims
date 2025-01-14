<?php
require_once __DIR__ . '/../../config/config.php';
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
$row_current_monthly_sales = mysqli_fetch_assoc($current_monthly_sales);
$current_monthly_sales = $row_current_monthly_sales['MONTHLY_SALES'];

$last_month_sales = mysqli_query($conn,"SELECT SUM(PRICES) AS PREVIOUS_MONTH_SALES
FROM reservations
WHERE YEAR(DATE_CREATED) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(DATE_CREATED) = MONTH(CURDATE() - INTERVAL 1 MONTH) ;
");
$row_last_month_sales = mysqli_fetch_assoc($last_month_sales);
$last_month_sales = $row_last_month_sales['PREVIOUS_MONTH_SALES']; 

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

                        <div class="col-lg-8 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Weekly Sales | Start Week:
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#btn_sales_weekly">
                                            <span><?php echo date('M-d-Y', $start_date); ?></span>
                                        </button>
                                    </h5>

                                    <!-- Area Chart -->
                                    <div id="areaChart"></div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                        const series = {
                                            "monthDataSeries1": {
                                                "prices": [
                                                    <?php
                                                            while($row = mysqli_fetch_assoc($weekly_sales)) {
                                                                echo $row['WEEKLY_TOTAL'] . ",";
                                                            }
                                                        ?>
                                                ],
                                                "dates": [
                                                    <?php
                                                            mysqli_data_seek($weekly_sales, 0); // Reset pointer to first row
                                                            while($row = mysqli_fetch_assoc($weekly_sales)) {
                                                                echo "'" . date('M d', strtotime($row['WEEK_START_DATE'])) . "',";
                                                            }
                                                        ?>
                                                ]
                                            }
                                        }

                                        new ApexCharts(document.querySelector("#areaChart"), {
                                            series: [{
                                                name: "Sales",
                                                data: series.monthDataSeries1.prices
                                            }],
                                            chart: {
                                                type: 'area',
                                                height: 260,
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
                                                text: 'Sales Movements',
                                                align: 'left'
                                            },
                                            labels: series.monthDataSeries1.dates,
                                            xaxis: {
                                                type: 'datetime',
                                            },
                                            yaxis: {
                                                opposite: true
                                            },
                                            legend: {
                                                horizontalAlign: 'left'
                                            }
                                        }).render();
                                    });
                                    </script>
                                    <!-- End Area Chart -->


                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="avatar flex-shrink-0">
                                                    <img src="./assets/img/icons/unicons/cc-primary.png" alt="Credit Card"
                                                        class="rounded">
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="cardOpt4"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="cardOpt4">
                                                        <a class="dropdown-item" href="transaction_list.php">View
                                                            More</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="d-block mb-1">Transactions Today</span>
                                            <h4 class="card-title text-nowrap mb-2"><?php if($row_total_transaction_day['TOTAL'] == ""){echo "0";}else{ echo "₱".number_format($row_total_transaction_day['TOTAL']); }?></h4>
                                                <?php 
                                                if ($percentage_change > 0) {
                                                ?> 
                                                    <small class="text-success fw-medium">
                                                    <i class='bx bx-up-arrow-alt'></i>
                                             
                                                    <?php 
                                                } elseif ($percentage_change < 0) {
                                                    ?>
                                                    <small class="text-danger fw-medium">
                                                    <i class='bx bx-down-arrow-alt'></i>
                                                
                                                    <?php 
                                                } else {
                                                    $color_class = ""; // No specific color for no change
                                                    $arrow_icon = ""; // No arrow for no change
                                                }
                                                ?>
                                                <?php echo number_format($percentage_change, 2); ?>% <!-- Display the percentage change -->
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
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
                                            <span class="fw-medium d-block mb-1">Monthly Sales <?php// echo $row_last_month_sales['PREVIOUS_MONTH_SALES']; ?></span>
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
                                            <h4 class="card-title mb-2">Today : <?php if($row_pending_transaction['TOTAL'] == 0){  ?>
                                                                            <span class="badge bg-label-success rounded-pill"><?php echo $row_pending_transaction['TOTAL'];?></span>
                                                                        <?php }else{?>
                                                                            <span class="badge bg-label-danger rounded-pill"><?php echo $row_pending_transaction['TOTAL'];?></span>
                                                                        <?php }?></h4>
                                            <h4 class="card-title mb-2">Total : <?php if($row_total_pending_transaction['TOTAL'] == 0){  ?>
                                                                            <span class="badge bg-label-success rounded-pill"><?php echo $row_total_pending_transaction['TOTAL'];?></span>
                                                                        <?php }else{?>
                                                                            <span class="badge bg-label-danger rounded-pill"><?php echo $row_total_pending_transaction['TOTAL'];?></span>
                                                                        <?php }?></h4>
                                        </div>
                                    </div>
                                </div>
                           
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- Annual Budget Utilization -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-12">
                                        <div class="card-body">

                                            <h5 class="card-title">Top 5 Sold Product & Price Income | Year :
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#btn_budget_year">
                                                    <span><?php echo $year;?>
                                                    </span>
                                                </button>
                                            </h5>

                                            <!-- Line Chart -->
                                            <div id="lineChart"></div>

                                            <script>
                                                document.addEventListener("DOMContentLoaded", () => {
                                                    new ApexCharts(document.querySelector("#lineChart"), {
                                                        series: [{
                                                            name: "Top 5 Most Selling Products of Year <?php echo $year; ?>",
                                                            data: [
                                                                <?php
                                                                        $first = true;
                                                                        while ($r_price1 = mysqli_fetch_assoc($price1)){
                                                                            if(!$first) {
                                                                                echo ",";
                                                                            }
                                                                            if(empty($r_price1['TOTAL'])){
                                                                                echo "0";
                                                                            } else {
                                                                                echo $r_price1['TOTAL'];
                                                                            }
                                                                            $first = false;
                                                                        }
                                                                    ?>
                                                            ]
                                                        }],
                                                        // colors: ['#0072C9',  '#CB8D14','#00B678', '#5F4AA6', '#CC374D'],
                                                        chart: {
                                                            height: 350,
                                                            type: 'bar',
                                                            zoom: {
                                                                enabled: false
                                                            }
                                                        },
                                                        // colors: ['#0072C9',  '#CB8D14','#00B678', '#5F4AA6', '#CC374D'],
                                                        // colors: ['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF'],
                                                        dataLabels: {
                                                            enabled: true, // Enable data labels
                                                            formatter: function(val) {
                                                                return '₱' + val
                                                                    .toLocaleString(); // Format number with commas
                                                            }
                                                        },
                                                        stroke: {
                                                            curve: 'straight'
                                                        },
                                                        grid: {
                                                            row: {
                                                                colors: ['#f3f3f3',
                                                                    'transparent'
                                                                ], // takes an array which will be repeated on columns
                                                                opacity: 0.5
                                                            },
                                                        },
                                                        xaxis: {
                                                            categories: [
                                                                <?php
                                                                        $first = true;
                                                                        while ($r_product1 = mysqli_fetch_assoc($product1)){
                                                                            if(!$first) {
                                                                                echo ",";
                                                                            }
                                                                            if(empty($r_product1['PRODUCTS'])){
                                                                                echo '0';
                                                                            } else {
                                                                                echo "'" . $r_product1['PRODUCTS'] . "'";
                                                                            }
                                                                            $first = false;
                                                                    
                                                                        }
                                                                    ?>
                                                            ],
                                                        }
                                                        ,
                                                        plotOptions: {
                                                            barBackground: {
                                                                barBackground: ['#0072C9', '#00B678', '#0000FF', '#FFFF00', '#FF00FF']
                                                            }
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
                        
                        <!-- Pie Chart -->
                        <div class="col-lg-6 mb-4 ">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Top 5 Most Selling Products | Year :
                                        <?php if(empty($year)){echo $year = date("Y"); }else{ echo $year;}?></h5>

                                    <!-- Pie Chart -->
                                    <div id="pieChart"></div>

                                    <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#pieChart"), {
                                            series: [
                                                <?php
                                                                    $first = true;
                                                                    while ($r_price = mysqli_fetch_assoc($price)){
                                                                        if(!$first) {
                                                                            echo ",";
                                                                        }
                                                                        if(empty($r_price['TOTAL'])){
                                                                            echo "0";
                                                                        } else {
                                                                            echo $r_price['TOTAL'];
                                                                        }
                                                                        $first = false;
                                                                    }
                                                                ?>

                                            ],
                                            chart: {
                                                height: 380,
                                                type: 'pie',
                                                toolbar: {
                                                    show: true
                                                }
                                            },
                                            labels: [
                                                <?php
                                                                    $first = true;
                                                                    while ($r_product = mysqli_fetch_assoc($product)){
                                                                        if(!$first) {
                                                                            echo ",";
                                                                        }
                                                                        if(empty($r_product['PRODUCTS'])){
                                                                            echo '0';
                                                                        } else {
                                                                            echo "'" . $r_product['PRODUCTS'] . "'";
                                                                        }
                                                                        $first = false;
                                                                
                                                                    }
                                                                ?>
                                            ]
                                        }).render();
                                    });
                                    </script>
                                    <!-- End Pie Chart -->

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Recent 7 Activity -->
                        <div class="col-lg-4 col-md-12 order-2 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="card-title m-0 me-2">Recent Activity</h5>
                                    <?php if($_SESSION['ACCESS'] == 'ADMIN'){?>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>logs.php">See More</a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="card-body">
                                    <div class="recent-activity">
                                        <ul class="activity-list">
                                            <?php $sql_try = mysqli_query($conn, "SELECT logs.ID,logs.USER_ID,logs.ACTION_MADE,logs.DATE_CREATED,FNAME,MNAME,LNAME,EXT_NAME FROM logs inner join `hipak_mabuhay_accounts`.user_account on logs.user_id = user_account.ID ORDER BY logs.DATE_CREATED DESC LIMIT 5 "); ?>

                                            <?php while ($row_try = mysqli_fetch_assoc($sql_try)) { ?>
                                            <li>
                                                <div class="activity-time col-lg-4">
                                                    <?php echo date('Y-m-d | g:i A', strtotime($row_try['DATE_CREATED'])) ?>
                                                </div>

                                                <?php
                                                    $iconClass = '';
                                                    if ($row_try['ACTION_MADE'] == 'Logged in the system.') {
                                                        $iconClass = 'login';
                                                    } elseif ($row_try['ACTION_MADE'] == 'Logged out.') {
                                                        $iconClass = 'logout';
                                                    } else {
                                                        $iconClass = 'other';
                                                    }
                                                    ?>

                                                <div class="col-lg-2 col-md-2">
                                                    <span class="activity-icon <?php echo $iconClass ?>"> <i
                                                            class='bx bxs-circle'></i></span>
                                                </div>

                                                <!-- <span class="activity-icon"> <i class='bx bxs-circle' ></i></span> -->

                                                <div class="activity-details col-lg-6 col-md-6">
                                                    <p class="activity-description">
                                                        <?php if ($row_try['ACTION_MADE'] == 'Logged in the system.') {
                                                                echo 'User ' . '' . $row_try['FNAME'] . ' ' . $row_try['LNAME'] . ' ' . $row_try['ACTION_MADE'];
                                                                } elseif ($row_try['ACTION_MADE'] == 'Logged out.') {
                                                                echo 'User ' . '' . $row_try['LNAME'] . ' ' . $row_try['ACTION_MADE'];
                                                                } else {
                                                                echo '<span style="font-size:13px">'.''.$row_try['ACTION_MADE'].''.'<span>';
                                                                }
                                                        ?>
                                                    </p>
                                                </div>
                                            </li>
                                            <?php } ?>
                                            <!-- Add more activity items here -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Latest Transaction -->
                        <div class="col-lg-4 col-md-12 order-2 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="card-title m-0 me-2">Latest Transaction</h5>
                                    <?php if($_SESSION['ACCESS'] == 'ADMIN'){?>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>transaction_list.php">See
                                                More</a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="card-body">
                                    <div class="recent-activity" style="overflow-x:auto;text-align:center">
                                        <div>
                                            <table class="table table-bordered border">
                                                <thead>
                                                    <tr>
                                                        <th>Client</th>
                                                        <th>No. of Product</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php $sql_try = mysqli_query($conn, "SELECT *,COUNT(QTY) AS TOTAL  FROM transaction as t
                                                    JOIN transaction_details as td on td.TRANSACTION_ID = t.TRANSACTION_ID GROUP BY t.TRANSACTION_ID
                                                    ORDER BY t.DATE DESC LIMIT 5"); ?>
                                                    <?php while ($row_try = mysqli_fetch_assoc($sql_try)) { ?>
                                                    <tr>
                                                        <td> <?php echo $row_try['CUSTOMER_NAME']?></td>
                                                        <td> <?php echo $row_try['TOTAL'] ?></td>
                                                        <td> <?php echo $row_try['DATE'] ?></button>
                                                        </td>
                                                    </tr>

                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RecentLY Added Products -->
                        <div class="col-lg-4 col-md-12 order-2 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="card-title m-0 me-2">Recently Added Products</h5>
                                    <?php if($_SESSION['ACCESS'] == 'ADMIN'){?>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>product_list.php">See
                                                More</a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="card-body">
                                    <div class="recent-activity">
                                        <ul class="activity-list">
                                            <?php $sql_try = mysqli_query($conn, "SELECT * FROM product WHERE DATE_CREATED >= CURDATE() ORDER BY DATE_CREATED DESC LIMIT 10 "); ?>

                                            <?php while ($row_try = mysqli_fetch_assoc($sql_try)) { ?>
                                            <li>
                                                <div class="activity-time col-lg-5">
                                                    <?php echo date('Y-m-d | g:i A', strtotime($row_try['DATE_CREATED'])) ?>
                                                </div>

                                                <div class="col-lg-2 col-md-2">
                                                    <span class="activity-icon <?php echo $iconClass ?>"> <i
                                                            class='bx bxs-circle'></i></span>
                                                </div>

                                                <!-- <span class="activity-icon"> <i class='bx bxs-circle' ></i></span> -->

                                                <div class="activity-details col-lg-8 col-md-8">
                                                    <p class="activity-description">
                                                        <?php 
                                                                echo '<span style="font-size:14px">'.''.$row_try['PRODUCT_NAME'].''.'<span>';
                                                                
                                                        ?>
                                                    </p>
                                                </div>
                                            </li>
                                            <?php } ?>
                                            <!-- Add more activity items here -->
                                        </ul>
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

</html>