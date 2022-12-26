<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/824/824727.png" />
    <link rel="stylesheet" href="{{ asset('bootstrap-5/css/bootstrap.min.css') }}">
</head>
<body>
    <style>
       
        .footer{
            background-color: pink;
        }
    </style>
    @section('sidebar')
       Navbar dari layout
       <hr>
    @show
    <div class="container">
        @yield('content')
        
    </div>
    <div class="footer">
        @yield('footer')
    </div>
    <script src="{{ asset('bootstrap-5/js/bootstrap.min.js') }}"></script>
</body>
</html>