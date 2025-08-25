$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#hid").val("");

    $("#Add_Users_details").on("hidden.bs.modal", function() {
        $("#UserForm")[0].reset();
        $("#hid").val("");
        $("#UserForm").validate().resetForm();
        $("#status").val("").change();
        $("#UserForm").find('.error').removeClass('error');
        $("#oldimgbox").hide();
        $('.password-container').show();
    });

    if ($.fn.DataTable.isDataTable('#UserTable')) {
        $('#UserTable').DataTable().destroy();
    }

    $('#UserTable').dataTable({
        searching: true,
        paging: true,
        pageLength: 10,

        "ajax": {
            url: "/admin/userslist",
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $("[name='_token']").val(),
            },
        },
        columns: [{
                data: "firstname",
            },
            {
                data: "lastname",
            },
            {
                data: "email",
            },
            {
                data: "phone",
            },
            {
                data: "action",
                orderable: false
            },
        ],
    });
    $('#loader-container').hide();
})

$(document).on('click', '#Add_Users', function() {
    $('#Add_Users_details').modal('show');
    $("#modal_title").html("");
    $("#modal_title").html("Add User");
    $("#modal_title").html("Add User");
});


var validationRules = {
    firstname: "required",
    lastname: "required",
    phone: {
        required: true,
        digits: true, // Ensures only numbers
        minlength: 10,
        maxlength: 10,
    },
    email: {
        required: true,
        email: true,
    },
    password: {
        required: function() {
            return $('#hid').val() === "";
        },

        minlength: 8,
        pattern: /^(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/,
    },
};

var validationMessages = {
    firstname: "Please enter first name",
    lastname: "Please enter last name",
    phone: {
        required: "Please enter the phone number",
        digits: "Phone number must contain only numbers",
        minlength: "Phone number must be exactly 10 digits",
        maxlength: "Phone number must be exactly 10 digits",
    },
    email: {
        required: "Please enter the email address",
        email: "Please enter a valid email address",
    },
    password: {
        required: "Please enter a password",
        minlength: "Password must be at least 8 characters long",
        pattern: "Password must contain at least one special character",
    },
};

$('form[id="UserForm"]').validate({
    rules: validationRules,
    messages: validationMessages,

    submitHandler: function() {
        var formData = new FormData($("#UserForm")[0]);
        $('#loader-container').show();
        $.ajax({
            url: BASE_URL + '/admin/users/save',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data && Object.keys(data).length > 0) {
                    if (data.status == 1) {
                        toastr.success(data.message);
                        $('#loader-container').hide();
                        $('#Add_Users_details').modal('hide');
                    } else {
                        toastr.error(data.message);
                        $('#loader-container').hide();
                    }
                }
                $("#UserForm")[0].reset();
                $("#UserForm").validate().resetForm();
                $("#UserForm").find('.error').removeClass('error');
                $('#UserTable').DataTable().ajax.reload();
            }
        });
    },
});

$(document).on('click', '#edit_user', function() {
    var id = $(this).data("id");
    $.ajax({
        type: "GET",
        url: "/admin/users/edit",
        data: {
            _token: $("[name='_token']").val(),
            id: id,
        },
        success: function(response) {
            if (response.status == 1) {
                if (response.users_data) {
                    var usersdata = response.users_data;
                    $('#Add_Users_details').modal('show');
                    $("#modal_title").html("Edit User");

                    // Set form values
                    $('#hid').val(usersdata.id);
                    $('#firstname').val(usersdata.firstname);
                    $('#lastname').val(usersdata.lastname);
                    $('#phone').val(usersdata.phone);
                    $('#email').val(usersdata.email);
                    $('.password-container').hide();
                }
            }
        },
    });
});


$(document).on("click", "#delete_user", function() {
    let id = $(this).data("id");
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "/admin/users/delete",
                data: {
                    _token: $("[name='_token']").val(),
                    id: id,
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        $('#UserTable').DataTable().ajax.reload();
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
    });
});