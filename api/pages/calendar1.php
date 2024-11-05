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
                    <div id="calendar"></div>
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

    <!-- FullCalendar Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    {
                        title: 'Event 1',
                        start: '2024-11-04'
                    },
                    {
                        title: 'Event 2',
                        start: '2024-11-06',
                        end: '2024-11-08'
                    }
                    // Add more events or load them from a database
                ]
            });
            calendar.render();
        });
    </script>
</body>
</html>
