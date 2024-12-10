if (typeof $ === 'undefined') {
    console.error('jQuery is not loaded. Please include jQuery before this script.');
} else {

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
            // '#add_request_form': {
            //     url: '/add_request',
            //     fields: ['#item_name', '#quantity', '#purpose', '#date_needed', '#item_photo'],
            //     modal: '#add_request_modal',
            //     button: '#add_request',
            //     tableRefresh: false // Use page reload instead
            // },
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
        function handleFormSubmit(formSelector) {
            $(formSelector).on('submit', function (e) {
                e.preventDefault();
                const config = formsConfig[formSelector];
                const formData = new FormData(this);

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

                // AJAX submission
                $.ajax({
                    url: config.url,
                    method: "POST",
                    data: formData,
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
                    }
                });
            });
        }

        // Attach the handler to each form present on the page
        Object.keys(formsConfig).forEach(formSelector => {
            if ($(formSelector).length) {
                handleFormSubmit(formSelector);
            }
        });
    });

}
