<?php
require_once __DIR__ . '/../../DBConnection.php';
require_once __DIR__ . '/../../config/config.php';

if (!isset($decrypted_array['ACCESS'])) {
    header("Location:/");
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
                            <div class="card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-12">
                                        <div class="card-body">
                                            <div class="py-1 mb-2">
                                                <div class="additional-buttons">
                                                    <button class="btn btn-label-primary text-end" onclick="toggleView()">
                                                        <i class="fa-solid fa-calendar me-1"></i> Calendar View (Approved Events)
                                                    </button>
                                                    <button class="btn btn-label-primary" id="download-xlsx">
                                                        <i class="fa-solid fa-download me-1"></i> XLSX
                                                    </button>
                                                    <button class="btn btn-label-primary" id="download-pdf">
                                                        <i class="fa-solid fa-download me-1"></i> PDF
                                                    </button>
                                                </div>
                                                
                                            </div>
                                            <!-- BUTTONS WHEN MEDIA SCREEN IS LOWER  -->
                                            <div class="minimize-buttons btn-group mb-2">
                                                <button type="button" class="btn btn-label-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">More
                                                    Actions</button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="toggleView()">
                                                        <i class="fa-solid fa-calendar me-1"></i> Calendar View (Approved Events)</a>
                                                    </li>
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
                                            <?php include __DIR__ . "/../../modals/reservation_list_modal.php"; ?>
                                            <!-- End of Add Modal -->

                                            <div id="table-view" class="mb-2">
                                                <div  class="tabulator-table" id="reserve-list-table" style="font-size:14px;"></div>
                                            </div>
                                            <div id="calendar-view" class="mb-2 d-none">
                                                <div class="card-body" id="calendar"></div>
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

// var invoice_attachment = function(cell, formatterParams, onRendered) {
//     var INVOICE = cell.getData().invoice;
//     var ID = cell.getRow().getData().id;

//     if(INVOICE != ''){
//         return "<a href='fetch?db=RESERVATION_INVOICE&file=" + encodeURIComponent(INVOICE) + "' target='_blank' ><i class='fa-solid fa-paperclip'></i></a>";
//     }else{
//         return "<i class='fa-solid fa-circle-xmark'></i>";
//     }

// }


var approval_status = function(cell, formatterParams, onRendered) {
    var reserve_status = cell.getData().reserve_status; // Get the approved status from the cell
    var ID = cell.getRow().getData().id; // Get the ID of the user
    var EMAIL = cell.getRow().getData().email;
    var room_id = cell.getRow().getData().roomid;
    // console.log(ID);

    <?php if($decrypted_array['RESERVATION_ACCESS'] == 'ADMIN'){?>
        if (reserve_status == "PENDING") {
            return "<button type='button' class='btn btn-outline-primary approval-reserve-status' data-id='" + ID + "' data-roomid='" + room_id + "' data-approved='" + reserve_status + "' data-email=' " + EMAIL + " ' >PENDING</button>";
        }
        if (reserve_status == "DECLINED"){
            return "<button type='button' class='btn btn-outline-danger approval-reserve-status' data-id='" + ID + "' data-roomid='" + room_id + "' data-approved='" + reserve_status + "' data-email=' " + EMAIL + " ' >DECLINED</button>";
        }
        if(reserve_status == "APPROVED"){
            return "<button type='button' class='btn btn-outline-success approval-reserve-status' data-id='" + ID + "' data-roomid='" + room_id + "' data-approved='" + reserve_status + "' data-email=' " + EMAIL + " ' >APPROVED</button>";
        }
        if(reserve_status == "CANCELLED"){
            return "<button type='button' disabled class='btn btn-outline-info approval-reserve-status' data-id='" + ID + "' data-roomid='" + room_id + "' data-approved='" + reserve_status + "' data-email=' " + EMAIL + " ' >CANCELLED</button>";
        }
    <?php }else{ ?>
    return reserve_status;
    <?php } ?>
};

var detail_btn = function(cell, formatterParams, onRendered) {
    var reserve_id = cell.getData().xid;

    return "<a class='btn btn-outline-primary' href='reservation-details?ID=" + reserve_id +
        "' ><i class='fa-solid fa-eye'></i> </a>";
};

var rowPopupFormatter = function(e, row) {
    const rowData = row.getData(); // Fetch row data
    const container = document.createElement("div"); // Create a container element

    // Build popup contents
    const contents = `
        <strong style="font-size:1.2em;">Reservation Details</strong>
        <br/>
        <ul style="padding:0; margin-top:10px; margin-bottom:0; list-style:none;">
            <li><strong>Date Created:</strong> ${rowData.room || "N/A"}</li>
            <li><strong>Full Name:</strong> ${rowData.fname ? rowData.fname + " " + (rowData.lname || "") : "N/A"}</li>
            <li><strong>Bussiness Unit:</strong> ${rowData.business_unit || "N/A"}</li>
            <li><strong>No of Table:</strong> ${rowData.table || "0"}</li>
            <li><strong>No of Chairs:</strong> ${rowData.chair || "0"}</li>
            <li><strong>Extension Cord:</strong> ${rowData.extension === true ? "Yes" : "No"}</li>
            <li><strong>HDMI Cable:</strong> ${rowData.hdmi === true ? "Yes" : "No"}</li>
            <li><strong>Purpose / Message:</strong> ${rowData.message || "N/A"}</li>
        </ul>
    `;

    container.innerHTML = contents; // Set the container's content
    return container; // Return the container element
};

// Initialize the Tabulator table with fetched data
//function initializeTable(data) {
var table = new Tabulator("#reserve-list-table", {
    layout: "fitDataFill",
    movableColumns: true,
    placeholder: "No Data Found",
    pagination: true, //enable pagination
    paginationMode: "remote", //enable remote pagination
    paginationSizeSelector: [40, 50, 100, 500, 1000, true],
    paginationSize: 40,
    filterMode: "remote",
    rowClickPopup: rowPopupFormatter,  // Keep this as is
    rowFormatter: function(row) {
        row.getElement().addEventListener("click", function(e) {
            // Prevent row popup from triggering on button or link clicks
            if (e.target.closest("button") || e.target.closest("a")) {
                return; // Exit function, but let the button work
            }
        });
    },
    sortMode: "remote",
    ajaxURL: "/reserve_list_data",
    columns: [
        {
            title: "DATE",
            field: "date_created",
            visible: false,
            download: true
        },
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
            title: "Booking ID",
            field: "booking_id",
            headerFilter: "input",
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
            title: "Reservation Date",
            field: "reserve_date",
            headerFilter: "date",
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
            title: "Guest",
            field: "guest",
            headerFilter: "input",
            hozAlign: "center",
            headerFilterLiveFilter: false
        },
        <?php if ($decrypted_array['RESERVATION_ACCESS'] == 'ADMIN') { ?>
        {
            title: "Reservation Status",
            field: "reserve_status",
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
        <?php } if ($decrypted_array['RESERVATION_ACCESS'] == 'USER') { ?>
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
            headerFilterLiveFilter: false,
        },
        <?php } ?>
        {
            title: "First Name",
            field: "fname",
            visible: false,
            download: true
        },
        {
            title: "Last Name",
            field: "lname",
            visible: false,
            download: true
        },
        {
            title: "Business Unit",
            field: "business_unit",
            visible: false,
            download: true
        },
        {
            title: "Branch",
            field: "branch",
            visible: false,
            download: true
        },
        {
            title: "Email",
            field: "email",
            visible: false,
            download: true
        },
        {
            title: "Contact",
            field: "contact",
            visible: false,
            download: true
        },
        {
            title: "HDMI Cable",
            field: "hdmi",
            visible: false,
            download: true
        },
        {
            title: "Externsion Cord",
            field: "extension",
            visible: false,
            download: true
        },
        {
            title: "Additional Chairs",
            field: "chair",
            visible: false,
            download: true
        },
        {
            title: "Additional Table",
            field: "table",
            visible: false,
            download: true
        },
        {
            title: "Purpose",
            field: "message",
            visible: false,
            download: true
        },
        {
            title: "Price",
            field: "prices",
            visible: false,
            download: true
        },
                // {
        //     title: "Invoice",
        //     field: "invoice",
        //     formatter: invoice_attachment,
        //     hozAlign: "center",
        //     headerFilter: "list",
        //     headerFilterParams: {
        //         valuesLookup: true,
        //         clearable: true
        //     },
        //     // width: 300,
        //     headerFilterLiveFilter: false
        // },
    ],
    ajaxResponse: function(url, params, response) {
        return {
                last_page: response.last_page,
                total: response.total_record,
                data: response.data
                }; //response.data; //return the tableData property of a response json object
    },
});

