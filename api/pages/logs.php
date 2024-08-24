<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:index.php");
}else if ($decrypted_array['ACCESS'] != 'ADMIN') {
    header("Location:404.php");
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
                                                    <button class="btn btn-label-primary" id="download-xlsx"><i class="fa-solid fa-download"></i> XLSX</button>
                                                    <button class="btn btn-label-primary" id="download-pdf"><i class="fa-solid fa-download"></i> PDF</button>
                                                </div>
                                            </div>  

                                            <!-- BUTTONS WHEN MEDIA SCREEN IS LOWER  -->
                                            <div class="minimize-buttons btn-group mb-2">
                                                <button type="button" class="btn btn-label-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">More Actions</button>
                                                <ul class="dropdown-menu">
                                                    <li><button class="dropdown-item" id="download-xlsx-1"><i class="fa-solid fa-download"></i> XLSX</button></li>
                                                    <li><button class="dropdown-item" id="download-pdf-1"><i class="fa-solid fa-download"></i> PDF</button></li>
                                                </ul>
                                            </div>



                                            <div class="tabulator-table" id="example-table" style="font-size:13px">
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

var table = new Tabulator("#example-table", {
    height: "650px",
    layout: "fitDataStretch",
    movableColumns: true,
    ajaxParams: {
        table: 'logs_data'
    },
    pagination: true,
    paginationMode: "remote",
    paginationSizeSelector: [50, 100, 500, 1000, true],
    paginationSize: 20,
    filterMode: "remote",
    sortMode: "remote",
    ajaxURL: "https://flldc-ims.vercel.app/logs_data.php",
    placeholder: "No Data Found",
    columns: [
        {
            title: "Date created",
            field: "DATE_CREATED",
            sorter: "date",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Full Name",
            width: 300,
            hozAlign: "center",
            field: "FNAME", // You can use any field here since we'll combine the values
            headerFilter: "input",
            headerFilterLiveFilter: false,
            download : false,
            formatter: function(cell, formatterParams, onRendered) {
                // Get the data for the current row
                var rowData = cell.getData();

                // Combine the "First Name" and "Middle Name" fields
                var fullName = rowData.FNAME + (rowData.MNAME ? " " + rowData.MNAME : "") + (rowData
                    .LNAME ? " " + rowData.LNAME : "");

                // Return the combined name
                return fullName;
            },
        },
        {
            title: "First Name",
            field: "FNAME",
            hozAlign: "center",
            headerFilter: "input",
            headerFilterLiveFilter: false,
            visible: false,
            download: true,
        },
        {
            title: "Middle Name",
            field: "MNAME",
            hozAlign: "center",
            headerFilter: "input",
            headerFilterLiveFilter: false,
            visible: false,
            download: true,
        },
        {
            title: "Last Name",
            field: "LNAME",
            hozAlign: "center",
            headerFilter: "input",
            headerFilterLiveFilter: false,
            visible: false,
            download: true,
        },
        {
            title: "Action Made",
            field: "ACTION_MADE",
            hozAlign: "center",
            headerFilter: "input",
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

document.addEventListener("DOMContentLoaded", function () {
    // Your JavaScript code here, including event listener setup
    document.getElementById("download-pdf").addEventListener("click", handlePdfDownload);
    document.getElementById("download-pdf-1").addEventListener("click", handlePdfDownload);
    document.getElementById("download-xlsx").addEventListener("click", handleXslDownload);
    document.getElementById("download-xlsx-1").addEventListener("click", handleXslDownload);
});

//trigger download of data.xlsx file
function handleXslDownload() {
    table.download("xlsx", "Audit Trail as of " + formattedDateWithHyphens + ".xlsx", {
        sheetName: "Audit Trail " + formattedDateWithHyphens + ""
    });
};

//trigger download of data.pdf file
function handlePdfDownload() {
    table.download("pdf", "Audit Trail as of " + formattedDateWithHyphens + ".pdf", {
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
                data.doc.text("Audit Trail as of " + currentDate, 345, 35);
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