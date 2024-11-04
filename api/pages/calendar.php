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
                    <div class="card app-calendar-wrapper">
                        <div class="row g-0">
                            <!-- Calendar Sidebar -->
                            <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
                                <div class="border-bottom p-4 my-sm-0 mb-3">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-toggle-sidebar" data-bs-toggle="offcanvas"
                                            data-bs-target="#addEventSidebar" aria-controls="addEventSidebar">
                                            <i class="bx bx-plus me-1"></i>
                                            <span class="align-middle">Add Event</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <!-- inline calendar (flatpicker) -->
                                    <div class="ms-n2">
                                        <div class="inline-calendar"></div>
                                    </div>

                                    <hr class="container-m-nx my-4" />

                                    <!-- Filter -->
                                    <div class="mb-4">
                                        <small class="text-small text-muted text-uppercase align-middle">Filter</small>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input select-all" type="checkbox" id="selectAll"
                                            data-value="all" checked />
                                        <label class="form-check-label" for="selectAll">View All</label>
                                    </div>

                                    <div class="app-calendar-events-filter">
                                        <div class="form-check form-check-danger mb-2">
                                            <input class="form-check-input input-filter" type="checkbox"
                                                id="select-personal" data-value="personal" checked />
                                            <label class="form-check-label" for="select-personal">Personal</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input input-filter" type="checkbox"
                                                id="select-business" data-value="business" checked />
                                            <label class="form-check-label" for="select-business">Business</label>
                                        </div>
                                        <div class="form-check form-check-warning mb-2">
                                            <input class="form-check-input input-filter" type="checkbox"
                                                id="select-family" data-value="family" checked />
                                            <label class="form-check-label" for="select-family">Family</label>
                                        </div>
                                        <div class="form-check form-check-success mb-2">
                                            <input class="form-check-input input-filter" type="checkbox"
                                                id="select-holiday" data-value="holiday" checked />
                                            <label class="form-check-label" for="select-holiday">Holiday</label>
                                        </div>
                                        <div class="form-check form-check-info">
                                            <input class="form-check-input input-filter" type="checkbox" id="select-etc"
                                                data-value="etc" checked />
                                            <label class="form-check-label" for="select-etc">ETC</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Calendar Sidebar -->

                            <!-- Calendar & Modal -->
                            <div class="col app-calendar-content">
                                <div class="card shadow-none border-0">
                                    <div class="card-body pb-0">
                                        <!-- FullCalendar -->
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                                <div class="app-overlay"></div>
                                <!-- FullCalendar Offcanvas -->
                                <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
                                    aria-labelledby="addEventSidebarLabel">
                                    <div class="offcanvas-header border-bottom">
                                        <h5 class="offcanvas-title mb-2" id="addEventSidebarLabel">Add Event</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <form class="event-form pt-0" id="eventForm">
                                            <div class="mb-3">
                                                <label class="form-label" for="eventTitle">Title</label>
                                                <input type="text" class="form-control" id="eventTitle"
                                                    name="eventTitle" placeholder="Event Title" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="eventLabel">Label</label>
                                                <select class="select2 select-event-label form-select" id="eventLabel"
                                                    name="eventLabel">
                                                    <option data-label="primary" value="Business" selected>Business
                                                    </option>
                                                    <option data-label="danger" value="Personal">Personal</option>
                                                    <option data-label="warning" value="Family">Family</option>
                                                    <option data-label="success" value="Holiday">Holiday</option>
                                                    <option data-label="info" value="ETC">ETC</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="eventStartDate">Start Date</label>
                                                <input type="text" class="form-control" id="eventStartDate"
                                                    name="eventStartDate" placeholder="Start Date" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="eventEndDate">End Date</label>
                                                <input type="text" class="form-control" id="eventEndDate"
                                                    name="eventEndDate" placeholder="End Date" />
                                            </div>
                                            <div class="mb-3 d-none">
                                                <label class="switch">
                                                    <input type="checkbox" class="switch-input allDay-switch " />
                                                    <span class="switch-toggle-slider">
                                                        <span class="switch-on"></span>
                                                        <span class="switch-off"></span>
                                                    </span>
                                                    <span class="switch-label">All Day</span>
                                                </label>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="eventURL">Event URL</label>
                                                <input type="url" class="form-control" id="eventURL" name="eventURL"
                                                    placeholder="https://www.google.com" />
                                            </div>
                                            <!-- <div class="mb-3 select2-primary">
                            <label class="form-label" for="eventGuests">Add Guests</label>
                            <select
                              class="select2 select-event-guests form-select"
                              id="eventGuests"
                              name="eventGuests"
                              multiple>
                              <option data-avatar="1.png" value="Jane Foster">Jane Foster</option>
                              <option data-avatar="3.png" value="Donna Frank">Donna Frank</option>
                              <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                              <option data-avatar="7.png" value="Lori Spears">Lori Spears</option>
                              <option data-avatar="9.png" value="Sandy Vega">Sandy Vega</option>
                              <option data-avatar="11.png" value="Cheryl May">Cheryl May</option>
                            </select>
                          </div> -->
                                            <div class="mb-3">
                                                <label class="form-label" for="eventLocation">Location</label>
                                                <input type="text" class="form-control" id="eventLocation"
                                                    name="eventLocation" placeholder="Enter Location" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="eventDescription">Description</label>
                                                <textarea class="form-control" name="eventDescription"
                                                    id="eventDescription"></textarea>
                                            </div>
                                            <div class="mb-3 d-flex justify-content-between justify-items-center my-4">
                                                <div>
                                                    <button type="submit" id="submit_calendar_events"
                                                        class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                                    <button type="reset"
                                                        class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                                        data-bs-dismiss="offcanvas">
                                                        Cancel
                                                    </button>
                                                </div>
                                                <div><button
                                                        class="btn btn-label-danger btn-delete-event d-none">Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /Calendar & Modal -->
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
var detail_btn = function(cell, formatterParams, onRendered) {
    var reserve_id = cell.getData().xid;

    return "<a class='btn btn-outline-primary' href='reservation-view-details?ID=" + reserve_id +
        "' ><i class='fa-solid fa-eye'></i> </a>";
};

