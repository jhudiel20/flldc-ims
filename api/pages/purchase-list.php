<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:index.php");
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
                            <div class="card ">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-12">
                                        <div class="card-body">
                                            <div class="py-1 mb-2 ">
                                                <div class="additional-buttons">
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
                                                    <li><button class="dropdown-item" id="download-xlsx-1"><i
                                                                class="fa-solid fa-download"></i> XLSX</button></li>
                                                    <li><button class="dropdown-item" id="download-pdf-1"><i
                                                                class="fa-solid fa-download"></i> PDF</button></li>
                                                </ul>
                                            </div>

                                            <!-- Add Modal -->
                                            <?php include __DIR__ . "/../modals/purchase_list_modal.php"; ?>
                                            <!-- End of Add Modal -->

                                            <div class="tabulator-table" id="purchase-list-table"
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
                    include __DIR__ . "/../action/global/footer.php";;
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
var detail_btn = function(cell, formatterParams, onRendered) {
    var purchase_id = cell.getData().xid;

    <?php 
        // $geturl = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
        // $_SESSION['PAGE_CLICK'] = "";
        // $_SESSION['PAGE_CLICK'] = $geturl;
    ?>
    return "<a class='btn btn-outline-primary' href='purchase-details?ID=" + purchase_id +
        "' ><i class='fa-solid fa-eye'></i> </a>";
};


// Initialize the Tabulator table with fetched data
//function initializeTable(data) {
var table = new Tabulator("#purchase-list-table", {
    layout: "fitDataStretch",
    movableColumns: true,
    placeholder: "No Data Found",
    pagination: true, //enable pagination
    paginationMode: "remote", //enable remote pagination
    paginationSizeSelector: [40, 50, 100, 500, 1000, true],
    paginationSize: 40,
    filterMode: "remote",
    sortMode: "remote",
    ajaxURL: "/purchase_list_data",
    columns: [{
            title: "Details",
            field: "",
            formatter: detail_btn,
            hozAlign: "center",
            headerFilter: "input",
            headerFilterLiveFilter: false,
            download: false
        },
        {
            title: "Item ID",
            field: "pr_id",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Purchase Item",
            field: "item_name",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Quantity",
            field: "quantity",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false,
            visible: false,
            download: true
        },
        {
            title: "Status",
            field: "status",
            hozAlign: "center",
            sorter: "date",
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            width: 150,
            headerFilterLiveFilter: false
        },
        {
            title: "Approval Date Created",
            field: "approval_date_created",
            headerFilter: "date",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Remarks",
            field: "remarks",
            headerFilter: "input",
            hozAlign: "center",
            width: 300,
            headerFilterLiveFilter: false,
            visible: false,
            download: true
        },
        {
            title: "Requestor Email ",
            field: "email",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false,
            visible: false,
            download: true
        }

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
    table.download("xlsx", "Purchase List as of Year " + currentYear + ".xlsx", {
        sheetName: "Purchase List"
    });
};
//trigger download of PDF file
function handlePdfDownload() {
    table.download("pdf", "Purchase List as of " + formattedDateWithHyphens + ".pdf", {
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
                data.doc.text("Purchase List as of " + currentDate, 340, 35);
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
        $('#add_pr').on('click', function() {
            var formdata = new FormData(add_pr_form);

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
            if ($('#status').val() == "") {
                $("#status").css({
                    "border-color": 'red'
                });
            } else {
                $("#status").css({
                    "border-color": ''
                });
            }
            $.ajax({
                url: <?php BASE_URL; ?> "action/add_pr_detail.php",
                method: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,

                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        $('#add_pr_modal').modal('hide');
                        $('#add_pr_form')[0].reset();
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
});
</script>

</html>