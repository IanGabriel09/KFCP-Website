@extends('_layouts.app')

@section('content')
<!-- Background section -->
<section class="bg-section">
    <!-- You can add a heading or content here if needed -->
</section>

<!-- Fixed Spinner with Loading Text -->
<div class="custom-blur-overlay" id="blurOverlay"></div>
<div class="custom-fixed-spinner" id="loadingSpinner">
    <div class="spinner-grow color-theme" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- Content -->
<section class="form-section mb-5">
    <div class="container">
        <div class="row bg-white mx-1 mb-5 custom-box-shadow" data-aos="fade-up">
            <div class="col-lg-6 col-md-12 p-4" data-aos="fade-up" data-aos-delay="100">
                <h3 class="color-theme">Send us a message</h3>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-0 left-border-success" role="alert">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-0 left-border-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('pages.inquiry.submit') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="row mt-3 mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label style="color: #acaaaa;">*Name</label>
                            <input type="text" name="name" class="form-control border-0 border-bottom rounded-0" placeholder="Your Name" required>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label style="color: #acaaaa;">*Email</label>
                            <input type="email" name="email" class="form-control border-0 border-bottom rounded-0" placeholder="Your Email" required>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label style="color: #acaaaa;">*Phone</label>
                            <input type="text" name="contact" class="form-control border-0 border-bottom rounded-0" placeholder="Your Phone No." required>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label style="color: #acaaaa;">*Subject</label>
                            <input type="text" name="subject" 
                                class="form-control border-0 border-bottom rounded-0" 
                                placeholder="Message Subject" 
                                name="subject"
                                value="{{ session('product_name') ? 'Inquiry for: ' . session('product_name') : '' }}" 
                                required>
                        </div>
                        

                        <div class="col-12">
                            <label style="color: #acaaaa;">*Message</label>
                            <textarea name="mssg" class="form-control border-0 border-bottom rounded-0" placeholder="Type your message here" rows="4" required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-theme">Send Message</button>
                </form>
            </div>

            <div class="col-lg-6 col-md-12 p-0" data-aos="fade-up" data-aos-delay="300">
                <iframe class="border h-100 w-100"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14608.891083990313!2d121.0151013!3d14.2899638!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d6395d343693%3A0xa194166d0396b739!2sKou%20Fu%20Color%20Printing%20Corporation!5e0!3m2!1sen!2sph!4v1695769685471!5m2!1sen!2sph">
                </iframe>
            </div>

        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
                <div class="text-center">
                    <i class="text-white bg-theme fa-solid fa-location-dot fs-2 p-4 py-3 rounded-circle mb-3"></i>
                    <p class="lead">Lots 6-7, Block 3, Phase 2, Mountview Industrial Complex, 4116 Carmona</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
                <div class="text-center">
                    <i class="text-white bg-theme fa-solid fa-phone fs-2 p-4 py-3 rounded-circle mb-3"></i>
                    <p class="lead m-0"><strong>Phone 1: </strong>02-85844947</p>
                    <p class="lead"><strong>Phone 2: </strong>02-85194658</p>
                </div>
            </div>

             <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
                <div class="text-center">
                    <i class="text-white bg-theme fa-solid fa-envelope fs-2 p-4 py-3 rounded-circle mb-3"></i>
                    <p class="lead"><strong>Email: </strong>koufu@koufuprinting.com</p>
                </div>
            </div>
        </div>
    </div>
</section>



  
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('form[action="{{ route('pages.inquiry.submit') }}"]').on('submit', function () {
            $('body').addClass('loading');
            $('#loadingSpinner').show();
            $('#blurOverlay').show();
        });
    });
</script>


@endsection



