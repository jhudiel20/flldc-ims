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

$(document).ready(function () {

// ############ - ROOM & RESERVATION - ############
    $('#add_room').on('click', function() {
        var formdata = new FormData(document.getElementById('add_room_form'));
            if ($('#roomname').val() == "") {
                $("#roomname").css({
                    "border-color": 'red'
                });
            } else {
                $("#roomname").css({
                    "border-color": ''
                });
            }
            if ($('#roomtype').val() == "") {
                $("#roomtype").css({
                    "border-color": 'red'
                });
            } else {
                $("#roomtype").css({
                    "border-color": ''
                });
            }
            if ($('#capacity').val() == "") {
                $("#capacity").css({
                    "border-color": 'red'
                });
            } else {
                $("#capacity").css({
                    "border-color": ''
                });
            }
            if ($('#floornumber').val() == "") {
                $("#floornumber").css({
                    "border-color": 'red'
                });
            } else {
                $("#floornumber").css({
                    "border-color": ''
                });
            }
            if ($('#status').val() == "") {
                $("#status").css({
                    "border-color": 'red'
                });
            } else {
                $("#status").css({
                    "border-color": ''
                });
            }
            if ($('#features').val() == "") {
                $("#features").css({
                    "border-color": 'red'
                });
            } else {
                $("#features").css({
                    "border-color": ''
                });
            }
            if ($('#usage').val() == "") {
                $("#usage").css({
                    "border-color": 'red'
                });
            } else {
                $("#usage").css({
                    "border-color": ''
                });
            }
            if ($('#roomphoto').val() == "") {
                $("#roomphoto").css({
                    "border-color": 'red'
                });
            } else {
                $("#roomphoto").css({
                    "border-color": ''
                });
            }
        $.ajax({
            url: "/add_room",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#add_room');
            },
            success: function (response) {
                hideLoading('#add_room');
                console.log(response);
                if (response.success) {
                    $('#add_room_modal').modal('hide');
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        table.setData();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#edit_room_details_btn').on('click', function() {
        var formdata = new FormData(document.getElementById('room_details_form'));
            if ($('#roomname').val() == "") {
                $("#roomname").css({
                    "border-color": 'red'
                });
            } else {
                $("#roomname").css({
                    "border-color": ''
                });
            }
            if ($('#roomtype').val() == "") {
                $("#roomtype").css({
                    "border-color": 'red'
                });
            } else {
                $("#roomtype").css({
                    "border-color": ''
                });
            }
            if ($('#capacity').val() == "") {
                $("#capacity").css({
                    "border-color": 'red'
                });
            } else {
                $("#capacity").css({
                    "border-color": ''
                });
            }
            if ($('#floornumber').val() == "") {
                $("#floornumber").css({
                    "border-color": 'red'
                });
            } else {
                $("#floornumber").css({
                    "border-color": ''
                });
            }
            if ($('#status').val() == "") {
                $("#status").css({
                    "border-color": 'red'
                });
            } else {
                $("#status").css({
                    "border-color": ''
                });
            }
            if ($('#features').val() == "") {
                $("#features").css({
                    "border-color": 'red'
                });
            } else {
                $("#features").css({
                    "border-color": ''
                });
            }
            if ($('#usage').val() == "") {
                $("#usage").css({
                    "border-color": 'red'
                });
            } else {
                $("#usage").css({
                    "border-color": ''
                });
            }
        $.ajax({
            url: "/edit_room_details",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#edit_room_details_btn');
            },
            success: function (response) {
                hideLoading('#edit_room_details_btn');
                console.log(response);
                if (response.success) {
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#upload_room_photo_btn').on('click', function() {
        var formdata = new FormData(document.getElementById('upload_room_photo_form'));
        $.ajax({
            url: "/upload_room_photo",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#upload_room_photo_btn');
            },
            success: function (response) {
                hideLoading('#upload_room_photo_btn');
                console.log(response);
                if (response.success) {
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#delete_room_photo_btn').on('click', function() {
        var formdata = new FormData(document.getElementById('delete_room_photo_form'));
        $.ajax({
            url: "/delete_room_photo",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#delete_room_photo_btn');
            },
            success: function (response) {
                hideLoading('#delete_room_photo_btn');
                console.log(response);
                if (response.success) {
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#submit_reserve_approval_btn').on('click', function() {
        var formdata = new FormData(document.getElementById('reserve_approval_form'));
        $.ajax({
            url: "/update_reserve_status",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#submit_reserve_approval_btn');
            },
            success: function (response) {
                hideLoading('#submit_reserve_approval_btn');
                console.log(response);
                if (response.success) {
                    $('#approval_modal').modal('hide');
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#submit_edit_reserve_details').on('click', function() {
        var formdata = new FormData(document.getElementById('reserve_details_form'));
        $.ajax({
            url: "/edit_reserve_details_info",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#submit_edit_reserve_details');
            },
            success: function (response) {
                hideLoading('#submit_edit_reserve_details');
                console.log(response);
                if (response.success) {
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });

// ############ - PR & REQUEST - ############
    $('#add_request').on('click', function() {
        var formdata = new FormData(document.getElementById('add_request_form'));
            if ($('#item_name').val() == "") {
                $("#item_name").css({
                    "border-color": 'red'
                });
            } else {
                $("#item_name").css({
                    "border-color": ''
                });
            }
            if ($('#quantity').val() == "") {
                $("#quantity").css({
                    "border-color": 'red'
                });
            } else {
                $("#quantity").css({
                    "border-color": ''
                });
            }
            if ($('#purpose').val() == "") {
                $("#purpose").css({
                    "border-color": 'red'
                });
            } else {
                $("#purpose").css({
                    "border-color": ''
                });
            }
            if ($('#date_needed').val() == "") {
                $("#date_needed").css({
                    "border-color": 'red'
                });
            } else {
                $("#date_needed").css({
                    "border-color": ''
                });
            }
            if ($('#item_photo').val() == "") {
                $("#item_photo").css({
                    "border-color": 'red'
                });
            } else {
                $("#item_photo").css({
                    "border-color": ''
                });
            }
        $.ajax({
            url: "/add_request",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#add_request');
            },
            success: function (response) {
                hideLoading('#add_request');
                console.log(response);
                if (response.success) {
                    $('#add_request_modal').modal('hide');
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        table.setData();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#submit_approval_btn').on('click', function() {
        var formdata = new FormData(document.getElementById('request_approval_form'));
        $.ajax({
            url: "/update_request_status",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#submit_approval_btn');
            },
            success: function (response) {
                hideLoading('#submit_approval_btn');
                console.log(response);
                if (response.success) {
                    $('#approval_modal').modal('hide');
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#submit_edit_purchase_details').on('click', function() {
        var formdata = new FormData(document.getElementById('purchase_details_form'));
        $.ajax({
            url: "/edit_purchase_details_info",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#submit_edit_purchase_details');
            },
            success: function (response) {
                hideLoading('#submit_edit_purchase_details');
                console.log(response);
                if (response.success) {
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#upload_po_attachments_btn').on('click', function() {
        var formdata = new FormData(document.getElementById('upload_po_attachments_form'));
        $.ajax({
            url: "/upload_po_attachment",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#upload_po_attachments_btn');
            },
            success: function (response) {
                hideLoading('#upload_po_attachments_btn');
                console.log(response);
                if (response.success) {
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // For debugging
                var errorMessage = 'An error occurred: ' + (xhr.status ? xhr.status + ' ' + xhr.statusText : 'Unknown error');
                if (xhr.status === 413) {
                    swal({
                        icon: 'error',
                        title: 'Upload Error',
                        text: 'File size too large.',
                        buttons: false,
                        timer: 2000,
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'error',
                        title: 'Upload Error',
                        text: errorMessage,
                        buttons: false,
                        timer: 2000,
                    });
                }
            }
        });
    });
    $('#delete_po_attachments_btn').on('click', function() {
        var formdata = new FormData(document.getElementById('delete_po_attachments_form'));
        $.ajax({
            url: "/delete_po_attachments",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#delete_po_attachments_btn');
            },
            success: function (response) {
                hideLoading('#delete_po_attachments_btn');
                console.log(response);
                if (response.success) {
                    $('#delete-po-attachment-modal').modal('hide');
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#upload_item_photo_btn').on('click', function() {
        var formdata = new FormData(document.getElementById('upload_item_photo_form'));
        $.ajax({
            url: "/upload_item_photo",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#upload_item_photo_btn');
            },
            success: function (response) {
                hideLoading('#upload_item_photo_btn');
                console.log(response);
                if (response.success) {
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#delete_purchase_photo_btn').on('click', function() {
        var formdata = new FormData(document.getElementById('delete_purchase_photo_form'));
        $.ajax({
            url: "/delete_purchase_photo",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#delete_purchase_photo_btn');
            },
            success: function (response) {
                hideLoading('#delete_purchase_photo_btn');
                console.log(response);
                if (response.success) {
                    $('#delete_purchase_photo_modal').modal('hide');
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });

// ############ - RCA & PCV - ############
    $('#add_rca').on('click', function() {
        var formdata = new FormData(document.getElementById('add_rca_form'));
            if ($('#employee').val() == "") {
                $("#employee").css({
                    "border-color": 'red'
                });
            } else {
                $("#employee").css({
                    "border-color": ''
                });
            }
            if ($('#employee_no').val() == "") {
                $("#employee_no").css({
                    "border-color": 'red'
                });
            } else {
                $("#employee_no").css({
                    "border-color": ''
                });
            }
            if ($('#paygroup').val() == "") {
                $("#paygroup").css({
                    "border-color": 'red'
                });
            } else {
                $("#paygroup").css({
                    "border-color": ''
                });
            }
            if ($('#sbu').val() == "") {
                $("#sbu").css({
                    "border-color": 'red'
                });
            } else {
                $("#sbu").css({
                    "border-color": ''
                });
            }
            if ($('#branch').val() == "") {
                $("#branch").css({
                    "border-color": 'red'
                });
            } else {
                $("#branch").css({
                    "border-color": ''
                });
            }
            if ($('#amount').val() == "") {
                $("#amount").css({
                    "border-color": 'red'
                });
            } else {
                $("#amount").css({
                    "border-color": ''
                });
            }
            if ($('#payee').val() == "") {
                $("#payee").css({
                    "border-color": 'red'
                });
            } else {
                $("#payee").css({
                    "border-color": ''
                });
            }
            if ($('#account_no').val() == "") {
                $("#account_no").css({
                    "border-color": 'red'
                });
            } else {
                $("#account_no").css({
                    "border-color": ''
                });
            }
            if ($('#purpose_rca').val() == "") {
                $("#purpose_rca").css({
                    "border-color": 'red'
                });
            } else {
                $("#purpose_rca").css({
                    "border-color": ''
                });
            }
            if ($('#date_needed').val() == "") {
                $("#date_needed").css({
                    "border-color": 'red'
                });
            } else {
                $("#date_needed").css({
                    "border-color": ''
                });
            }
            if ($('#date_event').val() == "") {
                $("#date_event").css({
                    "border-color": 'red'
                });
            } else {
                $("#date_event").css({
                    "border-color": ''
                });
            }
            if ($('#purpose_travel').val() == "") {
                $("#purpose_travel").css({
                    "border-color": 'red'
                });
            } else {
                $("#purpose_travel").css({
                    "border-color": ''
                });
            }
            if ($('#date_depart').val() == "") {
                $("#date_depart").css({
                    "border-color": 'red'
                });
            } else {
                $("#date_depart").css({
                    "border-color": ''
                });
            }
            if ($('#date_return').val() == "") {
                $("#date_return").css({
                    "border-color": 'red'
                });
            } else {
                $("#date_return").css({
                    "border-color": ''
                });
            }
            if ($('#receipt').val() == "") {
                $("#receipt").css({
                    "border-color": 'red'
                });
            } else {
                $("#receipt").css({
                    "border-color": ''
                });
            }
        $.ajax({
            url: "/add_rca",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#add_rca');
            },
            success: function (response) {
                hideLoading('#add_rca');
                console.log(response);
                if (response.success) {
                    $('#add_rca_modal').modal('hide');
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        table.setData();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });
    $('#add_pcv').on('click', function() {
        var formdata = new FormData(document.getElementById('add_pcv_form'));
            if ($('#pcv_no').val() == "") {
                $("#pcv_no").css({
                    "border-color": 'red'
                });
            } else {
                $("#pcv_no").css({
                    "border-color": ''
                });
            }
            if ($('#employee').val() == "") {
                $("#employee").css({
                    "border-color": 'red'
                });
            } else {
                $("#employee").css({
                    "border-color": ''
                });
            }
            if ($('#sbu').val() == "") {
                $("#sbu").css({
                    "border-color": 'red'
                });
            } else {
                $("#sbu").css({
                    "border-color": ''
                });
            }
            if ($('#department').val() == "") {
                $("#department").css({
                    "border-color": 'red'
                });
            } else {
                $("#department").css({
                    "border-color": ''
                });
            }
            if ($('#expenses').val() == "") {
                $("#expenses").css({
                    "border-color": 'red'
                });
            } else {
                $("#expenses").css({
                    "border-color": ''
                });
            }
            if ($('#sdcc').val() == "") {
                $("#sdcc").css({
                    "border-color": 'red'
                });
            } else {
                $("#sdcc").css({
                    "border-color": ''
                });
            }
            if ($('#remarks').val() == "") {
                $("#remarks").css({
                    "border-color": 'red'
                });
            } else {
                $("#remarks").css({
                    "border-color": ''
                });
            }
            if ($('#pcv').val() == "") {
                $("#pcv").css({
                    "border-color": 'red'
                });
            } else {
                $("#pcv").css({
                    "border-color": ''
                });
            }
        $.ajax({
            url: "/add_pcv",
            method: "POST",
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                showLoading('#add_pcv');
            },
            success: function (response) {
                hideLoading('#add_pcv');
                console.log(response);
                if (response.success) {
                    $('#add_pcv_modal').modal('hide');
                    swal({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    }).then(function() {
                        table.setData();
                    });
                } else {
                    swal({
                        icon: 'warning',
                        title: response.title,
                        text: response.message,
                        buttons: false,
                        timer: '2000',
                    })
                }
            }
        });
    });

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




