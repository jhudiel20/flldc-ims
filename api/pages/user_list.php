<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:/");
}else if ($decrypted_array['ACCESS'] != 'ADMIN') {
    header("Location:/404");
}
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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-12">
                                        <div class="card-body">

                                            <div class="py-1 mb-2 ">
                                                <div class="additional-buttons">
                                                    <?php if ($decrypted_array['ADMIN_STATUS'] == "PRIMARY") { ?>
                                                    <button type="button" id="add" class="btn btn-label-primary"
                                                        data-bs-toggle="modal" data-bs-target="#add_user_modal">
                                                        <i class="fa-solid fa-plus"></i><span> ADD USER
                                                    </button>
                                                    <?php } ?>
                                                    <button class="btn btn-label-primary" id="download-xlsx"><i
                                                            class="fa-solid fa-download"></i> XLSX</button>
                                                    <button class="btn btn-label-primary" id="download-pdf"><i
                                                            class="fa-solid fa-download"></i> PDF</button>
                                                </div>
                                            </div>

                                            <!-- BUTTONS WHEN MEDIA SCREEN IS LOWER  -->
                                            <div class="minimize-buttons btn-group mb-2">
                                                <button type="button" class="btn btn-label-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">More
                                                    Actions</button>
                                                <ul class="dropdown-menu">
                                                    <?php if ($decrypted_array['ADMIN_STATUS'] == "PRIMARY") { ?>
                                                    <li><a class="dropdown-item" href="javascript:void(0);"
                                                            id="add-dropdown" data-bs-toggle="modal"
                                                            data-bs-target="#add_user_modal"><i
                                                                class="fa-solid fa-plus"></i> ADD USER</a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <?php } ?>
                                                    <li><button class="dropdown-item" id="download-xlsx-1"><i
                                                                class="fa-solid fa-download"></i> XLSX</button></li>
                                                    <li><button class="dropdown-item" id="download-pdf-1"><i
                                                                class="fa-solid fa-download"></i> PDF</button></li>
                                                </ul>
                                            </div>

                                            <!-- Add Modal -->
                                            <?php include __DIR__ . "/../modals/user_list_modal.php"; ?>
                                            <!-- End of Add Modal -->
                                            <div class="tabulator-table" id="user-table" style="font-size:13px">
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- / Content -->

                <!-- Footer -->
                <?php 
                    include __DIR__ . "/../modals/edit_delete_userlist_modal.php";
                    include __DIR__. "/../action/global/footer.php";
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
</body>

<script>


var status_show = function(cell, formatterParams, onRendered) {
    var data = cell.getData().status; // Get the employee ID from the cell

    if (data == 0) {
        return "<span class='badge rounded-pill bg-secondary'>Offline</span>"; // Gray style for Offline
    } else {
        return "<span class='badge rounded-pill bg-success'>Online</span>"; // Green style for Online
    }
};

var approval_status = function(cell, formatterParams, onRendered) {
    var data_approved = cell.getData().approved_status; // Get the approved status from the cell
    var ID = cell.getRow().getData().id; // Get the ID of the user

    if (data_approved == 2) {
        return "<span class='badge rounded-pill bg-primary'>Approved</span>"; // Gray style for Offline
    } else if (data_approved == 0) {
        // Show the buttons for APPROVED_STATUS = 0
        return (
            "<span class='badge rounded-pill bg-secondary'>Pending</span><br>" +
            "<button type='button' class='badge rounded-pill bg-success' data-bs-toggle='modal' data-bs-target='#approval_modal' data-id='" +
            ID + "' data-approved='" + data_approved + "'><i class='bx bx-check'></i></button>" +
            "<button class='badge rounded-pill bg-danger' data-id='" + ID + "' data-approved='" +
            data_approved + "'><i class='bx bx-x'></i></button>"
        );
    } else {
        return (
            "<span class='badge rounded-pill bg-secondary'>Pending</span><br>"
        ); // Green style for Online
    }
};

var btn_clear_attempts = function(cell, formatterParams, onRendered) {
    var data = cell.getData().locked;
    var id = cell.getData().id; // Get the ID of

    if (data == 0) {
        return data;
    }
    if (data >= 1) {
        return "<button type='button' class='btn btn-outline-primary clear_attempts' data-id='" + id +
            "' >Clear Attempts : " + data + "</button>";
    }
}

var reserve_access = function(cell, formatterParams, onRendered) {
    var access = cell.getData().reservation_access;
    var id = cell.getData().id; // Get the ID of
    var fname = cell.getData().fname;
    var lname = cell.getData().lname;

    return "<button type='button' class='btn btn-outline-primary change_room_access' data-fullname='" + fname + " " + lname + "'  data-id='" + id + "' data-access='" + access +"' > " + access + "</button>";

}