//trigger download of data.pdf file
document.addEventListener("DOMContentLoaded", function() {
    // Your JavaScript code here, including event listener setup
    document.getElementById("download-pdf-1").addEventListener("click", handlePdfDownload);
    document.getElementById("download-xlsx-1").addEventListener("click", handleXslDownload);
    document.getElementById("download-pdf").addEventListener("click", handlePdfDownload);
    document.getElementById("download-xlsx").addEventListener("click", handleXslDownload);
});

//trigger download of data.xlsx file
function handleXslDownload() {
    table.download("xlsx", "Reservation List as of Year " + currentYear + ".xlsx", {
        sheetName: "Request List"
    });
};
//trigger download of PDF file
function handlePdfDownload() {
    table.download("pdf", "Reservation List as of " + formattedDateWithHyphens + ".pdf", {
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

$(document).ready(function () {
    initializeCalendar();
});
// // ################################################ - CALENDAR - #############################################################

var calendar; // Declare globally to access it within the toggle function

function initializeCalendar() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        views: {
            dayGridMonth: {
                titleFormat: { year: 'numeric', month: 'long' }
            },
            timeGridWeek: {
                titleFormat: { year: 'numeric', month: 'long', day: 'numeric' }
            }
        },
        displayEventTime: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        events: {
            url: '/app_res_calendar_data',
            method: 'GET',
            failure: function(error) {
                console.error('Error fetching calendar data:', error);
                alert('There was an error fetching calendar data.');
            }
        },
        eventDidMount: function(info) {
            info.el.classList.add('bg-success', 'text-white');
        },
        eventClick: function(info) {
            var event = info.event;
            document.getElementById('modalRoomName').value = event.title;
            // document.getElementById('modalDate').value = event.start.toISOString().split('T')[0];
            // Convert event start time to local date
            var localDate = new Date(event.start);
            var formattedDate = localDate.toLocaleDateString('en-CA'); // 'en-CA' gives YYYY-MM-DD format
            document.getElementById('modalDate').value = formattedDate;
            document.getElementById('modalTime').value = event.start.toLocaleTimeString() + ' - ' + event.end.toLocaleTimeString();
            document.getElementById('modalName').value = event.extendedProps.name;
            document.getElementById('modalReservedID').value = event.extendedProps.reserve_id;
            document.getElementById('modalBU').value = event.extendedProps.bu;
            document.getElementById('modalContact').value = event.extendedProps.contact_no;
            document.getElementById('modalEmail').value = event.extendedProps.email_add;
            document.getElementById('modalHdmi').value = event.extendedProps.hdmi;
            document.getElementById('modalExtension').value = event.extendedProps.extension;
            document.getElementById('modalGuest').value = event.extendedProps.guest_no;
            document.getElementById('modalChair').value = event.extendedProps.chair_no;
            document.getElementById('modalSetup').value = event.extendedProps.chair_setup;
            document.getElementById('modalTable').value = event.extendedProps.table_no;
            document.getElementById('modalMessage').value = event.extendedProps.message;
            
            var eventModal = new bootstrap.Modal(document.getElementById('event_details'), {});
            eventModal.show();
        }
    });
}

