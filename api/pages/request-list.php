<?php
require '../DBConnection.php';
include '../config/config.php';

if (!isset($_SESSION['ACCESS'])) {
    header("Location:index.php");
}

?>
<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>../assets/" data-template="vertical-menu-template">

<head>
    <?php
    include DOMAIN_PATH . "/action/global/metadata.php";
    include DOMAIN_PATH . "/action/global/include_top.php";
    ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <?php
        include DOMAIN_PATH . "/action/global/sidebar.php";
        include DOMAIN_PATH . "/action/global/header.php"; 
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
                                                        <i class="fa-solid fa-plus"></i><span> ADD NEW REQUEST
                                                    </button>
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
                                            <?php include DOMAIN_PATH . "/modals/request_list_modal.php"; ?>
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
                    include FOOTER_PATH;
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
        include DOMAIN_PATH . "/action/global/include_bottom.php";
      ?>
</body>


<script>
var approval_status = function(cell, formatterParams, onRendered) {
    var data_approval = cell.getData().APPROVAL; // Get the approved status from the cell
    var ID = cell.getRow().getData().ID; // Get the ID of the user
    var item_name = cell.getRow().getData().ITEM_NAME; // Get the ID of the user
    var EMAIL = cell.getRow().getData().EMAIL;
    var REQUEST_ID = cell.getRow().getData().REQUEST_ID;
    // console.log(ID);

    <?php if($_SESSION['ACCESS'] == 'ADMIN'){?>
    if (data_approval == "PENDING") {
        return "<button type='button' class='btn btn-outline-primary approval-status' data-request_id='" +
            REQUEST_ID + "' data-id='" + ID + "' data-approved='" + data_approval + "' data-item=' " + item_name +
            " ' data-email=' " + EMAIL + " ' >PENDING</button>";
    } else {
        return data_approval;
    }
    <?php }else{ ?>
    return data_approval;
    <?php } ?>
};

var detail_btn = function(cell, formatterParams, onRendered) {
    var request_id = cell.getData().xid;

    return "<a class='btn btn-outline-primary' href='request-details.php?ID=" + request_id +
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
    ajaxURL: "<?php echo BASE_URL; ?>ajax_data/request_list_data.php",
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
            field: "REQUEST_DATE_CREATED",
            headerFilter: "date",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Request ID",
            field: "REQUEST_ID",
            headerFilter: "input",
            hozAlign: "center",
            // width: 300,
            headerFilterLiveFilter: false
        },
        {
            title: "Purchase Item",
            field: "ITEM_NAME",
            headerFilter: "input",
            hozAlign: "center",
            // width: 300,
            headerFilterLiveFilter: false
        },
        {
            title: "Request Status",
            field: "APPROVAL",
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
            field: "EMAIL",
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
        return response; //response.data; //return the tableData property of a response json object
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
                data.doc.addImage('../assets/img/LOGO.PNG', 'PNG', 35, 7, 45, 30); // Change the image URL or data URI and dimensions
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

        $('#add_request').on('click', function() {
            var formdata = new FormData(add_request_form);

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
                url: "../action/add_request.php",
                method: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#add_request').hide();
                    $('#request_icon').removeClass('d-none').prop('disabled', true);
                },

                success: function(response) {
                    $('#request_icon').addClass('d-none').prop('disabled', false);
                    $('#add_request').show();
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


    $('.dropify').dropify();

    $('#submit_approval').on('click', function() {
        var formdata = new FormData(request_approval_form);

        $.ajax({
            url: "../action/update_request_status.php",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#submit_approval').hide();
                $('#submit_icon').removeClass('d-none').prop('disabled', true);
            },

            success: function(response) {
                $('#submit_icon').addClass('d-none').prop('disabled', false);
                $('#submit_approval').show();
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