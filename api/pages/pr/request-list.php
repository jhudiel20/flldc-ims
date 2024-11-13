<?php
require_once __DIR__ . '/../../DBConnection.php';
require_once __DIR__ . '/../../config/config.php';

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:index.php");
}

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
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-12">
                                        <div class="card-body">
                                            <div class="py-1 mb-2 ">
                                                <div class="additional-buttons">
                                                    <button type="button" id="add" class="btn btn-label-primary"
                                                        data-bs-toggle="modal" data-bs-target="#add_request_modal">
                                                        <i class="fa-solid fa-plus me-1"></i><span> ADD NEW REQUEST
                                                    </button>
                                                    <button class="btn btn-label-primary" id="download-xlsx"><i
                                                            class="fa-solid fa-download me-1"></i> XLSX</button>
                                                    <button class="btn btn-label-primary" id="download-pdf"><i
                                                            class="fa-solid fa-download me-1"></i> PDF</button>
                                                </div>
                                            </div>

                                            <!-- BUTTONS WHEN MEDIA SCREEN IS LOWER  -->
                                            <div class="minimize-buttons btn-group mb-2">
                                                <button type="button" class="btn btn-label-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">More
                                                    Actions</button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0);"
                                                            id="add-dropdown" data-bs-toggle="modal"
                                                            data-bs-target="#add_request_modal "><i
                                                                class="fa-solid fa-plus"></i> ADD NEW REQUEST</a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><button class="dropdown-item" id="download-xlsx-1"><i
                                                                class="fa-solid fa-download"></i> XLSX</button></li>
                                                    <li><button class="dropdown-item" id="download-pdf-1"><i
                                                                class="fa-solid fa-download"></i> PDF</button></li>
                                                </ul>
                                            </div>

                                            <!-- Add Modal -->
                                            <?php include __DIR__ . "/../../modals/request_list_modal.php"; ?>
                                            <!-- End of Add Modal -->

                                            <div class="tabulator-table" id="request-list-table"
                                                style="font-size:14px;">
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
                    include __DIR__. "/../../action/global/footer.php";
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
</body>


<script>
var approval_status = function(cell, formatterParams, onRendered) {
    var data_approval = cell.getData().approval; // Get the approved status from the cell
    var ID = cell.getRow().getData().id; // Get the ID of the user
    var item_name = cell.getRow().getData().item_name; // Get the ID of the user
    var EMAIL = cell.getRow().getData().email;
    var REQUEST_ID = cell.getRow().getData().request_id;
    // console.log(ID);

    <?php if($decrypted_array['ACCESS'] == 'ADMIN'){?>
        if (data_approval == "PENDING") {
            return "<button type='button' class='btn btn-outline-primary approval-status' data-request_id='" +
                REQUEST_ID + "' data-id='" + ID + "' data-approved='" + data_approval + "' data-item=' " + item_name +
                " ' data-email=' " + EMAIL + " ' >PENDING</button>";
        }
        if (data_approval == "DECLINED"){
            return "<button type='button' class='btn btn-outline-primary approval-status' data-request_id='" +
                REQUEST_ID + "' data-id='" + ID + "' data-approved='" + data_approval + "' data-item=' " + item_name +
                " ' data-email=' " + EMAIL + " ' >DECLINED</button>";
        }
        if(data_approval == "APPROVED"){
            return "<button type='button' class='btn btn-outline-primary approval-status' data-request_id='" +
                REQUEST_ID + "' data-id='" + ID + "' data-approved='" + data_approval + "' data-item=' " + item_name +
                " ' data-email=' " + EMAIL + " ' >APPROVED</button>";
        }
    <?php }else{ ?>
    return data_approval;
    <?php } ?>
};

var detail_btn = function(cell, formatterParams, onRendered) {
    var request_id = cell.getData().xid;

    return "<a class='btn btn-outline-primary' href='request-details?ID=" + request_id +
        "' ><i class='fa-solid fa-eye'></i> </a>";
};

// Initialize the Tabulator table with fetched data
//function initializeTable(data) {
var table = new Tabulator("#request-list-table", {
    layout: "fitDataStretch",
    movableColumns: true,
    placeholder: "No Data Found",
    pagination: true, //enable pagination
    paginationMode: "remote", //enable remote pagination
    paginationSizeSelector: [40, 50, 100, 500, 1000, true],
    paginationSize: 40,
    filterMode: "remote",
    sortMode: "remote",
    ajaxURL: "/request_list_data",
    columns: [
        {
            title: "Details",
            field: "",
            formatter: detail_btn,
            hozAlign: "center",
            headerFilter: "input",
            headerFilterLiveFilter: false,
            download: false
        },
        {
            title: "Date Created",
            field: "request_date_created",
            headerFilter: "date",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Request ID",
            field: "request_id",
            headerFilter: "input",
            hozAlign: "center",
            // width: 300,
            headerFilterLiveFilter: false
        },
        {
            title: "Purchase Item",
            field: "item_name",
            headerFilter: "input",
            hozAlign: "center",
            // width: 300,
            headerFilterLiveFilter: false
        },
        {
            title: "Request Status",
            field: "approval",
            formatter: approval_status,
            hozAlign: "center",
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            // width: 300,
            headerFilterLiveFilter: false
        },
        {
            title: "Requestor Email ",
            field: "email",
            hozAlign: "center",
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            // width: 300,
            headerFilterLiveFilter: false
        },

    ],
    ajaxResponse: function(url, params, response) {
        return {
                last_page: response.last_page,
                total: response.total_record,
                data: response.data // This should be an array
            }; //response.data; //return the tableData property of a response json object
    },
});

