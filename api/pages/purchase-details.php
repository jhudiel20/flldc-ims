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

$sql = $conn->prepare("SELECT * FROM purchase_order WHERE ID = :id ");
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
                        <h4><span class="text-muted fw-light">Purchase List /</span> Purchase Details</h4>
                        <div class="col-12 col-lg-4 order-3 order-md-3 order-lg-3 mb-2">
                            <div class="card">
                                <div class="row row-bordered g-0">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="text-center">
                                            <img src="https://raw.githubusercontent.com/jhudiel20/$owner/main/requested-items/<?php echo empty($row['item_photo']) ? 'default.png' : $row['item_photo']; ?>"  style="height:220px;" />
                                                <?php if ($decrypted_array['ACCESS'] == 'ENCODER' || $decrypted_array['ACCESS'] == 'ADMIN') { ?>
                                                <div class="my-3">
                                                    <form class="row g-3" method="post" id="upload_item_photo_form"
                                                        enctype="multipart/form-data" style="display: inline-block;">

                                                        <div class="col-md-12 col-lg-12">
                                                            <input type="file" name="item_photo" id="item_photo"
                                                                class="form-control w-100">
                                                            <input type="hidden" name="ID" id="ID"
                                                                value="<?php echo $id ?>">
                                                            <input type="hidden" name="photo_item_name"
                                                                id="photo_item_name"
                                                                value="<?php echo $row['item_name'] ?>">
                                                            <input type="hidden" name="photo_pr_id" id="photo_pr_id"
                                                                value="<?php echo $row['pr_id'] ?>">

                                                        </div>
                                                        <div class="text-center">
                                                            <button type="button" id="submit_upload_item_photo"
                                                                value="Upload" class="btn btn-label-primary"><i
                                                                    class="fa-solid fa-upload"></i></button>
                                                    </form>
                                                    <button type="button" class="btn btn-label-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#delete_item_photo_modal"><i
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

                        <!-- <div class="card"> -->
                        <div class="row row-bordered g-0">
                            <div class="col-md-12">
                                <div class="card-body" style="overflow-x:auto;">

                                    <div class="nav-align-top mb-2">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                    data-bs-target="#purchase-info" aria-controls="navs-justified-home"
                                                    aria-selected="true">
                                                    <i class="fa-solid fa-circle-info"></i> Purchase Order Info
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                    data-bs-target="#attachments" aria-controls="navs-justified-profile"
                                                    aria-selected="false">
                                                    <i class="fa-solid fa-file-pdf"></i> Attachments
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                    data-bs-target="#history" aria-controls="navs-justified-profile"
                                                    aria-selected="false">
                                                    <i class="fa-solid fa-timeline"></i> History
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade" id="purchase-info" role="tabpanel">
                                                <form class="row g-3" method="post" id="purchase_details_form">
                                                    <input type="hidden" id="ID" name="ID" value="<?php echo $id;?>">
                                                    <input type="hidden" id="PR_OLD" name="PR_OLD"
                                                        value="<?php echo $row['pr_no'];?>">
                                                    <input type="hidden" id="PO_OLD" name="PO_OLD"
                                                        value="<?php echo $row['po_no'];?>">
                                                    <input type="hidden" id="OSTICKET_OLD" name="OSTICKET_OLD"
                                                        value="<?php echo $row['os_ticket_no'];?>">
                                                    <input type="hidden" id="REQUEST_ID" name="REQUEST_ID"
                                                        value="<?php echo $row['request_id']; ?>">

                                                    <div class="col-md-6">
                                                        <label class="form-label">Purchase Order ID</label>
                                                        <input type="text" class="form-control"
                                                            value="<?php echo $row['pr_id']; ?>" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Approval Date Created</label>
                                                        <input type="text" class="form-control"
                                                            name="APPROVAL_DATE_CREATED" id="APPROVAL_DATE_CREATED"
                                                            value="<?php echo ($row['approval_date_created'] ? (new DateTime($row['approval_date_created']))->format('M d, Y h:i A') : ''); ?>"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Purpose</label>
                                                        <input type="text" class="form-control"
                                                            value="<?php echo $row['purpose']; ?>" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Date Needed</label>
                                                        <input type="text" class="form-control"
                                                            value="<?php echo ($row['date_needed'] ? (new DateTime($row['date_needed']))->format('M d, Y') : ''); ?>"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">PR No.</label>
                                                        <input type="text" class="form-control" name="PR_NO" id="PR_NO"
                                                            value="<?php echo $row['pr_no']; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">PO No.</label>
                                                        <input type="text" class="form-control" name="PO_NO" id="PO_NO"
                                                            value="<?php echo $row['po_no']; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">OS-TICKET NO.</label>
                                                        <input type="text" class="form-control" name="OS_TICKET_NO"
                                                            id="OS_TICKET_NO"
                                                            value="<?php echo $row['os_ticket_no']; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Item Name<span
                                                                class="require asterisk">*</span></label>
                                                        <input type="text" class="form-control" name="ITEM_NAME"
                                                            id="ITEM_NAME" value="<?php echo $row['item_name']; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Quantity<span
                                                                class="require asterisk">*</span></label>
                                                        <input type="text" class="form-control" name="QUANTITY"
                                                            id="QUANTITY" value="<?php echo $row['quantity']; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Status</label>
                                                        <select name="STATUS" id="STATUS" class="form-select"
                                                            <?php echo ($decrypted_array['ACCESS'] == 'REQUESTOR') ? 'disabled' : ''; ?>>
                                                            <?php foreach (PR_STATUS as $value) { ?>
                                                            <option value="<?= $value; ?>"
                                                                <?php echo ($value == $row['status']) ? 'selected' : ''; ?>>
                                                                <?= $value; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label py-1">Item Description </label>
                                                        <textarea class="form-control" type="text" cols="30"
                                                            name="ITEM_DESC" id="ITEM_DESC"
                                                            rows="3"><?php echo $row['description']; ?></textarea>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label py-1">Remarks </label>
                                                        <textarea class="form-control" name="REMARKS" id="REMARKS"
                                                            type="text" cols="30"
                                                            rows="3"><?php echo $row['remarks']; ?></textarea>
                                                    </div>

                                                    <?php if($decrypted_array['ACCESS'] != 'REQUESTOR'){?>
                                                    <button type="button" class="btn btn-label-primary"
                                                        id="submit_edit_purchase_details"
                                                        name="submit_edit_purchase_details">Save</button>
                                                        <button class="btn btn-label-primary d-none" type="button" id="submit_icon" disabled>
                                                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                            Loading...
                                                        </button>
                                                    <?php }?>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="attachments" role="tabpanel">

                                                <div class="card-body">
                                                    <div class="col-xl-12">
                                                        <div class="card">
                                                            <?php if(empty($row['attachments'])){ ?>
                                                            <h1
                                                                style="width: auto;height:500px;text-align:center;padding-top:200px">
                                                                Empty!</h1>
                                                            <?php }else{ ?>
                                                                <iframe
                                                                    src="/fetch_pdf?file=<?php echo urlencode($row['attachments']); ?>"
                                                                    width="auto"
                                                                    height="700px"
                                                                    style="border: none;">
                                                                </iframe>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <?php if($decrypted_array['ACCESS'] != "REQUESTOR"){?>
                                                    <div class="col-6 py-3" style="float: left; display: inline-block;">

                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#upload-PO_ATTACHMENT-modal"
                                                            class="btn btn-label-primary"
                                                            style="width:95%">Upload</button>
                                                        <button class="btn btn-label-primary d-none" type="button" id="submit_icon" disabled>
                                                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                            Loading...
                                                        </button>
                                                    </div>

                                                    <div class="col-6 py-3" style="display:inline-block;">
                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#delete-PO_ATTACHMENT-modal"
                                                            class="btn btn-label-danger"
                                                            style="width:95%">Delete</button>
                                                    </div>
                                                    <?php } ?>

                                                </div>


                                            </div>
                                            <div class="tab-pane fade" id="history" role="tabpanel">
                                                <div class="col-xl-12 mb-4 mb-xl-0">
                                                    <div class="card">
                                                        <h5 class="card-header">History</h5>
                                                        <div class="card-body">
                                                            <ul class="timeline">
                                                                        <?php
                                                                        $request_id = $row['request_id'];
                                                                        $sql_history = $conn->prepare("SELECT * FROM po_history WHERE request_id = :request_id ORDER BY date_created DESC");
                                                                        $sql_history->bindParam(':request_id', $request_id, PDO::PARAM_STR);
                                                                        $sql_history->execute();
                                                                        
                                                                        $classes = ['primary', 'success', 'danger', 'info', 'warning'];
                                                                        $class_index = 0; // Initialize class index
                                                                        
                                                                        while ($row_sql_history = $sql_history->fetch(PDO::FETCH_ASSOC)) {
                                                                            // Get the class from the array based on the index
                                                                            $class = $classes[$class_index];
                                                                        
                                                                            // Increment the index, looping back to the beginning if necessary
                                                                            $class_index = ($class_index + 1) % count($classes);
                                                                            ?>
                                                                            <li class="timeline-item timeline-item-transparent">
                                                                                <span class="timeline-point-wrapper">
                                                                                    <span class="timeline-point timeline-point-<?php echo htmlspecialchars($class); ?>"></span>
                                                                                </span>
                                                                                <div class="timeline-event">
                                                                                    <div class="timeline-header border-bottom mb-3">
                                                                                        <h6 class="mb-0">
                                                                                            <?php echo htmlspecialchars($row_sql_history['title']); ?>
                                                                                        </h6>
                                                                                        <span class="text-muted">
                                                                                            <?php echo date('M d, Y', strtotime($row_sql_history['date_created'])); ?>
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="d-flex justify-content-between flex-wrap mb-2">
                                                                                        <div>
                                                                                            <span><?php echo nl2br(htmlspecialchars($row_sql_history['remarks'])); ?></span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <span class="text-muted">
                                                                                                <?php echo date('h:i:s A', strtotime($row_sql_history['date_created'])); ?>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        

                                                                <li class="timeline-end-indicator">
                                                                    <i class="bx bx-check-circle"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- </div> -->

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
            url: "/edit_purchase_details_info",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#submit_edit_purchase_details').hide();
                $('#submit_icon').removeClass('d-none').prop('disabled', true);
            },
            success: function(response) {
                $('#submit_icon').addClass('d-none').prop('disabled', false);
                $('#submit_edit_purchase_details').show();
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
    $('#submit_po_attachments').on('click', function() {
        var formdata = new FormData(dropzone_basic);

        $.ajax({
            url: "/upload_po_attachment",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#submit_po_attachments').hide();
                $('#submit_icon').removeClass('d-none').prop('disabled', true);
            },
            success: function(response) {
                $('#submit_icon').addClass('d-none').prop('disabled', false);
                $('#submit_po_attachments').show();
                console.log(response);
                if (response.success) {
                    $('#upload-PO_ATTACHMENT-modal').modal('hide');
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
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // For debugging
                var errorMessage = 'An error occurred: ' + (xhr.status ? xhr.status + ' ' + xhr.statusText : 'Unknown error');

                if (xhr.status === 413) {
                    swal({
                        icon: 'error',
                        title: 'Upload Error',
                        text: 'File size too large.',
                        buttons: false,
                        timer: 2000,
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'error',
                        title: 'Upload Error',
                        text: errorMessage,
                        buttons: false,
                        timer: 2000,
                    });
                }
            }
        });
    })
    $('#delete_po_attachments').on('click', function() {
        var formdata = new FormData(delete_po_attachments_form);

        $.ajax({
            url: "/delete_po_attachments",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#delete_po_attachments').hide();
                $('#delete_po_icon').removeClass('d-none').prop('disabled', true);
            },
            success: function(response) {
                $('#delete_po_icon').addClass('d-none').prop('disabled', false);
                $('#delete_po_attachments').show();
                console.log(response);
                if (response.success) {
                    $('#delete-PO_ATTACHMENT-modal').modal('hide');
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
    $('#submit_upload_item_photo').on('click', function() {
        var formdata = new FormData(upload_item_photo_form);

        $.ajax({
            url: "../action/upload_item_photo.php",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response.success) {
                    $('#upload-PO_ATTACHMENT-modal').modal('hide');
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
    $('#delete_item_photo').on('click', function() {
        var formdata = new FormData(delete_item_photo_form);

        $.ajax({
            url: "../action/delete_item_photo.php",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,

            success: function(response) {
                console.log(response);
                if (response.success) {
                    $('#delete-PO_ATTACHMENT-modal').modal('hide');
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

document.addEventListener("DOMContentLoaded", function() {
    // Get the active tab for the first set of tabs from localStorage or set a default value
    let tab1 = localStorage.getItem("tab1") || "#purchase-info";

    // Set the active tab for the first set of tabs only if the screen width is greater than 768px
    if (window.innerWidth > 768) {
        $('.nav-align-top .nav-link[data-bs-target="' + tab1 + '"]').tab('show');
    }

    // Save the active tab for the first set of tabs to localStorage when a tab is clicked
    $('.nav-align-top .nav-link').on('shown.bs.tab', function(e) {
        let newActiveTab1 = $(e.target).attr("data-bs-target");
        localStorage.setItem("tab1", newActiveTab1);
    });

    console.log(tab1);
});

// STORING CLICK TABS 
</script>

</html>

<div class="modal fade" id="delete_item_photo_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete a photo?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_item_photo_form" style="display: inline-block;">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" name="photo_pr_id" id="photo_pr_id" value="<?php echo $row['pr_id'] ?>">
                    <input type="hidden" name="photo_item_name" id="photo_item_name"
                        value="<?php echo $row['item_name'] ?>">
                    <input style="width:auto" type="hidden" name="item_image_to_delete" class="form-control"
                        value="<?php echo $row['item_photo']; ?>">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="delete_item_photo" class="btn btn-danger"
                        data-bs-dismiss="modal">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- End delete employee photo Modal-->