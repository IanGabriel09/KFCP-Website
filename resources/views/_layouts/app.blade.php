<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kou Fu Color Printing Corporation</title>

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Data AOS stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <style></style>

</head>
<body class="bg-light">
    <div class="page-wrapper d-flex flex-column min-vh-100">
        <nav id="mainNavbar" class="navbar navbar-expand-lg bg-light custom-box-shadow z-10 fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('page_images/KouFu_Logo.webp') }}" alt="Logo" width="250" height="100" class="img-fluid">
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link lead text-muted {{ request()->routeIs('home') ? 'active-nav' : '' }}" aria-current="page" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link lead text-muted {{ request()->routeIs('pages.about') ? 'active-nav' : '' }}" href="{{ route('pages.about') }}">About Us</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link lead text-muted dropdown-toggle {{ request()->routeIs('pages.food', 'pages.industrial') ? 'active-nav' : '' }}" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Products
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item {{ request()->routeIs('pages.food') ? 'active-nav' : '' }}" href="{{ route('pages.food') }}">Food Packaging</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item {{ request()->routeIs('pages.industrial') ? 'active-nav' : '' }}" href="{{ route('pages.industrial') }}">Industrial Packaging</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link lead text-muted {{ request()->routeIs('pages.inquiry') ? 'active-nav' : '' }}" href="{{ route('pages.inquiry') }}">Inquiry</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link lead text-muted {{ request()->routeIs('pages.careers', 'pages.careers.get', 'pages.careers.viewSm', 'pages.careers.form') ? 'active-nav' : '' }}" href="{{ route('pages.careers') }}">Careers</a>
                        </li>
                    </ul>
    
                    <a href="{{ route('pages.inquiry') }}" class="btn btn-theme"><i class="fa-solid fa-phone"></i> Contact us</a>
                </div>
            </div>
        </nav>
        
        <main class="">
            @yield('content')
        </main>
    
        <footer class="p-0 mt-5">
            <div class="bg-theme-light">
                <div class="container p-0">
                    <div class="bg-theme-light p-4">
                        <div class="row">
                            <!-- About -->
                            <div class="col-lg-6 col-md-12 mb-3 px-3">
                                <h3 class="color-offset"><i class="fas fa-info-circle me-2"></i>About</h3>
                                <p class="lead text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum consectetur quisquam reprehenderit dolorum ex laudantium architecto similique numquam cumque! Suscipit sapiente facilis, at consectetur laboriosam harum eaque eos! Neque, molestiae.</p>
                            </div>

                            <!-- Quick Links -->
                            <div class="col-lg-3 col-md-12 mb-5 px-3">
                                <h3 class="color-offset"><i class="fas fa-link me-2"></i>Quick Links</h3>
                                <div><a href="" class="text-white"><i class="fas fa-home me-1"></i> Home</a></div>
                                <div><a href="" class="text-white"><i class="fas fa-users me-1"></i> About Us</a></div>
                                <div><a href="" class="text-white"><i class="fas fa-envelope me-1"></i> Inquiry</a></div>
                                <div><a href="" class="text-white"><i class="fas fa-briefcase me-1"></i> Careers</a></div>
                            </div>

                            <!-- Open Hours -->
                            <div class="col-lg-3 col-md-12 mb-3 px-3">
                                <h3 class="color-offset"><i class="fas fa-clock me-2"></i>Open Hours</h3>
                                <div class="w-100 d-flex justify-content-between">
                                    <div>
                                        <p class="text-white"><i class="fas fa-calendar-day me-1"></i> Mon - Fri</p>
                                    </div>
                                    <div>
                                        <p class="text-white">8am - 5pm</p>
                                    </div>
                                </div>
                                <hr class="text-white">
                                <div class="w-100 d-flex justify-content-between">
                                    <div>
                                        <p class="text-white"><i class="fas fa-calendar-day me-1"></i> Sat - Sun</p>
                                    </div>
                                    <div>
                                        <p class="text-white">8am - 5pm</p>
                                    </div>
                                </div>
                                <hr class="text-white">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Copyright -->
                <div class="bg-theme py-2 text-center">
                    <p class="text-white"><i class="fas fa-copyright me-1"></i>Copyright MIS - Kou Fu Color Printing. All Rights Reserved</p>
                </div>
            </div>
        </footer>

    </div>

    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js" integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous"></script>
    
    <!-- Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- AOS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts')

</body>
</html>

<!-- Developed by Ian Gabriel Durian of Kou Fu color printing MIS Department -->

