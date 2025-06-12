@extends('_layouts.admin')

@section('content')
<!-- Fixed Spinner with Loading Text -->
<div class="custom-blur-overlay" id="blurOverlay"></div>
<div class="custom-fixed-spinner" id="loadingSpinner">
    <div class="spinner-grow color-theme" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>


<div class="container mt-5 mb-5">
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
                        <h6 class="card-title">Reminder:</h6>
                        <ul class="mb-0 ps-3 small">
                            <li>Please keep in mind that deleting a position will also permanently remove all applications associated with that position. This action cannot be undone, and any candidate data that is linked to the position will be lost.</li>
                            <li>If a position is deleted and applications are currently existing with said deleted position, there will be no email notification to the applicants who applied for the position.</li>
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

    <div class="row">
        <div class="col-lg-5 col-md-12">
            <div class="custom-box-shadow rounded bg-white p-3">
                <h1 class="mb-3">Upload position</h1>
                <hr>
                <form action="{{ route('admin.position.store') }}" method="POST" class="">
                    @csrf
                    <div class="p-3 overflow-y-auto" style="max-height: 600px;">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="">Position Name:</label>
                                <input type="text" id="position" name="position" class="form-control rounded-0" required>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label for="">Job-Type:</label>
                                <select name="jobType" id="jobType" class="form-select rounded-0" required>
                                    <option selected disabled value="">--Select--</option>
                                    <option value="Full-Time">Full-Time</option>
                                    <option value="Part-Time">Part-Time</option>
                                    <option value="Contract">Contract</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label for="">Number of Candidates:</label>
                                <select name="positionQuantity" id="positionQuantity" class="form-select rounded-0" required>
                                    <option selected disabled value="">--Select--</option>
                                    <option value="Single">Single</option>
                                    <option value="Multiple">Multiple</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Job Description:</label>
                                <textarea id="jobDescription" name="jobDescription" class="form-control rounded-0" rows="10" required></textarea>
                            </div>

                            <div class="col-12 border p-3">
                                <h3>Qualifications</h3>
                                <div id="qualifications-wrapper">
                                    <div class="qualification-field mb-2" id="qualifications1">
                                        <input type="text" name="qualifications[qual1]" class="form-control rounded-0" placeholder="Qualification 1" required>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addQualification">Add Qualification</button>
                            </div>

                            <div class="col-12 border p-3 mt-3">
                                <h3>Benefits</h3>
                                <div id="benefits-wrapper">
                                    <div class="benefit-field mb-2" id="benefits1">
                                        <input type="text" name="benefits[ben1]" class="form-control rounded-0" placeholder="Benefit 1" required>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-success mt-2" id="addBenefit">Add Benefit</button>
                            </div>

                        </div>
                    </div>

                    <div class="text-center">
                        <hr>
                        <input type="submit" class="btn btn-primary" value="Post Position">
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7 col-md-12">
            <div class="custom-box-shadow rounded bg-white p-3">
                <h1 class="mb-3">Posted Positions</h1>
                <hr>
                <div class="p-3 overflow-y-auto" style="max-height: 615px;">
                    @forelse ($positions as $position)
                    <form action="{{ route('admin.position.delete', ['uid' => $position->UID]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="border p-3">
                            <p>Position ID: {{ $position->UID }}</p>
                            @if($position->pos_quantity === 'Multiple')
                                <p class="lead text-success fw-bold">*Hiring Multiple Candidates*</p>
                            @endif
                            <h3>{{ $position->pos_name }}</h3>
                            <p>Date Posted: {{ $position->created_at }}</p>
                            <p>Job Type: {{ $position->job_type }}</p>
                            <hr>
                            <div class="text-center">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </div>
                        </div> 
                    </form>


                    @empty
                        <div class="text-center alert alert-danger">
                            <h5>No Open-Positions as of now</h5>
                        </div>
                    @endforelse
                    </div>

            </div>
        </div>
    </div>


</div>
@endsection

@section('scripts')
<script>
    let qualificationCount = 1;
    let benefitCount = 1;

    $('#addQualification').on('click', function () {
        qualificationCount++;
        const key = `qual${qualificationCount}`;
        const newField = $(`
            <div class="qualification-field mb-2" id="qualifications${qualificationCount}">
                <input type="text" name="qualifications[${key}]" class="form-control rounded-0" placeholder="Qualification ${qualificationCount}" required>
            </div>
        `);
        $('#qualifications-wrapper').append(newField);
    });

    $('#addBenefit').on('click', function () {
        benefitCount++;
        const key = `ben${benefitCount}`;
        const newField = $(`
            <div class="benefit-field mb-2" id="benefits${benefitCount}">
                <input type="text" name="benefits[${key}]" class="form-control rounded-0" placeholder="Benefit ${benefitCount}" required>
            </div>
        `);
        $('#benefits-wrapper').append(newField);
    });

    // Show loader when submitting
    $('form').on('submit', function (e) {
        const isDeleteForm = $(this).find('input[type=submit]').val() === 'Delete';
        if (isDeleteForm) {
            const confirmed = confirm("Are you sure you want to delete this position? Make sure to read the Help section at the top left of the page.");
            if (!confirmed) {
                e.preventDefault(); // Cancel the form submission
                return;
            }
        }

        $('body').addClass('loading');
        $('#loadingSpinner').show();
        $('#blurOverlay').show();
    });

    $(document).ready(function () {
        console.log(@json($positions));
    });
</script>
@endsection



