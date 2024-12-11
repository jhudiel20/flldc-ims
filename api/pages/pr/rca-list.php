<?php
require_once __DIR__ . '/../../DBConnection.php';
require_once __DIR__ . '/../../config/config.php';

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:/");
}


?>
<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>.assets/" data-template="vertical-menu-template">

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
                                                    <button type="button" class="btn btn-label-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">More
                                                        Actions</button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                                    id="add-dropdown" data-bs-toggle="modal"
                                                                    data-bs-target="#add_pcv_modal "><i
                                                                        class="fa-solid fa-plus "></i> ADD NEW PCV</a></li>
                                                            <li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                                    id="add-dropdown" data-bs-toggle="modal"
                                                                    data-bs-target="#add_rca_modal "><i
                                                                        class="fa-solid fa-plus"></i> ADD NEW RCA</a></li>
                                                            <li>
                                                        </ul>
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
                                                            data-bs-target="#add_pcv_modal "><i
                                                                class="fa-solid fa-plus me-1"></i> ADD NEW PCV</a></li>
                                                    <li>  
                                                    <li><a class="dropdown-item" href="javascript:void(0);"
                                                            id="add-dropdown" data-bs-toggle="modal"
                                                            data-bs-target="#add_rca_modal "><i
                                                                class="fa-solid fa-plus me-1"></i> ADD NEW RCA</a></li>
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
                                            <?php include __DIR__ . "/../../modals/rca_list_modal.php"; ?>
                                            <!-- End of Add Modal -->

                                            <div class="tabulator-table" id="rca-list-table" style="font-size:14px;">
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
</body>


<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const travelcheckbox = document.getElementById('travel');
    const nontravelcheckbox = document.getElementById('non_travel');
    const div_non_travel = document.getElementById('div_non_travel');
    const div_travel = document.getElementById('div_travel');

    const nonTravelFields = document.querySelectorAll('#div_non_travel input');
    const travelFields = document.querySelectorAll('#div_travel input');

    nontravelcheckbox.checked = true;
    div_non_travel.style.display = 'block';
    div_travel.style.display = 'none';

    nonTravelFields.forEach(field => field.setAttribute('required', 'required'));
    travelFields.forEach(field => field.removeAttribute('required'));

    travelcheckbox.addEventListener('change', function() {
        if (this.checked) {
            nontravelcheckbox.checked = false;
            div_travel.style.display = 'block';
            div_non_travel.style.display = 'none';

            travelFields.forEach(field => field.setAttribute('required', 'required'));
            nonTravelFields.forEach(field => field.removeAttribute('required'));
        } else {
            div_travel.style.display = 'none';
            travelFields.forEach(field => field.removeAttribute('required'));
        }
    });

    nontravelcheckbox.addEventListener('change', function() {
        if (this.checked) {
            travelcheckbox.checked = false;
            div_non_travel.style.display = 'block';
            div_travel.style.display = 'none';

            nonTravelFields.forEach(field => field.setAttribute('required', 'required'));
            travelFields.forEach(field => field.removeAttribute('required'));
        } else {
            div_non_travel.style.display = 'none';
            nonTravelFields.forEach(field => field.removeAttribute('required'));
        }
    });
});


var detail_btn = function(cell, formatterParams, onRendered) {
    var id = cell.getData().xid;

    <?php 
        // $geturl = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
        // $_SESSION['PAGE_CLICK'] = "";
        // $_SESSION['PAGE_CLICK'] = $geturl;
    ?>
    return "<a class='btn btn-outline-primary' href='rca-details?ID=" + id +
        "' ><i class='fa-solid fa-eye'></i> </a>";
};


// Initialize the Tabulator table with fetched data
//function initializeTable(data) {
var table = new Tabulator("#rca-list-table", {
    layout: "fitDataStretch",
    movableColumns: true,
    placeholder: "No Data Found",
    pagination: true, //enable pagination
    paginationMode: "remote", //enable remote pagination
    paginationSizeSelector: [40, 50, 100, 500, 1000, true],
    paginationSize: 40,
    filterMode: "remote",
    sortMode: "remote",
    ajaxURL: "/rca_list_data",
    ajaxLoaderLoading: 'Fetching data from Database..',
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
            title: "ID",
            field: "rca_id",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Name",
            field: "name",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Amount",
            field: "amount",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false,
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
            headerFilterLiveFilter: false
        },
        {
            title: "Date Created",
            field: "date_created",
            headerFilter: "date",
            hozAlign: "center",
            headerFilterLiveFilter: false,
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
    table.download("xlsx", "RCA/PCV List as of Year " + currentYear + ".xlsx", {
        sheetName: "RCA-PCV List"
    });
};
//trigger download of PDF file
function handlePdfDownload() {
    table.download("pdf", "RCA/PCV List as of " + formattedDateWithHyphens + ".pdf", {
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
                data.doc.text("RCA/PCV List as of " + currentDate, 335, 35);
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