// data-bs-toggle='modal' data-bs-target='#clear_attempts_modal' data-id='"+id+"'
var table = new Tabulator("#user-table", {

    // height: "650px",
    layout: "fitDataStretch",
    movableColumns: true,
    placeholder: "No Data Found",
    pagination: true, //enable pagination
    paginationMode: "remote", //enable remote pagination
    paginationSizeSelector: [50, 100, 500, 1000, true],
    paginationSize: 20,
    filterMode: "remote",
    sortMode: "remote",
    ajaxURL: "/user_list_data",
    ajaxLoaderLoading: 'Fetching data from Database..',

    columns: [{
            title: "First Name",
            field: "fname",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false,
            visible: false,
            download: true
        },
        {
            title: "Middle Name",
            field: "mname",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false,
            visible: false,
            download: true
        },
        {
            title: "Last Name",
            field: "lname",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false,
            visible: false,
            download: true
        },
        {
            title: "Suffix",
            field: "ext_name",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false,
            visible: false,
            download: true
        },
        {
            title: "Status",
            formatter: status_show,
            field: "status",
            hozAlign: "center",
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            headerFilterLiveFilter: false,
            download: false
        },
        {
            title: "Full Name",
            hozAlign: "center",
            field: "fname", // You can use any field here since we'll combine the values
            headerFilter: "input",
            headerFilterLiveFilter: false,
            download: false,
            formatter: function(cell, formatterParams, onRendered) {
                // Get the data for the current row
                var rowData = cell.getData();

                // Combine the "First Name" and "Middle Name" fields
                var fullName = rowData.fname + (rowData.mname ? " " + rowData.mname : "") + (rowData
                    .fname ? " " + rowData.lname : "") + (rowData.ext_name ? " " + rowData
                    .ext_name : "");

                // Return the combined name
                return fullName;
            },
        },
        {
            title: "Email",
            field: "email",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Contact No.",
            field: "contact",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Access",
            field: "access",
            hozAlign: "center",
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            headerFilterLiveFilter: false
        },
        {
            title: "Reservation Access",
            formatter: reserve_access,
            hozAlign: "center",
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            headerFilterLiveFilter: false
        },
        {
            title: "",
            field: "image",
            formatter: function(cell, formatterParams) {
                var imageValue = cell.getValue();
                var imageUrl = "";

                if (imageValue) {
                    imageUrl = "https://raw.githubusercontent.com/jhudiel20/flldc-user-image/main/images/" + imageValue;
                } else {
                    // Use default picture URL
                    imageUrl = "https://raw.githubusercontent.com/jhudiel20/flldc-user-image/main/images/user.png";
                }

                var imageElement = document.createElement("img");
                imageElement.src = imageUrl;
                imageElement.style.height = formatterParams.height;
                imageElement.style.width = formatterParams.width;
                imageElement.style.borderRadius = "50%";

                return imageElement;
            },
            formatterParams: {
                height: "50px",
                width: "50px"
            },
            download: false,
        },
        {
            title: "Login Attempts",
            formatter: btn_clear_attempts,
            field: "locked",
            headerFilter: false,
            hozAlign: "center",
            headerFilterLiveFilter: false,
            download: false
        },
        {
            title: "Approval Status",
            field: "approved_status",
            hozAlign: "center",
            download: true,
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            formatter: function(cell, formatterParams, onRendered) {
                var data_approved = cell.getData().approved_status; // Get the approved status from the cell
                var UserID = cell.getRow().getData().id; // Get the ID of the user
                var FirstName = cell.getRow().getData().fname;
                var LastName = cell.getRow().getData().lname;
                if (data_approved == 2) {
                    return "<span class='badge rounded-pill bg-primary'>Approved</span>"; // Gray style for Offline
                } else if (data_approved == 0) {
                    // Show the buttons for APPROVED_STATUS = 0
                    var approveBtn = $("<button class=' rounded-pill bg-success'>").addClass(
                            "user-approval")
                        .attr("data-id", UserID)
                        .attr("data-fname", FirstName)
                        .attr("data-lname", LastName)
                        // .attr("data-approved", data_approved)
                        .html("<i class='bx bx-check'></i>");

                    var disapproveBtn = $("<button class=' rounded-pill bg-danger'>").addClass(
                            "user-disapproval")
                        .attr("data-id", UserID)
                        .attr("data-fname", FirstName)
                        .attr("data-lname", LastName)
                        // .attr("data-approved", data_approved)
                        .html("<i class='bx bxs-user-x'></i>");

                    var btnContainer = $("<div>")
                        .addClass("btn-container")
                        .append(approveBtn, disapproveBtn);

                    return (
                        "<span class='badge rounded-pill bg-secondary'>Pending</span><br>" +
                        btnContainer.prop("outerHTML")
                    );
                } else {
                    return (
                        "<span class='badge rounded-pill bg-danger'>Disapproved</span><br>"
                    ); // Green style for Online
                }
            }
        },
        <?php if($decrypted_array['ADMIN_STATUS'] == 'PRIMARY'){?> {
            title: "Action",
            formatter: function(cell, formatterParams, onRendered) {
                var ID = cell.getRow().getData().id;
                var FNAME = cell.getRow().getData().fname;
                var MNAME = cell.getRow().getData().mname;
                var LNAME = cell.getRow().getData().lname;
                var CONTACT = cell.getRow().getData().contact;
                var LOCKED = cell.getRow().getData().locked;
                var EXT_NAME = cell.getRow().getData().ext_name;
                var EMAIL = cell.getRow().getData().email;
                var ACCESS = cell.getRow().getData().access;
                var APPROVED_STATUS = cell.getRow().getData().approved_status;
                var admin_status = cell.getRow().getData().admin_status;
                // console.log(admin_status);

                var editBtn = $("<button class='btn btn-outline-primary me-2' >").addClass("user-edit")
                    .attr("data-id", ID)
                    .attr("data-fname", FNAME)
                    .attr("data-mname", MNAME)
                    .attr("data-lname", LNAME)
                    .attr("data-locked", LOCKED)
                    .attr("data-ext_name", EXT_NAME)
                    .attr("data-email", EMAIL)
                    .attr("data-contact", CONTACT)
                    .attr("data-access", ACCESS)
                    .attr("data-approved", APPROVED_STATUS)
                    .html("<i class='fa-solid fa-pen-to-square'></i>");

                if (admin_status != "PRIMARY") {
                    var deleteBtn = $("<button>").addClass("btn btn-outline-danger user-delete")
                        .attr("data-id", ID)
                        .attr("data-fname", FNAME)
                        .attr("data-lname", LNAME)
                        .html("<i class='bx bxs-user-x'></i>");

                    var btnContainer = $("<div>").addClass("btn-container")
                        .append(editBtn, deleteBtn);

                    return btnContainer.prop("outerHTML");
                }
            },
            hozAlign: "center",
            width: 150,
            download: false
        },
        <?php } ?>
    ],
    ajaxResponse: function(url, params, response) {
            return {
                last_page: response.last_page,
                total: response.total_record,
                data: response.data // This should be an array
            };
    },

});

