<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <span id="toastText">{{ session('message') }}</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let toastEl = document.getElementById("toastMessage");
        let toastText = document.getElementById("toastText");

        @if (session('message'))
            @if (session('type') === 'success')
                toastEl.classList.add('bg-success');
            @elseif (session('type') === 'error')
                toastEl.classList.add('bg-danger');
            @endif

            new bootstrap.Toast(toastEl).show();
        @endif
    });
</script>
