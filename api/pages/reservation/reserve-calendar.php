<?php
require_once __DIR__ . '/../../../public/config/config.php'; // Adjusted path for config.php
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php BASE_URL; ?>assets/" data-template="vertical-menu-template">
<head>
<?php
    include __DIR__ . "/../../action/global/metadata.php";
    include __DIR__ . "/../../action/global/include_top.php";
    ?>
</head>
<body>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1 class="display-1 mb-0 text-center">Reservation Calendar</h1>
                <div class="card-body" id="calendar"></div>
            </div>
        </div>
    </div>
    <?php
        include __DIR__ . "/../../modals/reservation_list_modal.php";
        include __DIR__ . "/../../action/global/include_bottom.php";
      ?>
</body>
<script src="<?php BASE_URL; ?>../assets/js/index.global.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
                document.getElementById('modalDate').value = event.start.toISOString().split('T')[0];
                document.getElementById('modalTime').value = event.start.toLocaleTimeString() + ' - ' + event.end.toLocaleTimeString();
                document.getElementById('modalName').value = event.name;
                document.getElementById('modalReservedID').value = event.reserve_id;
                document.getElementById('modalBU').value = event.bu;
                document.getElementById('modalContact').value = event.contact_no;
                document.getElementById('modalEmail').value = event.email_add;
                document.getElementById('modalHdmi').value = event.hdmi;
                document.getElementById('modalExtension').value = event.extension;
                document.getElementById('modalGuest').value = event.guest_no;
                document.getElementById('modalChair').value = event.chair_no;
                document.getElementById('modalSetup').value = event.chair_setup;
                document.getElementById('modalTable').value = event.table_no;
                document.getElementById('modalMessage').value = event.message;
                
                var eventModal = new bootstrap.Modal(document.getElementById('event_details'), {});
                eventModal.show();
            }
        });
        calendar.render(); 
    });
</script>

</html>