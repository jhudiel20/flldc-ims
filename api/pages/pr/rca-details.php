<?php
require_once __DIR__ . '/../../DBConnection.php';
require_once __DIR__ . '/../../config/config.php';

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:/");
}


$id = decrypted_string($_GET['ID']);


if(empty($id)){
    header("Location:404");
}

$sql = $conn->prepare("SELECT * FROM rca WHERE ID = :id ");
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
                    
                        <div class="col-12 col-lg-12 order-4 order-md-4 order-lg-4 mb-2">

                            <!-- <div class="card"> -->
                            <?php if (substr($row['rca_id'], 0, 3) === 'RCA') { ?>
                                <h4><span class="text-muted fw-light"><a href="rca-list">RCA List</a>/</span> RCA Details</h4>
                                <div class="row row-bordered g-0">
                                    <div class="col-md-12">
                                        <div class="card-body" style="overflow-x:auto;">

                                            <div class="nav-align-top mb-2">
                                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                            data-bs-target="#rca-info" aria-controls="navs-justified-home"
                                                            aria-selected="true">
                                                            <i class="fa-solid fa-circle-info"> </i> RCA Info
                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                            data-bs-target="#attachments" aria-controls="navs-justified-profile"
                                                            aria-selected="false">
                                                            <i class="fa-solid fa-file-pdf"></i> Attachments
                                                        </button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade" id="rca-info" role="tabpanel">
                                                        <form class="row g-3" method="post" id="rca_details_form">
                                                            <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                                                            
                                                            <div class="col-md-6">
                                                                <label class="form-label">RCA ID</label>
                                                                <input type="text" class="form-control" 
                                                                    value="<?php echo $row['rca_id']; ?>" disabled>
                                                                    <input type="hidden" id="rca_id" name="rca_id" value="<?php echo $row['rca_id']; ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Status</label>
                                                                <select name="status" id="status" class="form-select">
                                                                    <?php foreach (PR_STATUS as $value) { ?>
                                                                    <option value="<?= $value; ?>"
                                                                        <?php echo ($value == $row['status']) ? 'selected' : ''; ?>>
                                                                        <?= $value; ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">NAME</label>
                                                                    <select name="employee" id="employee" class="form-select" value="<?php echo $row['name'];?>">
                                                                    <?php   $full_names = $conn->prepare("SELECT * FROM user_account WHERE ACCESS != 'GUARD' ");
                                                                                    $full_names->execute();
                                                                                    while ($row_full_names = $full_names->fetch(PDO::FETCH_ASSOC)) {
                                                                            ?>
                                                                            <option
                                                                                value="<?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>">
                                                                                <?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>
                                                                            </option>
                                                                            <?php } ?>
                                                                    </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Employee No.</label>
                                                                <input type="text" class="form-control" name="employee_no" id="employee_no" value="<?php echo $row['employee_no']; ?>" >
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Paygroup</label>
                                                                <select name="paygroup" id="paygroup" class="form-select">
                                                                    <?php foreach (PAYGROUP as $value) { ?>
                                                                        <option value="<?= $value; ?>" <?php echo ($value == $row['paygroup']) ? 'selected' : ''; ?>>
                                                                            <?= $value; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">SBU</label>                                                            
                                                                <select name="sbu" id="sbu" class="form-select">
                                                                    <?php foreach (SBU as $value) { ?>
                                                                        <option value="<?= $value; ?>" <?php echo ($value == $row['sbu']) ? 'selected' : ''; ?>>
                                                                            <?= $value; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">BRANCH</label>
                                                                <input type="text" class="form-control" name="branch" id="branch" value="<?php echo $row['branch']; ?>" >
                                                            </div>
                                                            <hr>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Amount</label>
                                                                <input type="text" class="form-control" name="amount" id="amount" value="<?php echo $row['amount']; ?>" >
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">PAYEE NAME</label>
                                                                <input type="text" class="form-control" name="payee" id="payee" value="<?php echo $row['payee_name']; ?>" >
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Account No.</label>
                                                                <input type="text" class="form-control" name="account_no" id="account_no" value="<?php echo $row['account_no']; ?>" >
                                                            </div>
                                                            <div class="form-check col-md-3 pt-4">
                                                                <input class="form-check-input" type="checkbox" value="" id="non_travel" <?php if(!empty($row['purpose_rca'])) { echo 'checked '; } ?> disabled/>
                                                                <label class="form-check-label" for=""> NON-TRAVEL </label>
                                                            </div>
                                                            <div class="form-check col-md-3 pt-4">
                                                                <input class="form-check-input" type="checkbox" value="" id="travel" <?php if(!empty($row['purpose_travel'])) { echo 'checked '; } ?> disabled/>
                                                                <label class="form-check-label" for=""> TRAVEL </label>
                                                            </div>
                                                            <hr>

                                                            <?php if(!empty($row['purpose_rca'])) {  ?>

                                                                <div class="col-md-12">
                                                                    <label class="form-label">Purpose of RCA<span
                                                                            class="require asterisk">*</span></label>
                                                                    <input type="text" class="form-control" name="purpose_rca" id="purpose_rca" value="<?php echo $row['purpose_rca']; ?>">
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Date Needed<span class="require asterisk">*</span></label>
                                                                    <input type="date" class="form-control" name="date_needed" id="date_needed" value="<?php echo $row['date_needed']; ?>">
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Date Event<span class="require asterisk">*</span></label>
                                                                    <input type="date" class="form-control" name="date_event" id="date_event" value="<?php echo $row['date_event']; ?>">
                                                                </div>

                                                            <?php }else{?>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Purpose of Travel<span
                                                                            class="require asterisk">*</span></label>
                                                                    <input type="text" class="form-control" name="purpose_travel" id="purpose_travel" value="<?php echo $row['purpose_travel']; ?>">
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Date of Departure<span
                                                                            class="require asterisk">*</span></label>
                                                                    <input type="date" class="form-control" name="date_depart" id="date_depart" value="<?php echo $row['date_depart']; ?>">
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Date of Return<span
                                                                            class="require asterisk">*</span></label>
                                                                    <input type="date" class="form-control" name="date_return" id="date_return" value="<?php echo $row['date_return']; ?>">
                                                                </div>
                                                            <?php } ?>

                                                            <div class="col-md-12">
                                                                <label class="form-label py-1">Remarks </label>
                                                                <textarea class="form-control" name="remarks" id="remarks"
                                                                    type="text" cols="30"
                                                                    rows="3"><?php echo $row['remarks']; ?></textarea>
                                                            </div>
                                                                <button type="submit" class="btn btn-label-primary" id="save">Save</button>
                                                                <button class="btn btn-label-primary d-none loading-btn" type="button" disabled>
                                                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                                    Loading...
                                                                </button>
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
                                                                                src="/fetch?file=<?php echo urlencode($row['attachments']); ?>&db=RCA_ATTACHMENTS"
                                                                                width="auto"
                                                                                height="700px"
                                                                                style="border: none;">
                                                                            </iframe>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 py-3" style="float: left; display: inline-block;">
                                                                <button type="button" data-bs-toggle="modal"
                                                                    data-bs-target="#upload_rca_modal"
                                                                    class="btn btn-label-primary"
                                                                    style="width:95%">Upload
                                                                </button>
                                                            </div>

                                                            <div class="col-6 py-3" style="display:inline-block;">
                                                                <button type="button" data-bs-toggle="modal"
                                                                    data-bs-target="#delete_rca_modal"
                                                                    class="btn btn-label-danger"
                                                                    style="width:95%">Delete
                                                                </button>
                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <h4><span class="text-muted fw-light"><a href="rca-list">PCV List</a> /</span> PCV Details</h4>
                                <div class="row row-bordered g-0">
                                    <div class="col-md-12">
                                        <div class="card-body" style="overflow-x:auto;">

                                            <div class="nav-align-top mb-2">
                                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                            data-bs-target="#rca-info" aria-controls="navs-justified-home"
                                                            aria-selected="true">
                                                            <i class="fa-solid fa-circle-info"> </i> PCV Info
                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                            data-bs-target="#attachments" aria-controls="navs-justified-profile"
                                                            aria-selected="false">
                                                            <i class="fa-solid fa-file-pdf"></i> Attachments
                                                        </button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade" id="rca-info" role="tabpanel">
                                                        <form class="row g-3" method="post" id="pcv_details_form">
                                                            <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                                                            
                                                            <div class="col-md-6">
                                                                <label class="form-label">PCV ID</label>
                                                                <input type="text" class="form-control" id="pcv_id" name="pcv_id"
                                                                    value="<?php echo $row['rca_id']; ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Status</label>
                                                                <select name="status" id="status" class="form-select">
                                                                    <?php foreach (PR_STATUS as $value) { ?>
                                                                    <option value="<?= $value; ?>"
                                                                        <?php echo ($value == $row['status']) ? 'selected' : ''; ?>>
                                                                        <?= $value; ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">PCV NO</label>
                                                                <input type="text" class="form-control" id="pcv_no" name="pcv_no"
                                                                    value="<?php echo $row['pcv_no']; ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">NAME</label>
                                                                    <select name="employee" id="employee" class="form-select" value="<?php echo $row['name'];?>">
                                                                    <?php   $full_names = $conn->prepare("SELECT * FROM user_account WHERE ACCESS != 'GUARD' ");
                                                                            $full_names->execute();
                                                                            while ($row_full_names = $full_names->fetch(PDO::FETCH_ASSOC)) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>">
                                                                        <?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>
                                                                    </option>
                                                                    <?php } ?>
                                                                    </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">SBU</label>                                                            
                                                                <select name="sbu" id="sbu" class="form-select">
                                                                    <?php foreach (SBU as $value) { ?>
                                                                        <option value="<?= $value; ?>" <?php echo ($value == $row['sbu']) ? 'selected' : ''; ?>>
                                                                            <?= $value; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">DEPARTMENT</label>
                                                                <input type="text" class="form-control" name="department" id="department" value="<?php echo $row['department']; ?>" >
                                                            </div>
                                                            <hr>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Total Expenses<span class="require asterisk">*</span></label>
                                                                <!-- <input type="text" class="form-control" name="amount" id="amount"> -->
                                                                <div class="input-group">
                                                                    <span class="input-group-text">₱</span>
                                                                    <input type="text" class="form-control" name="expenses" id="expenses" value="<?php echo $row['amount']; ?>"
                                                                        onKeyPress="if(this.value.length==12) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)"
                                                                        oninput="if(this.value!=''){this.value = parseFloat(this.value.replace(/,/g, '')).toLocaleString('en-US', {style: 'decimal', maximumFractionDigits: 0, minimumFractionDigits: 0})}">
                                                                    <span class="input-group-text">.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">DATE</label>
                                                                <input type="text" class="form-control" name="pcv_date" id="pcv_date" value="<?php echo $row['pcv_date']; ?>" >
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label py-1">Site/Dept/Cost Center to Charge: </label>
                                                                <textarea class="form-control" name="sdcc" id="sdcc"
                                                                    type="text" cols="30"
                                                                    rows="3"><?php echo $row['sdccc']; ?></textarea>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label py-1">Justification/Remarks </label>
                                                                <textarea class="form-control" name="remarks" id="remarks"
                                                                    type="text" cols="30"
                                                                    rows="3"><?php echo $row['remarks']; ?></textarea>
                                                            </div>
                                                                <button type="submit" class="btn btn-label-primary" id="save" >Save</button>
                                                                <button class="btn btn-label-primary d-none loading-btn" type="button" disabled>
                                                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                                    Loading...
                                                                </button>
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
                                                                            src="/fetch?file=<?php echo urlencode($row['attachments']); ?>&db=PCV_ATTACHMENTS"
                                                                            width="auto"
                                                                            height="700px"
                                                                            style="border: none;">
                                                                        </iframe>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 py-3" style="float: left; display: inline-block;">

                                                                <button type="button" data-bs-toggle="modal"
                                                                    data-bs-target="#upload_pcv_modal"
                                                                    class="btn btn-label-primary"
                                                                    style="width:95%">Upload</button>
                                                            </div>

                                                            <div class="col-6 py-3" style="display:inline-block;">
                                                                <button type="button" data-bs-toggle="modal"
                                                                    data-bs-target="#delete_pcv_modal"
                                                                    class="btn btn-label-danger"
                                                                    style="width:95%">Delete</button>
                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- </div> -->

                        </div>
                    </div>
                    <!-- / Content -->
                </div>




                </div>
                <!-- Footer -->
                <?php
                    include __DIR__ . "/../../modals/rca_details_modal.php"; 
                    include __DIR__ . "/../../action/global/footer.php";
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
    <!-- Page JS -->
</body>

<script>
$(document).ready(function() {
        $('#pcv_details_form').on('submit', function(e) {
            var formData = new FormData(this);
            e.preventDefault();  

            if ($('#pcv_no').val() == "") {
                $("#pcv_no").css({
                    "border-color": 'red'
                });
            } else {
                $("#pcv_no").css({
                    "border-color": ''
                });
            }
            if ($('#employee').val() == undefined) {
                $("#employee").css({
                    "border-color": 'red'
                });
            } else {
                $("#employee").css({
                    "border-color": ''
                });
            }
            if ($('#sbu').val() == undefined) {
                $("#sbu").css({
                    "border-color": 'red'
                });
            } else {
                $("#sbu").css({
                    "border-color": ''
                });
            }
            if ($('#department').val() == "") {
                $("#department").css({
                    "border-color": 'red'
                });
            } else {
                $("#department").css({
                    "border-color": ''
                });
            }
            if ($('#expenses').val() == "") {
                $("#expenses").css({
                    "border-color": 'red'
                });
            } else {
                $("#expenses").css({
                    "border-color": ''
                });
            }
            if ($('#sdcc').val() == "") {
                $("#sdcc").css({
                    "border-color": 'red'
                });
            } else {
                $("#sdcc").css({
                    "border-color": ''
                });
            }
            if ($('#remarks').val() == "") {
                $("#remarks").css({
                    "border-color": 'red'
                });
            } else {
                $("#remarks").css({
                    "border-color": ''
                });
            }

            $.ajax({
                url: "/edit_pcv",
                method: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    showLoading('#save');
                },
                success: function(response) {
                    hideLoading('#save');
                    console.log(response);
                    if (response.success) {
                        swal({
                            icon: 'success',
                            title: response.title,
                            text: response.message,
                            buttons: false,
                            timer: 2000,
                        }).then(function() {
                            location.reload();
                        });
                    } 
                    else {
                        swal({
                            icon: 'warning',
                            title: response.title,
                            text: response.message,
                            buttons: false,
                        })
                        $(".form-message").html(response.message);
                        $(".form-message").css("display", "block");
                    }
                }
            });
        })
        $('#delete_pvc_btn').on('click', function() {
            var formData = new FormData(document.getElementById('delete_pcv_attachments_form'));

            $.ajax({
                url: "/delete_pcv_attachments",
                method: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    showLoading('#delete_pvc_btn');
                },
                success: function(response) {
                    hideLoading('#delete_pvc_btn');
                    console.log(response);
                    if (response.success) {
                        $('#delete_pcv_modal').modal('hide');
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
        $('#upload_pvc_btn').on('click', function() {
            var formData = new FormData(document.getElementById('add_pcv_attachments_form'));

            $.ajax({
                url: "/upload_pcv_attachments",
                method: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    showLoading('#upload_pvc_btn');
                },
                success: function(response) {
                    hideLoading('#upload_pvc_btn');
                    console.log(response);
                    if (response.success) {
                        $('#upload_pcv_modal').modal('hide');
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

    $('#rca_details_form').on('submit', function(e) {
            var formData = new FormData(this);
            e.preventDefault();  

        $.ajax({
            url: "/edit_rca",
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                    showLoading('#save');
                },
                success: function(response) {
                    hideLoading('#save');
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
    $('#delete_rca_btn').on('click', function() {
        var formData = new FormData(document.getElementById('delete_rca_attachments_form'));

        $.ajax({
            url: "/delete_rca_attachments",
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                showLoading('#delete_rca_btn');
                },
                success: function(response) {
                    hideLoading('#delete_rca_btn');
                console.log(response);
                if (response.success) {
                    $('#delete_rca_modal').modal('hide');
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
    $('#upload_rca_btn').on('click', function() {
        var formData = new FormData(document.getElementById('add_rca_attachments_form'));

        $.ajax({
            url: "/upload_rca_attachments",
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                showLoading('#upload_rca_btn');
                },
                success: function(response) {
                    hideLoading('#upload_rca_btn');
                console.log(response);
                if (response.success) {
                    $('#upload_rca_modal').modal('hide');
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
    let tab1 = localStorage.getItem("tab1") || "#rca-info";

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
