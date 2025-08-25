$(document).ready(function () {
    $('#title').on('input', function () {
        var title = $(this).val();
        var slug = slugify(title);
        $('#url').val(slug);
    });

    function slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    cmslisting();
    CKEDITOR.replace('description');

    $(document).on("click", "#cms", function () {
        $("#cmsmodal").modal("show");
    });

    $("#cmsForm").validate({
        rules: {
            title: "required",
            url: {
                remote: {
                    url: BASE_URL + '/admin/cms/check-slug',
                    type: "POST",
                    data: {
                        slug: function () {
                            return $("#url").val();
                        },
                        id: function () {
                            return $("#hid").val();
                        }
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataFilter: function (data) {
                        var json = JSON.parse(data);
                        if (json.exists == true) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                }
            },
            message: {
                required: true
            },
        },
        messages: {
            title: "This field is required",
            message: {
                required: "This field is required"
            },
            url: {
                remote: "Slug already exists"
            }
        },
        submitHandler: function () {
            var formData = new FormData($("#cmsForm")[0]);
            let description = CKEDITOR.instances.description.getData();

            const dataWithoutPTags = description.replace(/<p[^>]*>/g, '').replace(/<\/p>/g, '');

            formData.append("description", dataWithoutPTags);

            $.ajax({
                url: BASE_URL + '/admin/cms/save',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.status == 0) {
                        $("#cmsmodal").modal("hide");
                        CKEDITOR.instances.description.setData("");
                        Swal.fire({
                            title: response.message,
                            icon: "success"
                        });
                        $("#cmsForm")[0].reset();
                        $("#hid").val("");
                        $('#cmsTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            title: response.message,
                            icon: "warning"
                        });
                    }

                }
            })
        }
    });


    $("#cmsmodal").on("hidden.bs.modal", function () {
        $('#cmsForm').trigger("reset");
        $("#hid").val("");
        $("#title").val("");
        CKEDITOR.instances.description.setData("");
        $("#cmsForm").validate().resetForm();
    });

    $(document).on("click", "#cmsEdit", function () {
        let id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: "/admin/cms/edit/" + id,
            data: {
                id: id
            },
            success: function (response) {
                if (response?.status == 1) {
                    if (response?.cms_data) {
                        $("#cmsmodal").modal("show");
                        $("#hid").val(response?.cms_data?.id);
                        $("#title").val(response?.cms_data?.title);
                        CKEDITOR.instances.description.setData(response?.cms_data
                            ?.description);
                        $("#url").val(response?.cms_data?.slug);
                        $("#status").val(response?.cms_data?.status);
                        $("#meta_title").val(response?.cms_data?.meta_title);
                        $("#meta_description").val(response?.cms_data?.meta_description);
                        $("#meta_keyword").val(response?.cms_data?.meta_keyword);

                    }
                }
            }
        });
    })

    $(document).on("click", "#cmsDelete", function () {
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
                    type: "DELETE",
                    url: "/admin/cms/delete/" + id,
                    data: {
                        id: id,
                        _token: $("[name='_token']").val(),
                    },
                    success: function (response) {
                        if (response?.status == 1) {
                            Swal.fire({
                                title: response?.title,
                                text: response?.text,
                                icon: response?.icon
                            });
                            $('#cmsTable').DataTable().ajax.reload();
                        }
                    }
                });

            }
        });
    });
})

function cmslisting() {
    $("#cmsTable").DataTable({
        searching: true,
        paging: true,
        pageLength: 10,
        ajax: {
            type: "POST",
            url: BASE_URL + "/admin/cms/list",
            data: {
                _token: $("[name='_token']").val(),
            },
        },
        columns: [{
            data: "id",
            name: "id"
        },
        {
            data: "title",
            name: "title"
        },
        {
            data: "slug",
            name: "slug"
        },
        {
            data: "status",
            name: "status"
        },
        {
            data: "action",
            name: "action",
            orderable: false
        },
        ]
    });
}