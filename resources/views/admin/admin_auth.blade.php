<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Custom styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>KFCP Website - Admin</title>
</head>
<body class="bg-light">
    <div class="container">
        <div class="h-100 d-flex justify-content-center align-items-center">
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="custom-box-shadow bg-white p-5 bg-white rounded auth-form"> 
                    <div class="text-center">
                        <img src="{{ asset('page_images/KoufuLogo.webp') }}" alt="" class="img-fluid" width="75" height="75">
                    </div>

                    <h3 class="text-center fw-bold">Admin Sign In</h3>
                    <div class="mb-3">
                        <label for="">Username:</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Password:</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <!-- Display session messages (success, error, etc.) -->
                    @if (session('message'))
                        <p class="text-success"><i>{{ session('message') }}</i></p>
                    @endif

                    <!-- Display centralized error message -->
                    @if ($errors->has('message'))
                        <p class="text-danger"><i>{{ $errors->first('message') }}</i></p>
                    @endif

                    <div class="mb-3 text-center">
                        <input type="submit" class="btn btn-theme">
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>