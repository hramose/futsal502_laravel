<!doctype html>
<html class="no-js" lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Alejandro Muralles Peña"/>
<link rel="stylesheet" href="{{ asset('assets/publico/css/bootstrap/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/color.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/responsive.css') }}">
<!-- FontsOnline -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800|Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<script src="{{ asset('assets/publico/js/vendor/modernizr.js')}}"></script>
@yield('css')
</head>
<body>
@yield('content')
<script src="{{ asset('assets/publico/js/vendor/jquery.js')}}"></script>
<script src="{{ asset('assets/publico/js/vendor/bootstrap.min.js')}}"></script>
@yield('js')
</body>
</html>
