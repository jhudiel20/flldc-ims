<?php
require_once __DIR__ . '/../../DBConnection.php';
require_once __DIR__ . '/../../config/config.php';

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:/");
}


$id = decrypted_string($_GET['ID']);


if(empty($id)){
    header("Location: /404");
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
                        <h4><span class="text-muted fw-light"><a href="room-list">Room List</a> /</span> Room Details</h4>
                        <div class="col-12 col-lg-4 order-3 order-md-3 order-lg-3 mb-2">
                            <div class="card">
                                <div class="row row-bordered g-0">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="text-center">
                                            <img src="/fetch?file=<?php echo urlencode($row['room_photo']); ?>&db=room-photo" style="height:220px;" />
                                                <?php if ($decrypted_array['RESERVATION_ACCESS'] == 'ADMIN') { ?>
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
                                                            <button type="button" id="upload_room_photo_btn" value="Upload" class="btn btn-label-primary btn-page-block"><i
                                                                    class="fa-solid fa-upload"></i></button>
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
                                                        <div class="col-md-4">
                                                            <label class="form-label">Room Name<span class="require asterisk">*</span></label>
                                                            <input type="text" class="form-control" name="roomname" id="roomname" value="<?php echo $row['room_name']?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Room Type<span class="require asterisk">*</span></label>
                                                            <select name="roomtype" id="roomtype" class="form-control">
                                                                <option value="Meeting-Room" <?php if($row['room_type'] == "Meeting-Room") echo 'selected'; ?>>Meeting Room</option>
                                                                <option value="Training-Room" <?php if($row['room_type'] == "Training-Room") echo 'selected'; ?>>Training Room</option>
                                                                <option value="Both" <?php if($row['room_type'] == "Both") echo 'selected'; ?>>Both</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Price<span class="require asterisk">*</span></label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">₱</span>
                                                                <input type="text" class="form-control" name="price" id="price" value="<?php echo number_format($row['prices'],2); ?>"
                                                                    onKeyPress="if(this.value.length==12) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)"
                                                                    oninput="if(this.value!=''){this.value = parseFloat(this.value.replace(/,/g, '')).toLocaleString('en-US', {style: 'decimal', maximumFractionDigits: 0, minimumFractionDigits: 0})}">
                                                                <span class="input-group-text">.00</span>
                                                            </div>
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

                                                        <?php if($decrypted_array['ACCESS'] == 'ADMIN'){?>
                                                        <button type="button" class="btn btn-label-primary btn-page-block"
                                                            id="edit_room_details_btn"
                                                            name="edit_room_details_btn">Save</button>
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
        include __DIR__ . "/../../modals/room_details_modal.php"; 
        include __DIR__ . "/../../action/global/include_bottom.php";
      ?>
    <!-- Page JS -->
</body>

</html>
