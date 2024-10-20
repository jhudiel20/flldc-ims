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

$sql = $conn->prepare("SELECT * FROM room_details WHERE ID = :id ");
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
                        <h4><span class="text-muted fw-light"><a href="room-list">Room List</a> /</span> Room Details</h4>
                        <div class="col-12 col-lg-4 order-3 order-md-3 order-lg-3 mb-2">
                            <div class="card">
                                <div class="row row-bordered g-0">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="text-center">
                                            <img src="/fetch?file=<?php echo urlencode($row['room_photo']); ?>&db=room-photo" style="height:220px;" />
                                                <?php if ($decrypted_array['ACCESS'] == 'ADMIN') { ?>
                                                <div class="my-3">
                                                    <form class="row g-3" method="post" id="upload_room_photo_form"
                                                        enctype="multipart/form-data" style="display: inline-block;">

                                                        <div class="col-md-12 col-lg-12">
                                                            <input type="file" name="room_photo" id="room_photo"
                                                                class="form-control w-100">
                                                            <input type="hidden" name="ID" id="ID"
                                                                value="<?php echo $id ?>">
                                                            <input type="hidden" name="room_name"
                                                                id="room_name"
                                                                value="<?php echo $row['room_name'] ?>">
                                                            <input type="hidden" name="room_id" id="room_id"
                                                                value="<?php echo $row['room_id'] ?>">

                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" id="upload_room_photo_btn" value="Upload" class="btn btn-label-primary"><i
                                                                    class="fa-solid fa-upload"></i></button>
                                                                    <button class="btn btn-label-primary d-none loading-btn" type="button" disabled>
                                                                        <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                                        Loading...
                                                                    </button>
                                                    </form>
                                                    <button type="button" class="btn btn-label-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#delete_room_photo_modal"><i
                                                            class="fa-solid fa-trash-can"></i></button>

                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-8 order-4 order-md-4 order-lg-4 mb-2">
                        <div class="card">
                            <!-- <div class="card"> -->
                            <div class="row row-bordered g-0">
                                <div class="col-md-12">
                                    <div class="card-body" style="overflow-x:auto;">
                                                    <form class="row g-3" method="post" id="room_details_form">
                                                        <input type="hidden" id="ID" name="ID" value="<?php echo $id;?>">
                                                        <input type="hidden" id="roomid" name="roomid" value="<?php echo $row['room_id'];?>">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Room Name<span class="require asterisk">*</span></label>
                                                            <input type="text" class="form-control" name="roomname" id="roomname" value="<?php echo $row['room_name']?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Room Type<span class="require asterisk">*</span></label>
                                                            <select name="roomtype" id="roomtype" class="form-control">
                                                                <option value="Meeting-Room" <?php if($row['room_type'] == "Meeting-Room") echo 'selected'; ?>>Meeting Room</option>
                                                                <option value="Training-Room" <?php if($row['room_type'] == "Training-Room") echo 'selected'; ?>>Training Room</option>
                                                                <option value="Both" <?php if($row['room_type'] == "Both") echo 'selected'; ?>>Both</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Capacity<span class="require asterisk">*</span></label>
                                                            <input type="number" class="form-control" name="capacity" id="capacity" min="1" value="<?php echo $row['capacity']?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Floor Number<span class="require asterisk">*</span></label>
                                                            <input type="number" class="form-control" name="floornumber" id="floornumber" value="<?php echo $row['floor_number']?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Status<span class="require asterisk">*</span></label>
                                                            <select name="status" id="status" class="form-control">
                                                                <option value="Not-Available" <?php if($row['status'] == "Not-Available") echo 'selected'; ?>>Not Available</option>
                                                                <option value="Available" <?php if($row['status'] == "Available") echo 'selected'; ?>>Available</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label">Features</label>
                                                            <textarea type="text" class="form-control" name="features" id="features" cols="20"
                                                                rows="3"><?php echo $row['features']?></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label">Usage</label>
                                                            <textarea type="text" class="form-control" name="usage" id="usage" cols="20"
                                                                rows="3"><?php echo $row['usage']?></textarea>
                                                        </div>

                                                        <?php if($decrypted_array['ACCESS'] != 'REQUESTOR'){?>
                                                        <button type="button" class="btn btn-label-primary"
                                                            id="edit_room_details_btn"
                                                            name="edit_room_details_btn">Save</button>
                                                            <button class="btn btn-label-primary d-none loading-btn" type="button" disabled>
                                                                <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                                Loading...
                                                            </button>
                                                        <?php }?>
                                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- / Content -->
            </div>




        </div>
        <!-- Footer -->
        <?php 
                    include __DIR__ . "/../action/global/footer.php";
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
        include __DIR__ . "/../modals/room_details_modal.php"; 
        include __DIR__ . "/../action/global/include_bottom.php";
      ?>
    <!-- Page JS -->
</body>

<script>
$(document).ready(function() {
    if ("<?php echo $decrypted_array['ACCESS']; ?>" === "REQUESTOR") {
        // Get all input elements with type "text"
        var form = document.getElementById('edit_room_form');

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
    $('#room_details_form').on('click', function() {
        var formdata = new FormData(purchase_details_form);

        $.ajax({
            url: "/edit_room_details",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                showLoading('#edit_room_details_btn');
            },
            success: function(response) {
                hideLoading('#edit_room_details_btn');
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
    // $('#upload_po_attachments_btn').on('click', function() {
    //     var formdata = new FormData(document.getElementById('upload_po_attachments_form'));

    //     $.ajax({
    //         url: "/upload_po_attachment",
    //         method: "POST",
    //         data: formdata,
    //         dataType: "json",
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         beforeSend: function() {
    //             $('#upload_po_attachments_btn').hide();
    //             $('#upload_po_attachments_icon').removeClass('d-none').prop('disabled', true);
    //         },
    //         success: function(response) {
    //             $('#upload_po_attachments_icon').addClass('d-none').prop('disabled', false);
    //             $('#upload_po_attachments_btn').show();
    //             console.log(response);
    //             if (response.success) {
    //                 swal({
    //                     icon: 'success',
    //                     title: response.title,
    //                     text: response.message,
    //                     buttons: false,
    //                     timer: '2000',
    //                 }).then(function() {
    //                     location.reload();
    //                 });

    //             } else {
    //                 swal({
    //                     icon: 'warning',
    //                     title: response.title,
    //                     text: response.message,
    //                     buttons: false,
    //                     timer: '2000',
    //                 })
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.error(xhr.responseText); // For debugging
    //             var errorMessage = 'An error occurred: ' + (xhr.status ? xhr.status + ' ' + xhr.statusText : 'Unknown error');

    //             if (xhr.status === 413) {
    //                 swal({
    //                     icon: 'error',
    //                     title: 'Upload Error',
    //                     text: 'File size too large.',
    //                     buttons: false,
    //                     timer: 2000,
    //                 }).then(function() {
    //                     location.reload();
    //                 });
    //             } else {
    //                 swal({
    //                     icon: 'error',
    //                     title: 'Upload Error',
    //                     text: errorMessage,
    //                     buttons: false,
    //                     timer: 2000,
    //                 });
    //             }
    //         }
    //     });
    // })
    // $('#delete_po_attachments_btn').on('click', function() {
    //     var formdata = new FormData(document.getElementById('delete_po_attachments_form'));

    //     $.ajax({
    //         url: "/delete_po_attachments",
    //         method: "POST",
    //         data: formdata,
    //         dataType: "json",
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         beforeSend: function() {
    //             $('#delete_po_attachments_btn').hide();
    //             $('#delete_po_attachments_icon').removeClass('d-none').prop('disabled', true);
    //         },
    //         success: function(response) {
    //             $('#delete_po_attachments_icon').addClass('d-none').prop('disabled', false);
    //             $('#delete_po_attachments_btn').show();
    //             console.log(response);
    //             if (response.success) {
    //                 swal({
    //                     icon: 'success',
    //                     title: response.title,
    //                     text: response.message,
    //                     buttons: false,
    //                     timer: '2000',
    //                 }).then(function() {
    //                     location.reload();
    //                 });

    //             } else {
    //                 swal({
    //                     icon: 'warning',
    //                     title: response.title,
    //                     text: response.message,
    //                     buttons: false,
    //                     timer: '2000',
    //                 })
    //             }
    //         }
    //     });
    // })
    $('#upload_room_photo_form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "/upload_room_photo",
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                    showLoading('#upload_room_photo_btn');
                },
                success: function(response) {
                    hideLoading('#upload_room_photo_btn');
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
    $('#delete_room_photo_form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/delete_room_photo",
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                    showLoading('#delete_room_photo_btn');
                },
                success: function(response) {
                    hideLoading('#delete_room_photo_btn');
                console.log(response);
                if (response.success) {
                    $('#delete_room_photo_modal').modal('hide');
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



// STORING CLICK TABS 
</script>

</html>
