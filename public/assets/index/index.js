const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast',
    },
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

$(document).ready(function() {
    $('#user_login_form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            url: '/userlogin', // Ensure this path is correct
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('#signin_btn_icon').removeClass('d-none');
                $('#signin_btn').addClass('d-none').prop('disabled', false);
                },
            success: function(response) {
                $('#signin_btn').removeClass('d-none').prop('disabled', false);
                $('#signin_btn_icon').addClass('d-none');
                if (response.success) {
                    // Toast.fire({
                    //         icon: 'success',
                    //         title: response.title,
                    //         text: response.message,
                    //     })
                    //     .then(function() {
                            window.location.href = '/dashboard-lnd';
                        // });
                } else {
                    Toast.fire({
                        icon: response.icon,
                        title: response.title,
                        text: response.message,
                    }).then(function() {
                        location.reload();
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', status, error); // Log the error to the console
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred',
                    text: 'Please try again later.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });
});