function toggleView() {
    var tableView = document.getElementById('table-view');
    var calendarView = document.getElementById('calendar-view');
    const toggleButton = document.querySelector("button[onclick='toggleView()']");
    const toggleButton1 = document.querySelector("a[onclick='toggleView()']");
    var button1 = document.getElementById('download-xlsx');
    var button2 = document.getElementById('download-pdf');

    if (tableView.classList.contains("d-none")) {
        // Show table view and hide calendar view
        button1.classList.remove("d-none");
        button2.classList.remove("d-none");
        tableView.classList.remove("d-none");
        calendarView.classList.add("d-none");
        toggleButton.innerHTML = '<i class="fa-solid fa-calendar me-1"></i> Calendar View (Approved Events)';
        toggleButton1.innerHTML = '<i class="fa-solid fa-calendar me-1"></i> Calendar View (Approved Events)';
    } else {
        // Show calendar view and hide table view
        tableView.classList.add("d-none");
        button1.classList.add("d-none");
        button2.classList.add("d-none");
        calendarView.classList.remove("d-none");

        // Check if calendar is already initialized
        if (!calendar) {
            initializeCalendar();
            calendar.render();  // Render the calendar the first time
        } else {
            calendar.render();  // Refresh the calendar if it already exists
        }

        toggleButton.innerHTML = '<i class="fa-solid fa-clipboard-list me-1"></i> List View (All Events)';
        toggleButton1.innerHTML = '<i class="fa-solid fa-clipboard-list me-1"></i> List View (All Events)';
    }
}
// Initialize calendar only once when the page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeCalendar();
});

</script>

</html>