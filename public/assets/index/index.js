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
                $('#signin_btn').addClass('d-none').prop('disabled', false);
                },
            success: function(response) {
                if (response.success) {
                    Toast.fire({
                            icon: 'success',
                            title: response.title,
                            text: response.message,
                        })
                        .then(function() {
                            window.location.href = '/dashboard-lnd';
                        });
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

document.addEventListener("keydown", function(event) {
    if (event.keyCode === 13) {
        document.getElementById("send_link").click();
    }
});
$(document).ready(function() {
    $('#forgot_pass_form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        if ($('#email').val() == "") {
            $("#email").css({
                "border-color": 'red'
            });
        } else {
            $("#email").css({
                "border-color": ''
            });
        }
        $.ajax({
            url: '/email_forgot_password', // Ensure this path is correct
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function() {
                    $('#send_link').addClass('d-none');
                    $('#request_emailed_icon').removeClass('d-none').prop('disabled', true);
                },
            success: function(response) {
                    $('#request_emailed_icon').addClass('d-none').prop('disabled', false);
                    $('#send_link').removeClass('d-none');
                console.log(response);
                if (response.success) {
                    Toast.fire({
                            icon: 'success',
                            title: response.title,
                            text: response.message,
                        }).then(function() {
                        window.location = 'https://accounts.google.com/v3/signin/identifier?dsh=S353362604%3A1662139475311681&continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&rip=1&sacu=1&service=mail&flowName=GlifWebSignIn&flowEntry=ServiceLogin&ifkv=AQN2RmWP2lxwpbPaE9a9BMhcTpWZktay-FoTk3A3cKXBKV96YhdOdaLCY7W_obLcGmxp8SWN1zdpiQ';
                        });
                } else {
                    Toast.fire({
                        icon: response.icon,
                        title: response.title,
                        text: response.message,
                    })
                }
            }
        })
    })
});

document.addEventListener("keydown", function(event) {
    if (event.keyCode === 13) {
        document.getElementById("set_password").click();
    }
});
$(document).ready(function() {
    $('#change_pass_form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        if ($('#password').val() == "") {
            $("#password").css({
                "border-color": 'red'
            });
        } else {
            $("#password").css({
                "border-color": ''
            });
        }
        if ($('#confirmpassword').val() == "") {
            $("#confirmpassword").css({
                "border-color": 'red'
            });
        } else {
            $("#confirmpassword").css({
                "border-color": ''
            });
        }
        
    $.ajax({
        url: '/change_password', // Ensure this path is correct
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function() {
                    $('#set_password').addClass('d-none');
                    $('#set_pass_icon').removeClass('d-none').prop('disabled', true);
                },
            success: function(response) {
                    $('#set_pass_icon').addClass('d-none').prop('disabled', false);
                    $('#set_password').removeClass('d-none');
            console.log(response);
            if (response.success) {
                Toast.fire({
                        icon: 'success',
                        title: response.title,
                        text: response.message,
                    }).then(function() {
                      window.location = '/';
                    });
            } else {
                Toast.fire({
                    icon: response.icon,
                    title: response.title,
                    text: response.message,
                })
            }
        }
    })
  })
});