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
                <div class="card-body" id="calendar"></div>
            </div>
        </div>
    </div>

    <?php
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
                url: '/calendar_all_reserved_data',
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
                
                var eventModal = new bootstrap.Modal(document.getElementById('event_details'), {});
                eventModal.show();
            }
        });
        calendar.render(); 
    });
</script>

</html>