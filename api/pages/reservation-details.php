<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

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
    include __DIR__ . "/../action/global/metadata.php";
    include __DIR__ . "/../action/global/include_top.php";
    ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            <?php
            include __DIR__ . "/../action/global/sidebar.php";
            include __DIR__ . "/../action/global/header.php"; 
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
                                            Seating Arrangement    
                                        </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-12 col-lg-8 order-4 order-md-4 order-lg-4 mb-2">

                            <!-- <div class="card"> -->
                            <div class="row row-bordered g-0">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <form class="row g-3" method="post" id="reserve_details_form">
                                                        <input type="hidden" id="ID" name="ID" value="<?php echo $id;?>">
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
                                                            <label class="form-label">First Name</label>
                                                            <input type="text" class="form-control"
                                                                value="<?php echo $row['fname']; ?>" disabled>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Last Name</label>
                                                            <input type="text" class="form-control"
                                                                value="<?php echo $row['lname']; ?>" disabled>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Date of Reservation</label>
                                                            <input type="text" class="form-control"
                                                                name="reserve_date" id="reserve_date"
                                                                value="<?php echo ($row['reserve_date'] ? (new DateTime($row['reserve_date']))->format('M d, Y h:i A') : ''); ?>"
                                                                disabled>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Time</label>
                                                            <input type="text" class="form-control"
                                                                value="<?php echo $row['time']; ?>"
                                                                disabled>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Seating Arrangement</label>
                                                            <input type="text" class="form-control" name="setup" id="setup"
                                                                value="<?php echo $row['setup']; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Bussiness Unit</label>
                                                            <input type="text" class="form-control" name="bu" id="bu"
                                                                value="<?php echo $row['business_unit']; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Guest</label>
                                                            <input type="text" class="form-control" name="guest"
                                                                id="guest"
                                                                value="<?php echo $row['guest']; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Contact No.<span
                                                                    class="require asterisk">*</span></label>
                                                            <input type="text" class="form-control" name="contact"
                                                                id="contact" value="<?php echo $row['contact']; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Email<span
                                                                    class="require asterisk">*</span></label>
                                                            <input type="text" class="form-control" name="email"
                                                                id="email" value="<?php echo $row['email']; ?>">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label py-1">Purpose / Message </label>
                                                            <textarea class="form-control" name="message" id="message"
                                                                type="text" cols="30"
                                                                rows="3"><?php echo $row['message']; ?></textarea>
                                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->

                        </div>
                    </div>
                </div>
                <!-- / Content -->
            </div>
        
            <!-- Footer -->
            <?php include __DIR__ . "/../action/global/footer.php"; ?>
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
        include __DIR__ . "/../action/global/include_bottom.php";
      ?>
    <!-- Page JS -->
</body>

<script>
$(document).ready(function() {
    if ("<?php echo $decrypted_array['ACCESS']; ?>" === "REQUESTOR") {
        // Get all input elements with type "text"
        var form = document.getElementById('purchase_details_form');

        // Get all input elements with type "text" within the form
        var textInputs = form.querySelectorAll('input[type="text"]');
        var textareas = form.querySelectorAll('textarea');
        // Loop through each text input and disable it
        textInputs.forEach(function(input) {
            input.disabled = true;
        });
        textareas.forEach(function(textarea) {
            textarea.disabled = true;
        });
    }
    $('#submit_edit_purchase_details').on('click', function() {
        var formdata = new FormData(purchase_details_form);

        $.ajax({
            url: "../action/edit_purchase_details_info.php",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,

            success: function(response) {
                console.log(response);
                if (response.success) {
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    })

});

</script>

</html>
