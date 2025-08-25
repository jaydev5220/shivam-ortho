$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#roletable').DataTable().ajax.reload();
    $('#roletable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/rolelist', // This URL should return data in JSON format
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
            },
            dataSrc: function(json) {
                console.log(json); // Check the structure of the returned JSON
                return json.data; // Ensure that 'data' is the correct property
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
        ]
    });
    /* $('#exampleModal').on('hidden.bs.modal', function() {
        $('#productform')[0].reset(); // Reset the form when modal is closed
        $('#productform').find('input[type="hidden"]').val(''); // Clear hidden inputs
        $('#exampleModalLabel').text('Add Category');
        $('#categorysave').val('Submit')
        $('.text-danger').text('');
    });
*/
    $("#saverole").on("click", function(e) {
        e.preventDefault();
        let formname = document.getElementById('roleform');
        let FormDataPass = new FormData(formname);
        FormDataPass.append('_token', $('meta[name="csrf-token"]').attr('content'));
        console.log("FormDataPass", FormDataPass);
        $.ajax({
            url: "/admin/addrole",
            method: 'POST',
            contentType: false, // Necessary for FormData
            processData: false,
            data: FormDataPass,
            success: function(response) {
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    backdrop: true
                });
                $('#roletable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                $('.text-danger').text('');
                if (errors) {
                    if (errors.name) $('.error-name').text(errors.name[0]);
                    if (errors.status) $('.error-status').text(errors.status[0]);
                }
                //$('.text-danger').text('');
            }
        });
    });
});