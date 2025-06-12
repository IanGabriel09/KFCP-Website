@extends('_layouts.app')

@section('content')
<br>
<div class="container mt-5">
    <div class="row">
        <!-- Products List -->
        <div class="col-12">
            <div class="text-center">
                <h3 class="fs-heading2 color-theme mb-3">Industrial Packaging</h3>
            </div>

            <div class="row d-flex justify-content-center">
                @forelse($products as $index => $product)
                    <div class="col-lg-3 col-md-6 col-sm-12" data-aos="fade-up" data-aos-delay="{{ min($index * 100, 400) }}">
                        <div class="product-card card mb-4 position-relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('/page_images/products_img/industrial_img/' . $product->image) }}" class="card-img-industrial card-img-top" alt="{{ $product->name }}">
                            @endif
                        
                            <div class="card-body position-relative">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">${{ number_format($product->price, 2) }}</p>
                                <p class="card-text"><small class="text-muted">Category: {{ $product->category->name }}</small></p>
                            
                                <!-- Toggle Button -->
                                <button type="button" class="btn btn-sm btn-link text-primary p-0 see-description-btn">
                                    See Description
                                </button>
                            
                                <!-- Overlay -->
                                <div class="description-overlay position-absolute h-100 bg-white p-3 border" style="top: 0; left: 0; right: 0; display: none; z-index: 10;">
                                    <p>{{ $product->description ?? 'No description available.' }}</p>
                                    <button class="btn btn-sm btn-outline-secondary close-overlay-btn">Close</button>
                                </div>
                            </div>
                            
                            
                        
                            <div class="text-center mb-3 mt-3">
                                <a href="{{ route('redirect.inquiry', ['productName' => $product->name]) }}" class="btn btn-theme-outline">
                                    Send Inquiry <i class="fa-solid fa-paper-plane"></i>
                                </a>
                            </div>
                        </div>
                        
                        
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No products found for this selection.
                        </div>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.see-description-btn').on('click', function () {
            // Hide any other open overlays first
            $('.description-overlay').hide();
            
            // Show the current overlay
            $(this).siblings('.description-overlay').fadeIn(200);
        });

        $('.close-overlay-btn').on('click', function () {
            $(this).closest('.description-overlay').fadeOut(200);
        });
    });
</script>


@endsection
