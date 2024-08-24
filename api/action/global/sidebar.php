<?php 
include '/DBConnection.php'; // Adjusted path for DBConnection.php

$geturl = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); 

$user_id = $decrypted_array['ID'];

        $stmt = $conn->prepare("SELECT COUNT(ID) as TOTAL FROM purchase_order WHERE APPROVAL = 'PENDING'");
        $stmt->execute();
        $count_pending = $stmt->fetch(PDO::FETCH_ASSOC);

        $pr = $conn->prepare("SELECT COUNT(ID) as TOTAL FROM purchase_order WHERE STATUS = 'PENDING' AND APPROVAL = 'APPROVED' ");
        $pr->execute();
        $pr_status = $pr->fetch(PDO::FETCH_ASSOC);
?>
<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.php" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="../assets/img/F-LOGO.png" height="40px" alt="" style="border-radius:20%" />
            </span>
            <span class="app-brand-text  menu-text fw-bold ms-2" style="color:#0000bb">Learning and<br>
                Development</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Navigation -->

        <!-- Dashboard -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Navigation">Navigation</span>
        </li>
        <li
            class="menu-item <?php echo ($geturl == 'dashboard-lnd.php' ||$geturl == 'dashboard-mrs.php' ||$geturl == 'dashboard-lms.php'||$geturl == 'dashboard-eval.php' )? 'active open' : 'collapsed' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
                <!-- <span class="badge badge-center rounded-pill bg-danger ms-auto">5</span> -->
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?php echo ($geturl == 'dashboard-lnd.php')? 'active' : 'collapsed' ?>">
                    <a href="dashboard-lnd.php" class="menu-link">
                        <div class="text-truncate" data-i18n="Training Database">Training Database</div>
                    </a>
                </li>
                <li class="menu-item <?php echo ($geturl == 'dashboard-mrs.php')? 'active' : 'collapsed' ?>">
                    <a href="dashboard-mrs.php" class="menu-link">
                        <div class="text-truncate" data-i18n="Meeting Room System">Meeting Room System</div>
                    </a>
                </li>
                <li class="menu-item <?php echo ($geturl == 'dashboard-lms.php')? 'active' : 'collapsed' ?>">
                    <a href="dashboard-lms.php" class="menu-link">
                        <div class="text-truncate" data-i18n="FAST LMS">FAST LMS</div>
                    </a>
                </li>
                <li class="menu-item <?php echo ($geturl == 'dashboard-eval.php')? 'active' : 'collapsed' ?>">
                    <a href="dashboard-eval.php" class="menu-link">
                        <div class="text-truncate" data-i18n="Training Evaluation">Training Evalution</div>
                    </a>
                </li>
                <!-- <li class="menu-item">
                    <a href="app-ecommerce-dashboard.html" class="menu-link">
                        <div class="text-truncate" data-i18n="eCommerce">eCommerce</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-logistics-dashboard.html" class="menu-link">
                        <div class="text-truncate" data-i18n="Logistics">Logistics</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-academy-dashboard.html" class="menu-link">
                        <div class="text-truncate" data-i18n="Academy">Academy</div>
                    </a>
                </li> -->
            </ul>
        </li>
        <li class="menu-item <?php echo ($geturl == 'cashier_page.php')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>cashier_page.php" class="menu-link">
                        <i class="menu-icon fa-solid fa-box-open"></i>
                        <div> To be use Items</div>
                    </a>
                </li>
                <li class="menu-item <?php echo ($geturl == 'transaction_list.php')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>transaction_list.php" class="menu-link">
                        <i class="menu-icon fa-solid fa-solid fa-clipboard-list"></i>
                        <div> Used Supplies List</div>
                    </a>
                </li>
        <li class="menu-item <?php echo ($geturl == 'item-list.php' ||$geturl == 'archive_list.php' ||$geturl == 'brand-list.php' ||$geturl == 'supplier_list.php' ||$geturl == 'category_list.php') ? 'active open' : 'collapsed' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon fa-solid fa-box'></i>
                <div data-i18n="Items">Products</div>
            </a>
            <ul class="menu-sub">
                <!-- Product List -->
                <li class="menu-item <?php echo ($geturl == 'item-list.php')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>item-list.php" class="menu-link">
                        <i class='menu-icon fa-solid fa-box'></i>
                        <div> Item List</div>
                    </a>
                </li>
                <?php if($decrypted_array['ACCESS'] != 'CASHIER'){?>
                <li class="menu-item <?php echo ($geturl == 'archive_list.php')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>archive_list.php" class="menu-link">
                        <i class='menu-icon fa-solid fa-box'></i>
                        <div> Archives</div>
                    </a>
                </li>
                <li class="menu-item <?php echo ($geturl == 'brand-list.php')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>brand-list.php" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-notepad'></i>
                        <div> Brand List</div>
                    </a>
                </li>


                <li class="menu-item <?php echo ($geturl == 'supplier_list.php')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>supplier_list.php" class="menu-link">
                        <i class='menu-icon fa-solid fa-user-tie'></i>
                        <div> Distributor List</div>
                    </a>
                </li>

                <li class="menu-item <?php echo ($geturl == 'category_list.php')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>category_list.php" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-notepad'></i>
                        <div> Category List</div>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>

        <?php if($decrypted_array['ACCESS'] != 'REQUESTOR'){?>
        <li class="menu-item <?php echo ($geturl == 'inventory_list.php' ||$geturl == 'monthly_inventory_list.php') ? 'active open' : 'collapsed' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon fa-solid fa-cubes-stacked'></i>
                <div data-i18n="Stocks">Inventory Info</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?php echo ($geturl == 'inventory_list.php')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>inventory_list.php" class="menu-link">
                        <i class='menu-icon fa-solid fa-cubes-stacked'></i>
                        <div> Stocks</div>
                    </a>
                </li>
                
                <li class="menu-item <?php echo ($geturl == 'monthly_inventory_list.php')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>monthly_inventory_list.php" class="menu-link">
                        <i class='menu-icon fa-solid fa-boxes-stacked'></i>
                        <div> Monthly Inventory</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>


        <li class="menu-item <?php echo ($geturl == 'rca-list.php')? 'active' : 'collapsed' ?>">
            <a href="rca-list.php" class="menu-link">
                <i class="menu-icon fa-solid fa-solid fa-clipboard-list"></i>
                <div> RCA/PCV List</div>
                <!-- <?php if($count_pending['TOTAL'] == 0){}else{?>
                <span
                    class="badge badge-center rounded-pill bg-danger ms-auto"><?php echo $count_pending['TOTAL']?></span>
                <?php }?> -->
            </a>
        </li>
        <li class="menu-item <?php echo ($geturl == 'request-list.php')? 'active' : 'collapsed' ?>">
            <a href="request-list.php" class="menu-link">
                <i class="menu-icon fa-solid fa-solid fa-clipboard-list"></i>
                <div> Request List</div>
                <?php if($count_pending['TOTAL'] == 0){}else{?>
                <span
                    class="badge badge-center rounded-pill bg-danger ms-auto"><?php echo $count_pending['TOTAL']?></span>
                <?php }?>
            </a>
        </li>
        <li class="menu-item <?php echo ($geturl == 'purchase-list.php')? 'active' : 'collapsed' ?>">
            <a href="purchase-list.php" class="menu-link">
                <i class="menu-icon fa-solid fa-solid fa-clipboard-list"></i>
                <div> Purchase List</div>
                <?php if($pr_status['TOTAL'] == 0){}else{?>
                <span class="badge badge-center rounded-pill bg-danger ms-auto"><?php echo $pr_status['TOTAL']?></span>
                <?php }?>
            </a>
        </li>



        <!-- <li class="menu-item <?php echo ($geturl == 'item-list.php')? 'active' : 'collapsed' ?>">
            <a href="<?php BASE_URL; ?>item-list.php" class="menu-link">
                <i class='menu-icon fa-solid fa-box'></i>
                <div> Inventory</div>
            </a>
        </li> -->

        <?php if($decrypted_array['ACCESS'] == 'ADMIN'){?>
        <!-- Admin -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Admin">Admin</span>
        </li>
        <li class="menu-item <?php echo ($geturl == 'user_list.php')? 'active' : 'collapsed' ?>">
            <a href="<?php BASE_URL; ?>user_list.php" class="menu-link">
                <i class='menu-icon fa-solid fa-user-gear'></i>
                <div> Manage Users</div>
            </a>
        </li>
        <li class="menu-item <?php echo ($geturl == 'logs.php')? 'active' : 'collapsed' ?>">
            <a href="<?php BASE_URL; ?>logs.php" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-book'></i>
                <div> History List</div>
            </a>
        </li>
        <?php } ?>
    </ul>

</aside>
<!-- / Menu -->