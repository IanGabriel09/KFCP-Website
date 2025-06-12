@extends('_layouts.admin')

@section('content')
<!-- Fixed Spinner with Loading Text -->
<div class="custom-blur-overlay" id="blurOverlay"></div>
<div class="custom-fixed-spinner" id="loadingSpinner">
    <div class="spinner-grow color-theme" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<div class="container mt-5">

    <!-- Toggle Help Button -->
    <button class="btn text-info mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#helpBox" aria-expanded="false" aria-controls="helpBox">
        <i class="fas fa-question-circle"></i> Help
    </button>

    <!-- Floating Help Section -->
    <div class="position-fixed p-3" style="z-index: 1080;">
        <div class="d-flex flex-column align-items-end">
            <div class="collapse text-start" id="helpBox" style="width: 400px;">
                <div class="card border-info">
                    <div class="card-body">
                        <h6 class="card-title">How to use:</h6>
                        <ul class="mb-0 ps-3 small">
                            <li>You can use the filter search functionality above the table to help locate an applicant</li>
                            <hr>
                            <li>Sending initial interview invitation means the applicant has passed in the initial screen tests as well as already filled up the google forms application form. The interview shall be conducted face-to-face on KFCP premises. (Sends an email to applicant with the chosen date and time)</li>
                            <li>Rejecting an applicant moves them to history, where you can still view it anytime before it is automatically deleted after 3 months. (Sends an email to applicant that they have been rejected but will keep their info and CV as reference for future positions.)</li>
                            <li>Deleting permanently removes the record with no trace. (Sends an email to applicant that their application was not picked.)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div aria-live="polite" aria-atomic="true"
        class="position-fixed start-50 translate-middle-x p-3"
        style="top: 60px; z-index: 1100;">
        @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @elseif (session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <h2 class="mb-4">Pending Applications</h2>

    <!-- Unified Filter Form -->
    <form method="GET" action="{{ route('admin.pending.applicants') }}">
        <div class="row mb-3">
            <!-- Search Input -->
            <div class="col-md-6 mb-2">
                <div class="d-inline-flex">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Last name or email" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa-solid fa-search"></i> Search
                        </button>
                    </div>
                </div>

            </div>

            <!-- Position Dropdown -->
            <div class="col-md-6 mb-2">
                <div class="d-inline-flex float-lg-end float-md-start">
                    <select name="position" class="form-select float-lg-end float-md-start" onchange="this.form.submit()">
                        <option value="">All Positions</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>
                                {{ $pos }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>

    <!-- Applicants Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>N0.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Position</th>
                    <th>Submitted</th>
                    <th>CV Link</th>
                    <th>Actions</th>
                    <th>Confirm Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applicants as $applicant)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $applicant->first_name }} {{ $applicant->last_name }}</td>
                        <td>{{ $applicant->email }}</td>
                        <td>{{ $applicant->contact }}</td>
                        <td>{{ $applicant->selected_position }}</td>
                        <td>{{ $applicant->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ $applicant->cv_drive_name }}" target="_blank" class="btn btn-outline-info">
                                <i class="fa-solid fa-file"></i> View CV
                            </a>
                        </td>
                        <form method="POST" action="{{ route('admin.pending.applicants.action') }}">
                            @csrf
                            <td>
                                <input type="text" name="applicationID" value="{{ $applicant->application_id }}" readonly hidden>

                                <select name="selectedAction" class="form-select action-select" required>
                                    <option selected disabled value="">Choose</option>
                                    <option value="for-interview">Send Initial Interview Invitation</option>
                                    <option value="reject">Reject</option>
                                    <option value="delete">Delete Permanently</option>
                                </select>

                                <!-- Date picker shown conditionally -->
                                <input type="datetime-local" name="interviewDate" class="form-control mt-2 interview-date d-none" />
                            </td>
                            <td class="text-center">
                                <input type="submit" value="Submit" class="btn btn-dark submit-btn">
                            </td>
                        </form>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No applicants found.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $applicants->appends(request()->only(['search', 'position']))->links() }}
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
    
    // Handle showing/hiding interview date field based on selected action
    $('.action-select').on('change', function () {
        const selectedValue = $(this).val();
        const dateInput = $(this).siblings('.interview-date');

        if (selectedValue === 'for-interview') {
            dateInput.removeClass('d-none').attr('required', true);
        } else {
            dateInput.addClass('d-none').removeAttr('required');
        }
    });

    $(document).ready(function () {

    });
</script>
@endsection
