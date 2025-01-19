<?php 
require_once __DIR__ . '/../../DBConnection.php';

$geturl = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); 

$user_id = $decrypted_array['ID'];

        $stmt = $conn->prepare("SELECT COUNT(ID) as TOTAL FROM purchase_order WHERE APPROVAL = 'PENDING'");
        $stmt->execute();
        $count_pending = $stmt->fetch(PDO::FETCH_ASSOC);

        $pr = $conn->prepare("SELECT COUNT(ID) as TOTAL FROM purchase_order WHERE STATUS = 'PENDING' AND APPROVAL = 'APPROVED' ");
        $pr->execute();
        $pr_status = $pr->fetch(PDO::FETCH_ASSOC);

        $count_rca = $conn->prepare("SELECT COUNT(ID) as TOTAL FROM rca WHERE status = 'PENDING' ");
        $count_rca->execute();
        $r_rca = $count_rca->fetch(PDO::FETCH_ASSOC);

        $reserve = $conn->prepare("SELECT COUNT(ID) as TOTAL FROM reservations WHERE reserve_status = 'PENDING' ");
        $reserve->execute();
        $r_reserve = $reserve->fetch(PDO::FETCH_ASSOC);
?>
<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="dashboard-lnd" class="app-brand-link">
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
                class="menu-item <?php echo ($geturl == 'dashboard-lnd' ||$geturl == 'dashboard-mrs' ||$geturl == 'dashboard-lms'||$geturl == 'dashboard-eval' )? 'active open' : 'collapsed' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
                    <!-- <span class="badge badge-center rounded-pill bg-danger ms-auto">5</span> -->
                </a>
                <ul class="menu-sub">
                    <li class="menu-item <?php echo ($geturl == 'dashboard-lnd')? 'active' : 'collapsed' ?>">
                        <a href="dashboard-lnd" class="menu-link btn-page-block">
                            <div class="text-truncate" data-i18n="Metabase">Metabase</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($geturl == 'dashboard-eval')? 'active' : 'collapsed' ?>">
                        <a href="dashboard-eval" class="menu-link btn-page-block">
                            <div class="text-truncate" data-i18n="Training Evaluation">Training Evalution</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($geturl == 'dashboard-lms')? 'active' : 'collapsed' ?>">
                        <a href="dashboard-lms" class="menu-link btn-page-block">
                            <div class="text-truncate" data-i18n="FAST LMS">FAST LMS</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($geturl == 'dashboard-technical')? 'active' : 'collapsed' ?>">
                        <a href="dashboard-technical" class="menu-link btn-page-block">
                            <div class="text-truncate" data-i18n="Technical Looker">Technical Looker</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($geturl == 'dashboard-reservation')? 'active' : 'collapsed' ?>">
                        <a href="dashboard-reservation" class="menu-link btn-page-block">
                            <div class="text-truncate" data-i18n="Reservation">Reservation</div>
                        </a>
                    </li>
                </ul>
            </li>
            <?php if($decrypted_array['RESERVATION_ACCESS'] == 'ADMIN'){?>
                <li class="menu-item <?php echo ($geturl == 'room-list' || $geturl == 'reservation-list' || $geturl == 'reserve-pending' || $geturl == 'reserve-approved' || $geturl == 'reserve-declined' )? 'active open' : 'collapsed'  ?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon fa-solid fa-book-bookmark btn-page-block"></i>
                        <div class="text-truncate" data-i18n="Reservation">Reservation</div>
                        <?php if($r_reserve['total'] == 0){}else{?>
                                <span
                                    class="badge badge-center rounded-pill bg-danger ms-auto"><?php echo $r_reserve['total']?></span>
                                <?php }?>
                        <!-- <span class="badge badge-center rounded-pill bg-danger ms-auto">5</span> -->
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item <?php echo ($geturl == 'room-list')? 'active' : 'collapsed' ?>">
                            <a href="room-list" class="menu-link btn-page-block">
                                <div class="text-truncate" data-i18n="Rooms">Rooms</div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo ($geturl == 'reservation-list')? 'active' : 'collapsed' ?>">
                            <a href="reservation-list" class="menu-link btn-page-block">
                                <div class="text-truncate" data-i18n="All">All</div>
                                <?php if($r_reserve['total'] == 0){}else{?>
                                <span
                                    class="badge badge-center rounded-pill bg-danger ms-auto"><?php echo $r_reserve['total']?></span>
                                <?php }?>
                            </a>
                        </li>
                        <li class="menu-item <?php echo ($geturl == 'reserve-pending')? 'active' : 'collapsed' ?>">
                            <a href="reserve-pending" class="menu-link btn-page-block">
                                <div class="text-truncate" data-i18n="Pending">Pending</div>
                                <?php if($r_reserve['total'] == 0){}else{?>
                                <span
                                    class="badge badge-center rounded-pill bg-danger ms-auto"><?php echo $r_reserve['total']?></span>
                                <?php }?>
                            </a>
                        </li>
                        <li class="menu-item <?php echo ($geturl == 'reserve-approved')? 'active' : 'collapsed' ?>">
                            <a href="reserve-approved" class="menu-link btn-page-block">
                                <div class="text-truncate" data-i18n="Approved">Approved</div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo ($geturl == 'reserve-declined')? 'active' : 'collapsed' ?>">
                            <a href="reserve-declined" class="menu-link btn-page-block">
                                <div class="text-truncate" data-i18n="Declined">Declined</div>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php } ?>
            <?php if($decrypted_array['ADMIN_STATUS'] == 'PRIMARY'){?>
                <li class="menu-item <?php echo ($geturl == 'rca-list')? 'active' : 'collapsed' ?>">
                    <a href="rca-list" class="menu-link btn-page-block">
                        <i class="menu-icon fa-solid fa-solid fa-clipboard-list"></i>
                        <div> RCA/PCV List</div>
                        <?php if($r_rca['total'] == 0){}else{?>
                        <span
                            class="badge badge-center rounded-pill bg-danger ms-auto"><?php echo $r_rca['total']?></span>
                        <?php }?>
                    </a>
                </li>
            <?php } ?>
            <li class="menu-item <?php echo ($geturl == 'request-list')? 'active' : 'collapsed' ?>">
                <a href="request-list" class="menu-link btn-page-block">
                    <i class="menu-icon fa-solid fa-solid fa-clipboard-list"></i>
                    <div> Request List</div>
                    <?php if($count_pending['total'] == 0){}else{?>
                    <span
                        class="badge badge-center rounded-pill bg-danger ms-auto"><?php echo $count_pending['total']?></span>
                    <?php }?>
                </a>
            </li>
            <li class="menu-item <?php echo ($geturl == 'purchase-list')? 'active' : 'collapsed' ?>">
                <a href="purchase-list" class="menu-link btn-page-block">
                    <i class="menu-icon fa-solid fa-solid fa-clipboard-list"></i>
                    <div> Purchase List</div>
                    <?php if($pr_status['total'] == 0){}else{?>
                    <span class="badge badge-center rounded-pill bg-danger ms-auto"><?php echo $pr_status['total']?></span>
                    <?php }?>
                </a>
            </li>
            <?php if($decrypted_array['ACCESS'] == 'ADMIN'){?>
                <!-- Admin -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text" data-i18n="Admin">Admin</span>
                </li>
                <li class="menu-item <?php echo ($geturl == 'user_list')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>user_list" class="menu-link btn-page-block">
                        <i class='menu-icon fa-solid fa-user-gear'></i>
                        <div> Manage Users</div>
                    </a>
                </li>
                <li class="menu-item <?php echo ($geturl == 'logs')? 'active' : 'collapsed' ?>">
                    <a href="<?php BASE_URL; ?>logs" class="menu-link btn-page-block">
                        <i class='menu-icon tf-icons bx bxs-book'></i>
                        <div> History List</div>
                    </a>
                </li>
            <?php } ?>
    </ul>

</aside>
<!-- / Menu -->