$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#hid").val("");

    $("#Add_doctors_details").on("hidden.bs.modal", function() {
        $("#DoctorForm")[0].reset();
        $("#hid").val("");
        $("#DoctorForm").validate().resetForm();
        $("#DoctorForm").find('.error').removeClass('error');
        $("#image_preview").html('');
    });

    if ($.fn.DataTable.isDataTable('#DoctorTable')) {
        $('#DoctorTable').DataTable().destroy();
    }

    $('#DoctorTable').dataTable({
        searching: true,
        paging: true,
        pageLength: 10,
        ajax: {
            url: "/admin/doctorlist",
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $("[name='_token']").val(),
            },
        },
        columns: [
            { data: "name" },
            { data: "specialization" },
            { data: "image", orderable: false, searchable: false },
            { data: "action", orderable: false, searchable: false }
        ],
    });
});

$(document).on('click', '#Add_doctors', function() {
    $('#Add_doctors_details').modal('show');
    $("#DoctorForm").find('.form-control').removeClass('error');
    $("#DoctorForm").find('.error').remove();
    $("#modal_title").html("Add Doctor");
});

var validationRules = {
    name: { required: true, maxlength: 191 },
    specialization: { maxlength: 191 },
    image: {
        required: function() {
            return $('#hid').val() === "";
        },
        extension: "jpg|jpeg|png|gif"
    }
};

var validationMessages = {
    name: {
        required: "Please enter the doctor's name",
        maxlength: "Name cannot exceed 191 characters",
    },
    specialization: {
        maxlength: "Specialization cannot exceed 191 characters",
    },
    image: {
        required: "Please upload an image",
        extension: "Only JPG, JPEG, PNG, or GIF formats are allowed",
    }
};

$("#DoctorForm").validate({
    rules: validationRules,
    messages: validationMessages,
    submitHandler: function(form) {
        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: "/admin/doctor/save",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 1) {
                    $('#DoctorTable').DataTable().ajax.reload();
                    $('#Add_doctors_details').modal('hide');
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        });
        return false;
    }
});

$(document).on("click", "#delete_doctor", function() {
    let id = $(this).data("id");
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "/admin/doctor/delete",
                data: {
                    _token: $("[name='_token']").val(),
                    id: id,
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        $('#DoctorTable').DataTable().ajax.reload();
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
    });
});

$(document).on('click', '#edit_doctor', function() {
    let id = $(this).data('id');
    $.ajax({
        type: "GET",
        url: "/admin/doctor/edit",
        data: { id: id },
        success: function(response) {
            if (response.status == 1) {
                let doctordata = response.doctor_data;
                $('#hid').val(doctordata.id);
                $('#name').val(doctordata.name);
                $('#specialization').val(doctordata.specialization);
                $('#old_image').val(doctordata.image || "");
                if (doctordata.image) {
                    $('#image_preview').html(`<img src="${doctordata.image}" alt="Image" width="100" height="100" class="mb-2">`);
                } else {
                    $('#image_preview').html('<span class="text-muted">No Image</span>');
                }
                $('#Add_doctors_details').modal('show');
                $("#modal_title").html("Edit Doctor");
            }
        }
    });
});
