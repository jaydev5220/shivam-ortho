$(document).ready(function() {

    // Initialize CKEditor
    CKEDITOR.replace('description', {
        allowedContent: true,
        versionCheck: false,
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#hid").val("");

    $("#Add_courses_details").on("hidden.bs.modal", function() {
        $("#CourseForm")[0].reset();
        $("#hid").val("");
        $("#CourseForm").validate().resetForm();
        $("#status").val("").change();
        $("#CourseForm").find('.error').removeClass('error');
        CKEDITOR.instances.description.setData("");
        $("#oldimgbox").hide();
        $('.password-container').show();
    });

    if ($.fn.DataTable.isDataTable('#CourseTable')) {
        $('#CourseTable').DataTable().destroy();
    }

    $('#CourseTable').dataTable({
        searching: true,
        paging: true,
        pageLength: 10,

        "ajax": {
            url: "/admin/courselist", // Correct route for fetching course data
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $("[name='_token']").val(), // CSRF Token for security
            },
        },
        columns: [{
                data: "title", // Course Title
            },
            {
                data: "short_description", // Short Description
            },
            {
                data: "thumbnail", // Thumbnail (Image Display)
                orderable: false,
                searchable: false
            },
            {
                data: "video", // Video Link or Button
                orderable: false,
                searchable: false
            },
            {
                data: "action", // Action Buttons
                orderable: false,
                searchable: false
            }
        ],
    });

    $('#loader-container').hide();
})

$(document).on('click', '#Add_courses', function() {
    $('#Add_courses_details').modal('show');
    $("#CourseForm").find('.form-control').removeClass('error');
    $("#CourseForm").find('.error').remove();
    $("#modal_title").html("");
    $("#modal_title").html("Add Course");
    $("#modal_title").html("Add Course");
});

var validationRules = {
    title: {
        required: true,
        maxlength: 191
    },
    short_description: {
        required: true,
        maxlength: 255
    },
    thumbnail: {
        required: function() {
            return $('#hid').val() === ""; // Required only for new courses
        },
        extension: "jpg|jpeg|png|gif" // Only image file types allowed
    },
    description: {
        required: true
    },
    video: {
        required: function() {
            return $('#hid').val() === ""; // Required only for new courses
        },
        extension: "mp4|mov|avi", // Ensures only video file types are accepted
    }
};

var validationMessages = {
    title: {
        required: "Please enter the course title",
        maxlength: "Title cannot exceed 191 characters",
    },
    short_description: {
        required: "Please enter a short description",
        maxlength: "Short description cannot exceed 255 characters",
    },
    thumbnail: {
        required: "Please upload a thumbnail image",
        extension: "Only JPG, JPEG, PNG, or GIF formats are allowed",
    },
    description: {
        required: "Please enter the course description",
    },
    video: {
        required: "Please upload a course video",
        extension: "Only MP4, MOV, or AVI formats are allowed",
    }
};


$('form[id="CourseForm"]').validate({
    rules: validationRules,
    messages: validationMessages,

    submitHandler: function() {
        var formData = new FormData($("#CourseForm")[0]);
        let description = CKEDITOR.instances.description.getData();
        const dataWithoutPTags = description.replace(/<p[^>]*>/g, '').replace(/<\/p>/g, '');
        formData.append("description", dataWithoutPTags);
        $('#loader-container').show();
        $.ajax({
            url: BASE_URL + '/admin/course/save',
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
                        CKEDITOR.instances.description.setData("");
                        $('#Add_courses_details').modal('hide');
                    } else {
                        toastr.error(data.message);
                        $('#loader-container').hide();
                    }
                }
                $("#CourseForm")[0].reset();
                $("#CourseForm").validate().resetForm();
                $("#CourseForm").find('.error').removeClass('error');
                $('#CourseTable').DataTable().ajax.reload();
            }
        });
    },
});

$(document).on('click', '#edit_course', function() {
    var id = $(this).data("id");

    $.ajax({
        type: "GET",
        url: "/admin/course/edit",
        data: {
            _token: $("[name='_token']").val(),
            id: id,
        },
        success: function(response) {
            if (response.status == 1) {
                if (response.course_data) {
                    var coursedata = response.course_data;
                    console.log("coursedata", coursedata);
                    $('#Add_courses_details').modal('show');
                    $("#modal_title").html("Edit Course");

                    $('#hid').val(coursedata.id);
                    $('#title').val(coursedata.title);
                    $('#short_description').val(coursedata.short_description);
                    CKEDITOR.instances.description.setData(coursedata.description);
                    $('#old_thumbnail').val(coursedata.thumbnail || "");
                    $('#old_video').val(coursedata.video || "");

                    // Store Original URLs for reset
                    $('#thumbnail_preview').data('original', coursedata.thumbnail);
                    $('#video_preview').data('original', coursedata.video);

                    // === Thumbnail Handling ===
                    if (coursedata.thumbnail) {
                        $('#thumbnail_preview').html(`
                            <div class="position-relative">
                                <img src="${coursedata.thumbnail}" alt="Thumbnail" width="100" height="100" class="mb-2">
                            </div>
                        `);
                    } else {
                        $('#thumbnail_preview').html('<span class="text-muted">No Image</span>');
                    }

                    // === Video Handling ===
                    if (coursedata.video) {
                        $('#video_preview').html(`
                            <div class="position-relative">
                                <video width="200" height="150" controls>
                                    <source src="${coursedata.video}" type="video/mp4">
                                </video>
                            </div>
                        `);
                    } else {
                        $('#video_preview').html('<span class="text-muted">No Video</span>');
                    }
                }
            }
        }
    });
});

$('#thumbnail').on('change', function(e) {
    let file = e.target.files[0];
    if (file) {
        $('#thumbnail_preview').html(`
            <div class="position-relative">
                <img src="${URL.createObjectURL(file)}" alt="New Thumbnail" width="100" height="100" class="mb-2">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" id="cancel_thumbnail">
                    ×
                </button>
            </div>
        `);
    }
});

// === New Video Upload Preview (Temporary Preview) ===
$('#video').on('change', function(e) {
    let file = e.target.files[0];
    if (file) {
        $('#video_preview').html(`
            <div class="position-relative">
                <video width="200" height="150" controls>
                    <source src="${URL.createObjectURL(file)}" type="video/mp4">
                </video>
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" id="cancel_video">
                    ×
                </button>
            </div>
        `);
    }
});

// === Cancel New Thumbnail Upload (Revert to Original) ===
$(document).on('click', '#cancel_thumbnail', function() {
    const originalThumbnail = $('#thumbnail_preview').data('original');
    $('#thumbnail_preview').html(originalThumbnail ?
        `<img src="${originalThumbnail}" alt="Thumbnail" width="100" height="100" class="mb-2">` :
        '<span class="text-muted">No Image</span>'
    );
    $('#thumbnail').val(""); // Clear file input
});

// === Cancel New Video Upload (Revert to Original) ===
$(document).on('click', '#cancel_video', function() {
    const originalVideo = $('#video_preview').data('original');
    $('#video_preview').html(originalVideo ?
        `<video width="200" height="150" controls>
              <source src="${originalVideo}" type="video/mp4">
           </video>` :
        '<span class="text-muted">No Video</span>'
    );
    $('#video').val(""); // Clear file input
});


$(document).on("click", "#delete_course", function() {
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
                url: "/admin/course/delete",
                data: {
                    _token: $("[name='_token']").val(),
                    id: id,
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        $('#CourseTable').DataTable().ajax.reload();
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
    });
});