@extends('_layouts.admin')

@section('content')
<!-- Fixed Spinner with Loading Text -->
<div class="custom-blur-overlay" id="blurOverlay"></div>
<div class="custom-fixed-spinner" id="loadingSpinner">
    <div class="spinner-grow color-theme" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<br>
<div class="container mt-5">
    <div class="d-flex justify-content-center align-items-center">
        <div class="text-center">
            <img src="{{ asset('page_images/website-under-maintenance-5690953-4747761.gif') }}" alt="https://placehold.co/600x400" class="rounded">
            <h3 class="text-muted">FAQ Data Page is under development. Come back and check in another time :)</h3>
            <p><i class="text-muted lead fw-bold">"KFCP-MIS team"</i></p>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Use onsubmit to catch all future form submissions inside the table
    $('table').on('submit', 'form', function (e) {
        // `checkValidity()` triggers native validation checks
        if (!this.checkValidity()) {
            return true; // Let browser show validation messages
        }

        e.preventDefault(); // Pause actual submission

        // Confirm action
        if (confirm('Are you sure you want to perform this action?')) {
            // Show loading spinner and blur
            $('body').addClass('loading');
            $('#loadingSpinner').show();
            $('#blurOverlay').show();

            // Submit after confirmation
            this.submit();
        }
    });

    $(document).ready(function () {

    });
</script>
@endsection
