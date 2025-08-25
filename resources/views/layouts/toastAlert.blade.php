<!-- Include Toastr CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Display Toast Alert -->
<script>
    $(document).ready(function () {
        // Check if toast message exists in session and display it
        @if(session('toastMessage'))
            var toastMessage = @json(session('toastMessage'));
            toastr[toastMessage.type](toastMessage.message);
        @endif
    });
</script>
