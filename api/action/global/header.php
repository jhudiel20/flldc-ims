
<!-- / Menu -->
<!-- Layout container -->
<div class="layout-page">
    <!-- Navbar -->

    <nav class="layout-navbar container navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    <div class="logo d-flex align-items-cenert w-auto mb-2 pt-2 py-1 ms-2">
                        <span><?php include __DIR__. "/date.php";?></span>
                    </div>
                </div>
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">

                        <?php $user_id = $decrypted_array['ID'];
                            $profile = $conn->prepare("SELECT * FROM user_account WHERE ID = :user_id");
                            $profile->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                            $profile->execute();
                            $profile_user = $profile->fetch(PDO::FETCH_ASSOC);   ?>

                        <img src="https://raw.githubusercontent.com/jhudiel20/flldc-user-image/main/images/<?php echo empty($profile_user['image']) ? 'user.png' : $profile_user['image']; ?>"  alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/acc-settings">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                        <img src="https://raw.githubusercontent.com/jhudiel20/flldc-user-image/main/images/<?php echo empty($profile_user['image']) ? 'user.png' : $profile_user['image']; ?>"  alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span
                                            class="fw-semibold d-block"><?php echo $decrypted_array['FNAME'].' '.$decrypted_array['MNAME'].' '.$decrypted_array['LNAME']; ?></span>
                                        <small class="text-muted"><?php echo $decrypted_array['ACCESS']; ?></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/acc-settings">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="/logout">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                    </a>
                </li>
            </ul>
            </li>
            <!--/ User -->
            </ul>
        </div>

        <!-- Search Small Screens -->
        <div class="navbar-search-wrapper search-input-wrapper d-none">
            <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
                aria-label="Search..." />
            <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
        </div>
    </nav>

    <!-- / Navbar -->