@extends('_layouts.app')

@section('content')
<br><br>
<!-- Fixed Spinner with Loading Text -->
<div class="custom-blur-overlay" id="blurOverlay"></div>
<div class="custom-fixed-spinner" id="loadingSpinner">
    <div class="spinner-grow color-theme" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<div id="contentContainer" class="container mt-5">
    <div class="row">
        <!-- info section -->
        <div class="col-lg-6 col-md-12 mb-3" data-aos="fade-up">
            <div class="mb-5">
                <p class="text-muted">Looking for a Job?</p>
                <h1 class="fs-heading-outline color-theme">Join Our Team</h1>
                <p class="lead">Send us an application with your CV and let's talk about your skills!</p>
            </div>

            <!-- Company Overview -->
            <div class="mb-4">
                <h5 class="fw-bold">Why Koufu Printing?</h5>
                <p>At Koufu, we believe in empowering our team members, fostering creativity, and maintaining a healthy work-life balance. Join a workplace that values growth, teamwork, and innovation.</p>
            </div>

            <!-- Perks & Benefits -->
            <div class="mb-4">
                <h5 class="fw-bold">Perks & Benefits</h5>
                <ul class="list-unstyled">
                    <li><i class="fa-solid fa-check text-success me-2"></i> Competitive salary</li>
                    <li><i class="fa-solid fa-check text-success me-2"></i> Flexible working hours</li>
                    <li><i class="fa-solid fa-check text-success me-2"></i> Opportunities for career growth</li>
                    <li><i class="fa-solid fa-check text-success me-2"></i> Team building & learning programs</li>
                </ul>
            </div>

            <!-- Contact Email -->
            <div class="d-flex align-items-center mb-4">
                <div class="bg-theme text-white rounded-circle mx-3 p-3">
                    <i class="fa-regular fa-envelope fs-3"></i>
                </div>
                <div>
                    <p class="m-0 lead">E-mail</p>
                    <h5><i>koufu@koufuprinting.com</i></h5>
                </div>
            </div>
        </div>

        <!-- Form section -->
        <div class="col-lg-6 col-md-12" data-aos="fade-up" data-aos-delay="200">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-0 left-border-success" role="alert">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-0 left-border-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form id="careerForm" action="{{ route('pages.careers.form.submit') }}" method="POST" enctype="multipart/form-data" class="border p-3 rounded bg-white">
                @csrf
                <div class="row mb-2">
                    <div class="col-lg-6 col-md-12 mb-3">
                        <label for="name">First Name:</label>
                        <input type="text" name="fName" id="fName" class="form-control rounded-0" required>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-3">
                        <label for="name">Last Name:</label>
                        <input type="text" name="lName" id="lName" class="form-control rounded-0" required>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-3">
                        <label for="email">Email:</label>
                        <input type="text" name="email" id="email" class="form-control rounded-0" required>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-3">
                        <label for="contact">Phone Number:</label>
                        <input type="text" name="contact" id="contact" class="form-control rounded-0" required>
                    </div>

                    <div class="">
                        <input type="text" name="selectedPos" id="selectedPos" class="form-control rounded-0" value="{{ $selectedPosition->pos_name }}" required readonly hidden>
                        <input type="text" name="selectedPosId" id="selectedPosId" class="form-control rounded-0" value="{{ $selectedPosition->UID }}" required readonly hidden>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="subject">Subject:</label>
                        <input type="text" name="subject" id="subject" class="form-control rounded-0" value="Application for: {{ $selectedPosition->pos_name }}" required readonly>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="mssg">Message:</label>
                        <textarea name="mssg" id="mssg" rows="10" class="form-control rounded-0" required></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="">Upload your resume(PDF only):</label>
                        <input class="form-control rounded-0" type="file" id="cv" name="cv" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="terms" class="d-inline-block">
                            <input type="checkbox" name="terms" id="terms" required>
                            I agree to the following Terms and Conditions:
                        </label>
                        <p class="mt-2">
                            By submitting this form, you agree in receiving automated emails regarding your application from us.
                        </p>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-theme">Send Application</button>
                    </div>
                </div>
            </form>
            
            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#careerForm').on('submit', function (e) {
            $('body').addClass('loading');
            $('#loadingSpinner').show();
            $('#blurOverlay').show();
        });
    });
</script>

@endsection

