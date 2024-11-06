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
    <style>
        /* Add this CSS to style events with the green background */
        .fc-event.event-green {
            background-color: green !important;
            border-color: green !important;
            color: white; /* Optional: to ensure text is visible on the green background */
        }
    </style>
    <!-- FullCalendar CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
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
                    <!-- Calendar Container -->
                     <div class="card">
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-12">
                                        <div class="card-body">
                                            <div id="calendar"></div>
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
                include __DIR__. "/../modals/calendar_modal.php";
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                views: {
                    dayGridMonth: { // Month view configuration
                        titleFormat: { year: 'numeric', month: 'long' } // Customize the title format
                    },
                    timeGridWeek: { // Week view configuration
                        titleFormat: { year: 'numeric', month: 'long', day: 'numeric' }, // Customize the title format
                        // You can also set options like `slotDuration` or `allDaySlot`
                    }
                },
                headerToolbar: { // Toolbar configuration for navigation
                    left: 'prev,next today', // Navigation buttons
                    center: 'title', // Title in the center
                    right: 'dayGridMonth,timeGridWeek' // Options for month and week views
                },
                events: {
                    url: '/calendar_data', // Path to the API endpoint
                    method: 'GET',
                    failure: function(error) {
                        console.error('Error fetching calendar data:', error);
                        alert('There was an error fetching calendar data.');
                    }
                },
                eventRender: function(info) {
                    // Add the 'event-green' class to the event element
                    info.el.classList.add('event-green');
                },
                eventClick: function (info) {
                    // Get event data
                    var event = info.event;
                    
                    // Populate modal fields
                    document.getElementById('modalRoomName').value = event.title;
                    document.getElementById('modalDate').value = event.start.toISOString().split('T')[0];  // Format date as YYYY-MM-DD
                    document.getElementById('modalTime').value = event.start.toLocaleTimeString() + ' - ' + event.end.toLocaleTimeString();
                    document.getElementById('modalName').value = event.extendedProps.name;
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

                    // Show the modal
                    var eventModal = new bootstrap.Modal(document.getElementById('event_details'), {});
                    eventModal.show();
                }
            });
            calendar.render();
        });
    </script>

</body>
</html>