//trigger download of data.pdf file
document.addEventListener("DOMContentLoaded", function() {
    // Your JavaScript code here, including event listener setup
    document.getElementById("download-pdf").addEventListener("click", handlePdfDownload);
    document.getElementById("download-pdf-1").addEventListener("click", handlePdfDownload);
    document.getElementById("download-xlsx").addEventListener("click", handleXslDownload);
    document.getElementById("download-xlsx-1").addEventListener("click", handleXslDownload);
});

//trigger download of data.xlsx file
function handleXslDownload() {
    table.download("xlsx", "Request List as of Year " + currentYear + ".xlsx", {
        sheetName: "Request List"
    });
};
//trigger download of PDF file
function handlePdfDownload() {
    table.download("pdf", "Request List as of " + formattedDateWithHyphens + ".pdf", {
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
                data.doc.text("Request List as of " + currentDate, 340, 35);
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




$(document).ready(function() {

        $('#add_request_form').on('submit', function(e) {
            var formData = new FormData(this);
            e.preventDefault();  

            if ($('#item_name').val() == "") {
                $("#item_name").css({
                    "border-color": 'red'
                });
            } else {
                $("#item_name").css({
                    "border-color": ''
                });
            }
            if ($('#quantity').val() == "") {
                $("#quantity").css({
                    "border-color": 'red'
                });
            } else {
                $("#quantity").css({
                    "border-color": ''
                });
            }
            if ($('#purpose').val() == "") {
                $("#purpose").css({
                    "border-color": 'red'
                });
            } else {
                $("#purpose").css({
                    "border-color": ''
                });
            }
            if ($('#date_needed').val() == "") {
                $("#date_needed").css({
                    "border-color": 'red'
                });
            } else {
                $("#date_needed").css({
                    "border-color": ''
                });
            }
            if ($('#item_photo').val() == "") {
                $("#item_photo").css({
                    "border-color": 'red'
                });
            } else {
                $("#item_photo").css({
                    "border-color": ''
                });
            }

            $.ajax({
                url: "/add_request",
                method: "POST",
                data: formData,
                dataType: "json",
                contentType: false,   // Important: prevents jQuery from setting the content type header
                cache: false,
                processData: false,   // Important: prevents jQuery from processing the FormD
                beforeSend: function() {
                    $('#add_request').removeClass('d-none').prop('disabled', true);
                },

                success: function(response) {
                    $('#add_request').addClass('d-none').prop('disabled', false);
                    console.log(response);
                    if (response.success) {
                        $('#add_request_modal').modal('hide');
                        $('#add_request_form')[0].reset();
                        swal({
                            icon: 'success',
                            title: response.title,
                            text: response.message,
                            buttons: false,
                            timer: 2000,
                        }).then(function() {
                            location.reload();
                        });
                    } else {
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

    $('#submit_approval_btn').on('click', function(e) {
            var formdata = new FormData(document.getElementById('request_approval_form'));
            e.preventDefault();  
        $.ajax({
            url: "/update_request_status",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#submit_approval_btn').removeClass('d-none').prop('disabled', true);
            },

            success: function(response) {
                $('#submit_approval_btn').addClass('d-none').prop('disabled', false);
                console.log(response);
                if (response.success) {
                    $('#approval_modal').modal('hide');
                    $('#request_approval_form')[0].reset();
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: 2000,
                    }).then(function() {
                        location.reload();
                    });
                } else {
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
    });

    $(document).on("click", ".approval-status", function() {
        var ID = $(this).data("id");
        var APPROVAL = $(this).data("approved");
        var ITEM_NAME = $(this).data("item");
        var EMAIL = $(this).data("email");
        var REQUEST_ID = $(this).data("request_id");

        $('#ID').val(ID);
        $('#APPROVAL').val(APPROVAL);
        $('#ITEM_NAME').val(ITEM_NAME);
        $('#EMAIL').val(EMAIL);
        $('#REQUEST_ID').val(REQUEST_ID);

        // Show the edit modal
        $('#approval_modal').modal('show');
    });
});
</script>

</html>