// Initialize the Tabulator table with fetched data
//function initializeTable(data) {
var table = new Tabulator("#reserve-list-view-table", {
    layout: "fitDataStretch",
    movableColumns: true,
    placeholder: "No Data Found",
    pagination: true, //enable pagination
    paginationMode: "remote", //enable remote pagination
    paginationSizeSelector: [40, 50, 100, 500, 1000, true],
    paginationSize: 40,
    filterMode: "remote",
    sortMode: "remote",
    ajaxURL: "/reserve_approved_data",
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
            title: "Reservation Date",
            field: "reserve_date",
            headerFilter: "date",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Reservation ID",
            field: "reservation_id",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Booking ID",
            field: "booking_id",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        {
            title: "Time",
            field: "time",
            hozAlign: "center",
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            headerFilterLiveFilter: false
        },
        {
            title: "Room",
            field: "room",
            hozAlign: "center",
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            headerFilterLiveFilter: false
        },
        {
            title: "Room Setup",
            field: "setup",
            hozAlign: "center",
            headerFilter: "list",
            headerFilterParams: {
                valuesLookup: true,
                clearable: true
            },
            headerFilterLiveFilter: false
        },
        {
            title: "Reservation Status",
            field: "reserve_status",
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
    document.getElementById("download-xlsx").addEventListener("click", handleXslDownload);
});

//trigger download of data.xlsx file
function handleXslDownload() {
    table.download("xlsx", "Approved Booking as of Year " + currentYear + ".xlsx", {
        sheetName: "Request List"
    });
};
//trigger download of PDF file
function handlePdfDownload() {
    table.download("pdf", "Approved Booking as of " + formattedDateWithHyphens + ".pdf", {
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
                data.doc.text("Reservation List as of " + currentDate, 340, 35);
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