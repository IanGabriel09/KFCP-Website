@extends('_layouts.app')

@section('content')
<br>
<div class="container mt-5">
    <div class="row">
        <!-- Sidebar: Category List -->
        <div class="col-md-3">
            <div class="sticky-top mb-3" style="top: 125px;">
                <div class="custom-box-shadow card border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fa fa-list-ul me-2"></i>Categories</h5>
                    </div>
                    <div class="card-body p-0" style="max-height: 70vh; overflow-y: auto;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-3 {{ request('category') == null ? 'bg-theme text-white' : '' }}">
                                <a href="{{ route('pages.food', ['sort' => request('sort')]) }}"
                                   class="text-decoration-none d-flex align-items-center {{ request('category') == null ? 'text-white fw-bold' : 'text-dark fw-semibold hover-highlight' }}">
                                    <i class="fa fa-th-large me-2 {{ request('category') == null ? 'text-white' : 'text-secondary' }}"></i> All Products
                                </a>
                            </li>
                            
                            @foreach($categories as $category)
                                <li class="list-group-item p-3 {{ request('category') == $category->uuid ? 'bg-theme text-white' : '' }}">
                                    <a href="{{ route('pages.food', array_filter([
                                        'category' => $category->uuid,
                                        'sort' => request('sort'),
                                    ])) }}"
                                       class="text-decoration-none d-flex align-items-center {{ request('category') == $category->uuid ? 'text-white fw-bold' : 'text-dark fw-semibold hover-highlight' }}">
                                        <i class="fa fa-tag me-2 {{ request('category') == $category->uuid ? 'text-white' : 'text-secondary' }}"></i> {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Products List -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fs-heading2 color-theme mb-0">Food Packaging</h3>

                <!-- Sort Dropdown -->
                <form method="GET" action="{{ route('pages.food') }}">
                    {{-- Uncomment if problem occured --}}
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif

                    <select name="sort" class="form-select" style="width: 200px;" onchange="this.form.submit()">
                        <option value="">-- Sort By --</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    </select>
                </form>
            </div>

    <!-- Product Placeholder Wrapper -->
    <div id="product-loading" class="row">
        @for ($i = 0; $i < 6; $i++)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card placeholder-wave">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg"
                        role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#dee2e6"></rect>
                    </svg>

                    <div class="card-body">
                        <h5 class="card-title">
                            <span class="placeholder col-6"></span>
                        </h5>
                        <p class="card-text">
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                        </p>
                        <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <!-- Actual Product Content -->
    <div id="product-list" class="row d-none">
        @foreach($products as $index => $product)
            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ min($index * 100, 400) }}">
                <div class="product-card card mb-4 position-relative overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('/page_images/products_img/food_img/' . $product->image) }}" class="card-img card-img-top" alt="{{ $product->name }}">
                    @endif
                
                    <div class="card-body position-relative">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">${{ number_format($product->price, 2) }}</p>
                        <p class="card-text"><small class="text-muted">Category: {{ $product->category->name }}</small></p>
                    
                        <button type="button" class="btn btn-sm btn-link text-primary p-0 see-description-btn">
                            See Description
                        </button>
                    
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
        @endforeach
    </div>


            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    window.addEventListener('load', function () {
        // Hide placeholders
        document.getElementById('product-loading').classList.add('d-none');

        // Show actual products
        document.getElementById('product-list').classList.remove('d-none');
    });

    $(document).ready(function () {
        $('.see-description-btn').on('click', function () {
            $('.description-overlay').hide();
            $(this).siblings('.description-overlay').fadeIn(200);
        });

        $('.close-overlay-btn').on('click', function () {
            $(this).closest('.description-overlay').fadeOut(200);
        });
    });
</script>
@endsection
