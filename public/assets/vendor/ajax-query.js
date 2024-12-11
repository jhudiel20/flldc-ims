$(document).ready(function () {
    // Define configurations for each form
    const formsConfig = {
            '#add_room_form': {
                url: '/add_room',
                fields: ['#roomname', '#roomtype', '#capacity', '#floornumber', '#features', '#usage', '#roomphoto'],
                modal: '#add_room_modal',
                button: '#add_room',
                tableRefresh: true // Indicates if table refresh logic is needed
            },
            '#room_details_form': {
                url: '/edit_room_details',
                fields: ['#roomname', '#roomtype', '#capacity', '#floornumber', '#features', '#usage'],
                modal: null,
                button: '#edit_room_details_btn',
                tableRefresh: false // Use page reload
            },
            '#upload_room_photo_form': {
                url: '/upload_room_photo',
                fields: [], // No validation needed
                modal: null,
                button: '#upload_room_photo_btn',
                tableRefresh: false // Use page reload
            },
            '#delete_room_photo_form': {
                url: '/delete_room_photo',
                fields: [], // No validation needed
                modal: '#delete_room_photo_modal',
                button: '#delete_room_photo_btn',
                tableRefresh: false // Use page reload
            },
            '#reserve_approval_form': {
                url: '/update_reserve_status',
                fields: [],
                modal: '#approval_modal',
                button: '#submit_approval_btn',
                tableRefresh: false // Use page reload instead
            },
            '#reserve_details_form': {
                url: '/edit_reserve_details_info',
                fields: [],
                modal: '#edit_reserve_details_modal',
                button: '#submit_edit_reserve_details',
                tableRefresh: false // Use page reload instead
            },
            '#add_request_form': {
                url: '/add_request',
                fields: ['#item_name', '#quantity', '#purpose', '#date_needed', '#item_photo'],
                modal: '#add_request_modal',
                button: '#add_request',
                tableRefresh: false // Use page reload instead
            },
            '#request_approval_form': {
                url: '/update_request_status',
                fields: [],
                modal: '#approval_modal',
                button: '#submit_approval_btn',
                tableRefresh: false // Use page reload instead
            },
            '#purchase_details_form': {
                url: '/edit_purchase_details_info',
                fields: [],
                modal: '#approval_modal',
                button: '#submit_edit_purchase_details',
                tableRefresh: false // Use page reload instead
            },
            '#upload_po_attachments_form': {
                url: '/upload_po_attachment',
                fields: [],
                modal: '#upload-po-attachment-modal',
                button: '#upload_po_attachments_btn',
                tableRefresh: false // Use page reload instead
            },
            '#delete_po_attachments_form': {
                url: '/delete_po_attachments',
                fields: [],
                modal: '#upload-po-attachment-modal',
                button: '#delete_po_attachments_btn',
                tableRefresh: false // Use page reload instead
            },
            '#upload_item_photo_form': {
                url: '/upload_item_photo',
                fields: [],
                modal: '',
                button: '#upload_item_photo_btn',
                tableRefresh: false // Use page reload instead
            },
            '#delete_purchase_photo_form': {
                url: '/delete_purchase_photo',
                fields: [],
                modal: '#delete_purchase_photo_modal',
                button: '#delete_purchase_photo_btn',
                tableRefresh: false // Use page reload instead
            },

            '#add_rca_form': {
                url: '/add_rca',
                fields: ['#employee', '#employee_no', '#paygroup', '#sbu', '#branch','#amount', '#payee', '#account_no', '#purpose_rca', '#date_needed', '#date_event', '#purpose_travel', '#date_depart', '#date_return', '#receipt'],
                modal: '#add_rca_modal',
                button: '#add_rca',
                tableRefresh: false // Use page reload instead
            },
            '#add_pcv_form': {
                url: '/add_pcv',
                fields: ['#pcv_no', '#employee', '#sbu', '#department','#expenses', '#sdcc', '#remarks', '#pcv'],
                modal: '#add_pcv_modal',
                button: '#add_pcv',
                tableRefresh: false // Use page reload instead
            }
        
    };

    // Function to show loading state
        function showLoading(btnId) {
            const originalButton = $(btnId);
            const loadingButtonId = `${btnId}-loading`; // Unique ID for the loading button

            // Hide the original button
            originalButton.hide();

            // Check if the loading button already exists
            if (!$(loadingButtonId).length) {
                // Create the loading button dynamically
                const loadingButton = $(`
                    <button id="${btnId.substring(1)}-loading" class="${originalButton.attr('class')} loading-btn" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                `);

                // Insert the loading button after the original button
                originalButton.after(loadingButton);
            }

            // Show the loading button
            $(`${loadingButtonId}`).show();
        }

        // Function to hide loading state
        function hideLoading(btnId) {
            const originalButton = $(btnId);
            const loadingButtonId = `${btnId}-loading`; // Unique ID for the loading button

            // Hide the loading button and remove it from the DOM
            $(loadingButtonId).remove();

            // Show the original button
            originalButton.show();
        }

    // Generalized function to handle form submission
    // function handleFormSubmit(formSelector) {
    //     $(formSelector).on('submit', function (e) {
    //         e.preventDefault();
    //         const config = formsConfig[formSelector];
    //         const formData = new FormData(this);

    //         let valid = true;

    //         // Validate fields if applicable
    //         if (config.fields.length > 0) {
    //             config.fields.forEach(field => {
    //                 if ($(field).val() === "") {
    //                     $(field).css({ "border-color": 'red' });
    //                     valid = false;
    //                 } else {
    //                     $(field).css({ "border-color": '' });
    //                 }
    //             });
    //         }

    //         if (!valid) return;

    //         // AJAX submission
    //         $.ajax({
    //             url: config.url,
    //             method: "POST",
    //             data: formData,
    //             dataType: "json",
    //             beforeSend: function () {
    //                 showLoading(config.button);
    //             },
    //             success: function (response) {
    //                 hideLoading(config.button);

    //                 if (response.success) {
    //                     if (config.modal) $(config.modal).modal('hide');
    //                     $(formSelector)[0].reset();
    //                     swal({
    //                         icon: 'success',
    //                         title: response.title,
    //                         text: response.message,
    //                         buttons: false,
    //                         timer: 2000,
    //                     }).then(function () {
    //                         if (config.tableRefresh) {
    //                             table.setData();
    //                         } else {
    //                             location.reload();
    //                         }
    //                     });
    //                 } else {
    //                     swal({
    //                         icon: 'warning',
    //                         title: response.title,
    //                         text: response.message,
    //                         buttons: false,
    //                         timer: 2000,
    //                     });
    //                     $(".form-message").html(response.message).css("display", "block");
    //                 }
    //             }
    //         });
    //     });
    // }

    // Attach the handler to each form present on the page
    // Object.keys(formsConfig).forEach(formSelector => {
    //     if ($(formSelector).length) {
    //         handleFormSubmit(formSelector);
    //     }
    // });

    for (const [formSelector, config] of Object.entries(formsConfig)) {
        if (!config.button || !config.url) {
            console.warn(`Skipping form ${formSelector} due to missing button or URL.`);
            continue;
        }

        let valid = true;

        // Validate fields if applicable
        if (config.fields.length > 0) {
            config.fields.forEach(field => {
                if ($(field).val() === "") {
                    $(field).css({ "border-color": 'red' });
                    valid = false;
                } else {
                    $(field).css({ "border-color": '' });
                }
            });
        }

        if (!valid) return;

        $(config.button).on('click', function () {
            const formdata = new FormData(document.querySelector(formSelector));

            $.ajax({
                url: config.url,
                method: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    showLoading(config.button);
                },
                success: function (response) {
                    hideLoading(config.button);

                    if (response.success) {
                        if (config.modal) $(config.modal).modal('hide');
                        $(formSelector)[0].reset();
                        swal({
                            icon: 'success',
                            title: response.title,
                            text: response.message,
                            buttons: false,
                            timer: 2000,
                        }).then(function () {
                            if (config.tableRefresh) {
                                table.setData();
                            } else {
                                location.reload();
                            }
                        });
                    } else {
                        swal({
                            icon: 'warning',
                            title: response.title,
                            text: response.message,
                            buttons: false,
                            timer: 2000,
                        });
                        $(".form-message").html(response.message).css("display", "block");
                    }
                },
                error: function (xhr, status, error) {
                    $(config.button).removeClass('d-none').prop('disabled', false);
                    console.error("AJAX Error: ", status, error);
                }
            });
        });
    }

        $(document).on("click", ".approval-status", function() {
            var ID = $(this).data("id");
            var APPROVAL = $(this).data("approved");
            var ROOM_ID = $(this).data("roomid");
            var EMAIL = $(this).data("email");
    
            $('#ID').val(ID);
            $('#APPROVAL').val(APPROVAL);
            $('#ROOMID').val(ROOM_ID);
            $('#EMAIL').val(EMAIL);
    
            // Show the edit modal
            $('#approval_modal').modal('show');
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
        $(document).on("click", ".update-details", function() {
            $('#edit_reserve_details_modal').modal('show');
    
                // Get the values from the form inputs
                var ID = $("#ID").val();
                var bookingID = $("#BOOKINGID").val();
                var reservationID = $("#RESERVATIONID").val();
                var reserveStatus = $("#RESERVE_STATUS").val();
                var reserveDate = $("#RESERVE_DATE").val();
                var fname = $("#FNAME").val();
                var lname = $("#LNAME").val();
                var time = $("#TIME").val();
                var room = $("#ROOM").val();
                var setup = $("#SETUP").val();
                var businessUnit = $("#BUSINESSUNIT").val();
                var guest = $("#GUEST").val();
                var contact = $("#CONTACT").val();
                var email = $("#EMAIL").val();
                var message = $("#MESSAGE").val();
    
                // Pass the values to the modal's input fields
                $('#edit_reserve_details_modal #ID').val(ID);
                $('#edit_reserve_details_modal #bookingID').val(bookingID);
                $('#edit_reserve_details_modal #reservationID').val(reservationID);
                $('#edit_reserve_details_modal #reserve_status').val(reserveStatus);
                $('#edit_reserve_details_modal #reserve_date').val(reserveDate);
                $('#edit_reserve_details_modal #fname').val(fname);
                $('#edit_reserve_details_modal #lname').val(lname);
                $('#edit_reserve_details_modal #time').val(time);
                $('#edit_reserve_details_modal #room').val(room);
                $('#edit_reserve_details_modal #setup').val(setup);
                $('#edit_reserve_details_modal #businessunit').val(businessUnit);
                $('#edit_reserve_details_modal #guest').val(guest);
                $('#edit_reserve_details_modal #contact').val(contact);
                $('#edit_reserve_details_modal #email').val(email);
                $('#edit_reserve_details_modal #message').val(message);
        });
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
            document.getElementById('modalDate').value = event.start.toISOString().split('T')[0];
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