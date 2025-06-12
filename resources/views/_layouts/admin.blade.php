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
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
    <style></style>

</head>
<body class="bg-light">
    <div class="navbar px-4 bg-white border shadow-sm z-index-2 position-fixed top-0 left-0 w-100">
        <div class="d-flex justify-content-between">
            <div class="navbar-brand d-flex align-items-center">
                <img src="{{ asset('page_images/KoufuLogo.webp') }}" alt="" class="img-fluid" width="50" height="50">
                <h3 class="my-0 mx-3">KFCP Admin</h3>
            </div>
        </div>
        <form action="{{ route('admin.logout') }}" method="GET">
            @csrf
            <button type="submit" class="text-muted btn"><i class="fa-solid fa-power-off"></i> Logout</button>
        </form>
    </div>

    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
                <li class="{{ request()->routeIs('admin.positions') ? 'active' : '' }}">
                    <a href="{{ route('admin.positions') }}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-briefcase fa-stack-1x"></i></span> Open Positions</a>
                </li>

                <li class="{{ request()->routeIs('admin.applicants') ? 'active' : '' }}">
                    <a href="{{ route('admin.applicants') }}"><span class="fa-stack fa-lg pull-left"><i class="fa-solid fa-user-group fa-stack-1x"></i></i></span>Initial Applications</a>
                </li>

                <li class="{{ request()->routeIs('admin.pending.applicants') ? 'active' : '' }}">
                    <a href="{{ route('admin.pending.applicants') }}"><span class="fa-stack fa-lg pull-left"><i class="fa-solid fa-hourglass-half fa-stack-1x"></i></i></span> Pending Applications</a>
                </li>

                <li class="{{ request()->routeIs('admin.for-interview') ? 'active' : '' }}">
                    <a href="{{ route('admin.for-interview') }}"><span class="fa-stack fa-lg pull-left"><i class="fa-solid fa-clipboard-user fa-stack-1x"></i></i></span> For Interview</a>
                </li>

                <li class="{{ request()->routeIs('admin.history') ? 'active' : '' }}">
                    <a href="{{ route('admin.history') }}"><span class="fa-stack fa-lg pull-left"><i class="fa-solid fa-clock-rotate-left fa-stack-1x"></i></i></span> Application History</a>
                </li>

                <li class="{{ request()->routeIs('admin.faq') ? 'active' : '' }}">
                    <a href="{{ route('admin.faq') }}"><span class="fa-stack fa-lg pull-left"><i class="fa-solid fa-circle-question fa-stack-1x"></i></span> FAQs</a>
                </li>


            </ul>

            <!-- Sidebar Footer -->
            <div class="sidebar-footer d-none d-md-block">
                <small>&copy; {{ date('Y') }} Kou Fu Printing Corp<br>v1.0</small>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>
        <!-- /#page-content-wrapper -->
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

