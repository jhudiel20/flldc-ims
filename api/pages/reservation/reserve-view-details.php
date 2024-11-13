<?php
require_once __DIR__ . '/../../DBConnection.php';
require_once __DIR__ . '/../../config/config.php';

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:index.php");
}


$id = decrypted_string($_GET['ID']);


if(empty($id)){
    header("Location:404.php");
}

$sql = $conn->prepare("SELECT * FROM reservations WHERE ID = :id ");
$sql->bindParam(':id', $id, PDO::PARAM_STR);
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

?>
<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">

<head>
    <?php
    include __DIR__ . "/../../action/global/metadata.php";
    include __DIR__ . "/../../action/global/include_top.php";
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
                        <!-- Details -->
                        <h4><span class="text-muted fw-light"><a href="reservation-list">Reservation List</a> /</span> Reservation Details</h4>
                        <div class="col-12 col-lg-4 order-3 order-md-3 order-lg-3 mb-2">
                            <div class="card">
                                <div class="row row-bordered g-0">
                                    <div class="col-md-12">
                                        <div class="card-body"> 
                                            <div class="text-center">
                                            <img src="<?php echo empty($row['setup']) ? 'default.png' : "../assets/img/".$row['setup'].''.".png"; ?>"  style="height:220px;" />
                                            <h5>Seating Arrangement</h5>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-12 col-lg-8 order-4 order-md-4 order-lg-4 mb-2">

                            <div class="card">
                                <div class="row row-bordered g-0">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <form class="row g-3" method="post" id="reserve_details_form">
                                                            <input type="hidden" id="ID" name="ID" value="<?php echo $id;?>">
                                                            <input type="hidden" id="bookingID" name="bookingID" value="<?php echo $row['booking_id'];?>">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Reservation Status</label>
                                                                <select name="reserve_status" id="reserve_status" class="form-select" 
                                                                    <?php echo ($decrypted_array['ACCESS'] == 'REQUESTOR' || $decrypted_array['ACCESS'] == 'GUARD') ? 'disabled' : ''; ?>>
                                                                    <?php foreach (RESERVE_STATUS as $value) { ?>
                                                                    <option value="<?= $value; ?>"
                                                                        <?php echo ($value == $row['reserve_status']) ? 'selected' : ''; ?>>
                                                                        <?= $value; ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Date of Reservation</label>
                                                                <input type="text" class="form-control"
                                                                    name="reserve_date" id="reserve_date"
                                                                    value="<?php echo ($row['reserve_date'] ? (new DateTime($row['reserve_date']))->format('M d, Y h:i A') : ''); ?>"
                                                                    disabled>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">First Name</label>
                                                                <input type="text" class="form-control" name="fname" id="fname"
                                                                    value="<?php echo $row['fname']; ?>" disabled>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Last Name</label>
                                                                <input type="text" class="form-control" name="lname" id="lname"
                                                                    value="<?php echo $row['lname']; ?>" disabled>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <label class="form-label">Time</label>
                                                                    <select name="time" id="time" class="form-control" disabled required>
                                                                        <option value="7:00AM-12:00PM" <?php if($row['time'] == "7:00AM-12:00PM") echo 'selected'; ?>>HALFDAY (7:00AM-12:00PM)</option>
                                                                        <option value="1:00PM-6:00PM" <?php if($row['time'] == "1:00PM-6:00PM") echo 'selected'; ?>>HALFDAY (1:00PM-6:00PM)</option>
                                                                        <option value="7:00AM-6:00PM" <?php if($row['time'] == "7:00AM-6:00PM") echo 'selected'; ?>>WHOLE DAY (7:00AM-6:00PM)</option>    
                                                                    </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Seating Arrangement</label>
                                                                    <select name="setup" id="setup" class="form-control" disabled>
                                                                        <option value="CLASS ROOM" <?php if($row['setup'] == "CLASS ROOM") echo 'selected'; ?>>CLASS ROOM</option>
                                                                        <option value="FISHBONE" <?php if($row['setup'] == "FISHBONE") echo 'selected'; ?>>FISHBONE</option>
                                                                        <option value="THEATER" <?php if($row['setup'] == "THEATER") echo 'selected'; ?>>THEATER</option>
                                                                        <option value="U-SHAPE" <?php if($row['setup'] == "U-SHAPE") echo 'selected'; ?>>U-SHAPE</option>
                                                                        <option value="CONFERENCE" <?php if($row['setup'] == "CONFERENCE") echo 'selected'; ?>>CONFERENCE</option>
                                                                        <option value="OTHER" <?php if($row['setup'] == "OTHER") echo 'selected'; ?>>OTHER</option>
                                                                    </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Bussiness Unit</label>
                                                                <select name="businessunit" id="businessunit" class="form-control" disabled>
                                                                    <option value="FLC" <?php if($row['business_unit'] == "FLC") echo 'selected'; ?>>FAST LOGISTICS CORPORATION</option>
                                                                    <option value="FSC" <?php if($row['business_unit'] == "FSC") echo 'selected'; ?>>FAST SERVICES CORPORATION</option>
                                                                    <option value="FTMC" <?php if($row['business_unit'] == "FTMC") echo 'selected'; ?>>FAST TOLL MANUFACTURING CORPORATION</option>
                                                                    <option value="FCSI" <?php if($row['business_unit'] == "FCSI") echo 'selected'; ?>>FAST COLDCHAIN SOLUTION INC.</option>
                                                                    <option value="FDC" <?php if($row['business_unit'] == "FDC") echo 'selected'; ?>>FAST DISTRIBUTION CORPORATION</option>
                                                                    <option value="FUI" <?php if($row['business_unit'] == "FUI") echo 'selected'; ?>>FAST UNIMERCHANT INC.</option>
                                                                    <option value="other" <?php if($row['business_unit'] == "other") echo 'selected'; ?>>OTHER</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Guest</label>
                                                                <input type="text" class="form-control" name="guest"
                                                                    id="guest"
                                                                    value="<?php echo $row['guest']; ?>" disabled>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Contact No.<span
                                                                        class="require asterisk">*</span></label>
                                                                <input type="text" class="form-control" name="contact"
                                                                    id="contact" value="<?php echo $row['contact']; ?>" disabled>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Email<span
                                                                        class="require asterisk">*</span></label>
                                                                <input type="text" class="form-control" name="email"
                                                                    id="email" value="<?php echo $row['email']; ?>" disabled>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label py-1">Purpose / Message </label>
                                                                <textarea class="form-control" name="message" id="message" disabled
                                                                    type="text" cols="30"
                                                                    rows="3"><?php echo $row['message']; ?></textarea>
                                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- / Content -->
            </div>
        
            <!-- Footer -->
            <?php include __DIR__ . "/../../action/global/footer.php"; ?>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>

        </div><!-- Content wrapper -->

    </div>
    <!-- / Layout page -->
    



    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->



    <?php
        include __DIR__ . "/../../action/global/include_bottom.php";
      ?>
    <!-- Page JS -->
</body>
</html>