document.addEventListener("DOMContentLoaded", function() {
    // Your JavaScript code here, including event listener setup
    document.getElementById("download-pdf").addEventListener("click", handlePdfDownload);
    document.getElementById("download-pdf-1").addEventListener("click", handlePdfDownload);
    document.getElementById("download-xlsx").addEventListener("click", handleXslDownload);
    document.getElementById("download-xlsx-1").addEventListener("click", handleXslDownload);
});

//trigger download of data.xlsx file
function handleXslDownload() {
    table.download("xlsx", "System Users Accounts as of Year " + currentYear + ".xlsx", {
        sheetName: "User List " + currentYear + ""
    });
};

//trigger download of data.pdf file
function handlePdfDownload() {
    table.download("pdf", "System User List as of " + formattedDateWithHyphens + ".pdf", {
        orientation: "landscape", //set page orientation to portrait
        autoTable: {
            theme: 'grid', //'plain' or 'striped'
            startY: 50,
            styles: {
                fontSize: 7
            },
            addPageContent: function(data) {
                data.doc.addImage('../assets/img/LOGO.png', 'PNG', 35, 7, 45, 30); // Change the image URL or data URI and dimensions
                data.doc.setFont("times");
                data.doc.setFontSize(11); // Set the font size for the second line
                data.doc.text("Learning and Development", 360, 20);
                data.doc.setFontSize(14);
                data.doc.text("System User List as of " + currentDate, 335, 35);
                data.doc.setDrawColor(0, 0, 0);
                // Set the width of the divider to 1 point (adjust as needed)
                data.doc.setLineWidth(3);
                // Draw a horizontal rule (divider)
                data.doc.line(20, 43, 820, 43); // Adjust the coordinates as needed
                // FOOTER PAGE NUMBERS
                var str = "Page " + data.doc.internal.getNumberOfPages();
                data.doc.setFontSize(10);
                // Set startY to 70 for all pages
                data.settings.startY = 50;
                // Reset page margins
                data.settings.margin.top = 50;
                // jsPDF 1.4+ uses getWidth, <1.4 uses .width
                var pageSize = data.doc.internal.pageSize;
                var pageHeight = pageSize.height ?
                    pageSize.height :
                    pageSize.getHeight();
                data.doc.text(str, data.settings.margin.left, pageHeight - 10);
            },
        },
    });
};

</script>

</html>