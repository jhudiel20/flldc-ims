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
                                                <?php if($row['setup'] == 'OTHER'){?>
                                                    <h2 class="mb-2" >Please ask Mr. James Solis for the custom setup</h2>
                                                <?php }else{?>
                                                    <img src="<?php echo empty($row['setup']) ? '' : "../assets/img/".$row['setup'].''.".png"; ?>"  style="height:220px;" class="mb-3"  />
                                                    <h5>Seating Arrangement</h5>
                                                <?php } ?>
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
                                            <form class="row g-3" method="post" id="">
                                                            <input type="hidden" id="ID" name="ID" value="<?php echo $id;?>">
                                                            <input type="hidden" id="bookingID" name="bookingID" value="<?php echo $row['booking_id'];?>">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Booking ID</label>
                                                                <input type="text" class="form-control" name="" id=""
                                                                    value="<?php echo $row['booking_id']; ?>" disabled>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Reservation ID</label>
                                                                <input type="text" class="form-control" name="" id=""
                                                                    value="<?php echo $row['reservation_id']; ?>" disabled>
                                                            </div>
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
                                                                <input type="date" class="form-control" 
                                                                    name="reserve_date" id="reserve_date"
                                                                    value="<?php echo $row['reserve_date'];?>" >
                                                                    <!-- value="<?php //echo ($row['reserve_date'] ? (new DateTime($row['reserve_date']))->format('M d, Y') : ''); ?>"> -->
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label class="form-label">Room</label>
                                                                    <select name="room" id="room" class="form-control" required>
                                                                        <option value="Room-301" <?php if($row['room'] == "Room-301") echo 'selected'; ?>>Room 301</option>
                                                                        <option value="Room-302" <?php if($row['room'] == "Room-302") echo 'selected'; ?>>Room 302</option>
                                                                        <option value="Room-303" <?php if($row['room'] == "Room-303") echo 'selected'; ?>>Romm 303</option>
                                                                        <option value="Room-304" <?php if($row['room'] == "Room-304") echo 'selected'; ?>>Room 304</option>    
                                                                        <option value="Confe-1" <?php if($row['room'] == "Confe-1") echo 'selected'; ?>>Conference 1</option>    
                                                                        <option value="Confe-2" <?php if($row['room'] == "Confe-2") echo 'selected'; ?>>Conference 2</option>    
                                                                        <option value="IT-Room" <?php if($row['room'] == "IT-Room") echo 'selected'; ?>>IT Room</option>    
                                                                    </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Time</label>
                                                                    <select name="time" id="time" class="form-control" required>
                                                                        <option value="7:00AM-12:00PM" <?php if($row['time'] == "7:00AM-12:00PM") echo 'selected'; ?>>HALFDAY (7:00AM-12:00PM)</option>
                                                                        <option value="1:00PM-6:00PM" <?php if($row['time'] == "1:00PM-6:00PM") echo 'selected'; ?>>HALFDAY (1:00PM-6:00PM)</option>
                                                                        <option value="7:00AM-6:00PM" <?php if($row['time'] == "7:00AM-6:00PM") echo 'selected'; ?>>WHOLE DAY (7:00AM-6:00PM)</option>    
                                                                    </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Seating Arrangement</label>
                                                                    <select name="setup" id="setup" class="form-control">
                                                                        <option value="CLASS ROOM" <?php if($row['setup'] == "CLASS ROOM") echo 'selected'; ?>>CLASS ROOM</option>
                                                                        <option value="FISHBONE" <?php if($row['setup'] == "FISHBONE") echo 'selected'; ?>>FISHBONE</option>
                                                                        <option value="THEATER" <?php if($row['setup'] == "THEATER") echo 'selected'; ?>>THEATER</option>
                                                                        <option value="U-SHAPE" <?php if($row['setup'] == "U-SHAPE") echo 'selected'; ?>>U-SHAPE</option>
                                                                        <option value="CONFERENCE" <?php if($row['setup'] == "CONFERENCE") echo 'selected'; ?>>CONFERENCE</option>
                                                                        <option value="OTHER" <?php if($row['setup'] == "OTHER") echo 'selected'; ?>>OTHER</option>
                                                                    </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Guest</label>
                                                                <input type="text" class="form-control" name="guest"
                                                                    id="guest"
                                                                    value="<?php echo $row['guest']; ?>" disabled>
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
                                                            <div class="col-md-4">
                                                                <label class="form-label">Bussiness Unit</label>
                                                                <select name="businessunit" id="businessunit" class="form-control">
                                                                    <option value="FLC" <?php if($row['business_unit'] == "FLC") echo 'selected'; ?>>FAST LOGISTICS CORPORATION</option>
                                                                    <option value="FSC" <?php if($row['business_unit'] == "FSC") echo 'selected'; ?>>FAST SERVICES CORPORATION</option>
                                                                    <option value="FTMC" <?php if($row['business_unit'] == "FTMC") echo 'selected'; ?>>FAST TOLL MANUFACTURING CORPORATION</option>
                                                                    <option value="FCSI" <?php if($row['business_unit'] == "FCSI") echo 'selected'; ?>>FAST COLDCHAIN SOLUTION INC.</option>
                                                                    <option value="FDC" <?php if($row['business_unit'] == "FDC") echo 'selected'; ?>>FAST DISTRIBUTION CORPORATION</option>
                                                                    <option value="FUI" <?php if($row['business_unit'] == "FUI") echo 'selected'; ?>>FAST UNIMERCHANT INC.</option>
                                                                    <option value="other" <?php if($row['business_unit'] == "other") echo 'selected'; ?>>OTHER</option>
                                                                </select>
                                                            </div>
                                                         
                                                            <div class="col-md-4">
                                                                <label class="form-label">Contact No.<span
                                                                        class="require asterisk">*</span></label>
                                                                <input type="text" class="form-control" name="contact"
                                                                    id="contact" value="<?php echo $row['contact']; ?>">
                                                            </div>
                                                            <div class="col-md-4">
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
                                                            <button type="button" class="btn btn-label-primary update-details">Update</button>
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
            <?php include __DIR__ . "/../modals/reservation_details_modal.php"; ?>
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
    $('#submit_edit_reserve_details').on('click', function() {
        var formdata = new FormData(reserve_details_form);

        $.ajax({
            url: "/edit_reserve_details_info",
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
    });
    $(document).on("click", ".update-details", function() {
        $('#edit_reserve_details_modal').modal('show');

            // Get the values from the form inputs
            var ID = $("#ID").val();
            var bookingID = $("#bookingID").val();
            var reservationID = $("#reservationID").val();
            var reserveStatus = $("#reserve_status").val();
            var reserveDate = $("#reserve_date").val();
            var fname = $("#fname").val();
            var lname = $("#lname").val();
            var time = $("#time").val();
            var room = $("#room").val();
            var setup = $("#setup").val();
            var businessUnit = $("#businessunit").val();
            var guest = $("#guest").val();
            var contact = $("#contact").val();
            var email = $("#email").val();
            var message = $("#message").val();

            // Pass the values to the modal's input fields
            $('#edit_reserve_details_modal #ID').val(ID);
            $('#edit_reserve_details_modal #bookingID').val(bookingID);
            $('#edit_reserve_details_modal #reservationID').val(reservationID);
            $('#edit_reserve_details_modal #reserve_status').val(reserveStatus);
            $('#edit_reserve_details_modal #reserve_date').val(reserveDate);
            $('#edit_reserve_details_modal #fname').val(fname);
            $('#edit_reserve_details_modal #lname').val(lname);
            $('#edit_reserve_details_modal #time').val(time);
            $('#edit_reserve_details_modal #room').val(room);
            $('#edit_reserve_details_modal #setup').val(setup);
            $('#edit_reserve_details_modal #businessunit').val(businessUnit);
            $('#edit_reserve_details_modalv #guest').val(guest);
            $('#edit_reserve_details_modal #contact').val(contact);
            $('#edit_reserve_details_modal #email').val(email);
            $('#edit_reserve_details_modal #message').val(message);
    });

});



</script>

</html>
