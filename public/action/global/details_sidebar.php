

<?php $geturl = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); 

$user_id = $_SESSION['ID'];
    $sql_user = mysqli_query($conn_acc, "SELECT * FROM user_account WHERE ID = '$user_id'");
    $sql_user = mysqli_fetch_assoc($sql_user);


?>
<style>
    a {
        color: white;
    }
</style>
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-darkest">
          <div class="app-brand demo">
            <a href="dashboard.php" class="app-brand-link">
      
                <img src="assets/img/BRAND-LOGO1.PNG" height="75px" style="border-radius:10%">
              <!-- <span class="demo menu-text fw-bolder ms-2">Hipak Mabuhay</span> -->
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <li class="menu-header small text-uppercase">
              <span class="menu-header-text">NAVIGATION</span>
          </li>

          <ul class="menu-inner">

                
            <?php if ($geturl == 'purchase_details.php') { ?>
                            <li class="menu-item ">
                                <a href="<?php BASE_URL; ?>purchase_list.php" class="menu-link">
                                    <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                    <div> Back</div>
                                </a>
                            </li>
            <?php } ?>
            
            

            
          </ul>
        </aside>
         