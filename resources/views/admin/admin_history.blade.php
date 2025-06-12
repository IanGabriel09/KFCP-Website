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
                            <li>You can use the filter search functionality and date filter above the table to help locate an applicant that was rejected.</li>
                            <li>Applications History page can have duplicate multiple instances of the same person applying for the same position since its only a history viewing page.</li>
                            <hr>
                            <p><i>Note: The only purpose of this page is that so HR Recruitment can still access the past rejected applications for future references.</i></p>
                            <p><i>The other pages such as Initial, Pending, and For-Interview cannot have duplicate data</i></p>
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

    <h2 class="mb-4">Applications History</h2>

    <!-- Unified Filter Form -->
    <form method="GET" action="#">
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

            <!-- Updated At Date Filter -->
            <div class="col-md-6 mb-2">
                <div class="d-inline-flex float-lg-end float-md-start">
                    <input type="date" name="updated_date" class="form-control"
                        value="{{ request('updated_date') }}" onchange="this.form.submit()">
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
                    <th>Interview Date</th>
                    <th>Submitted</th>
                    <th>CV Link</th>
                    <th>Action</th>
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
                        <td>
                            @if ($applicant->interview_date)
                                {{ \Carbon\Carbon::parse($applicant->interview_date)->format('F j, Y') }}
                                <br>
                                {{ \Carbon\Carbon::parse($applicant->interview_date)->format('g:i A') }}
                            @else
                                No Interview set
                            @endif
                        </td>

                        <td>{{ $applicant->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ $applicant->cv_drive_name }}" target="_blank" class="btn btn-outline-info">
                                <i class="fa-solid fa-file"></i> View CV
                            </a>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.history.delete') }}" method="POST">
                                @csrf
                                <input type="text" name="applicationID" hidden value="{{ $applicant->application_id }}">
                                <input type="submit" class="btn btn-danger" value="delete">
                            </form>
                        </td>
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
        {{ $applicants->appends(request()->only(['search', 'updated_date']))->links() }}
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
