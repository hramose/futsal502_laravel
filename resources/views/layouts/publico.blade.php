<!doctype html>
<html class="no-js" lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Alejandro Muralles Peña"/>
<!-- Document Title -->
<title>Futsal 502 - @yield('title')</title>
<!-- StyleSheets -->
<link rel="stylesheet" href="{{ asset('assets/publico/css/bootstrap/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/icomoon.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/animate.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/transition.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/color.css') }}">
<link rel="stylesheet" href="{{ asset('assets/publico/css/responsive.css') }}">
<!-- FontsOnline -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800|Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<!-- JavaScripts -->
<script src="{{ asset('assets/publico/js/vendor/modernizr.js')}}"></script>
<link rel="shortcut icon" href="{{ asset('assets/imagenes/logos/ico.png') }}">
<style>
    html { 
  /*background: url({{asset('assets/imagenes/fondo.png')}}) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;*/
  background-color: #1c1c1c;

}
body{
    background: initial;
  }
</style>
@yield('css')


<!--GOOGLE ANALYTICS-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105071646-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- END GOOGLE ANALYTICS -->
</head>
<body>
<!-- Wrapper -->
<div class="wrap push">
    <!-- Header -->
    <header class="header style-3">
        <!-- Top bar -->
        <div class="topbar-and-logobar">
            <div class="container">
                <!-- Responsive Button -->
                <div class="responsive-btn pull-right">
                    <a href="#menu" class="menu-link"><i class="fa fa-bars"></i></a>
                </div>
                <!-- Responsive Button -->
                <!-- User Login Option -->
                <ul class="user-login-option pull-right">
                    <li class="social-icon">
                        <ul class="social-icons style-5">
                            <li><a class="facebook" target="_blank" href="http://facebook.com/futsal502"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="twitter" target="_blank" href="http://twitter.com/futsal502"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="youtube" target="_blank" href="http://youtube.com/futsal502"><i class="fa fa-youtube-play"></i></a></li>
                            <li><a class="instagram" target="_blank" href="http://instagram.com/futsal502"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </li>
                </ul>
                <!-- User Login Option -->                
            </div>  
        </div>
        <!-- Top bar -->

        <!-- Nav -->
        <div class="nav-holder">
            <div class="container">
                <div class="maga-drop-wrap">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="home-1.html"><img src="{{ asset('assets/imagenes/logos/logo_sm.png') }}"></a>
                    </div>
                    <!-- Logo -->
                    <!-- Nav List -->
                    <ul class="nav-list pull-right">
                        <li><a href="{{route('inicio')}}">Inicio</a></li>
                        <li><a href="{{route('posiciones',[1,0])}}">Posiciones</a></li>
                        <li><a href="{{route('calendario',[1,0])}}">Calendario</a></li>
                        <li><a href="{{route('plantilla',[1,0,0])}}">Plantillas</a></li>
                    </ul>
                    <!-- Nav List -->
                </div>
            </div>
        </div>
        <!-- Nav -->
    </header>
    <!-- Header -->

    @yield('header')

    @yield('slider')

    <!-- Main Content -->
    <main class="main-content">                
        @yield('content')
    </main>
    <!-- Main Content -->

    <!-- Footer -->
    <footer class="main-footer style-2">

        <!-- Footer Columns -->
        <div class="container">

            <!-- Footer columns -->
            <div class="footer-column border-0">
                <div class="row">
                    
                    <!-- Footer Column -->
                    <div class="col-sm-4 col-xs-6 r-full-width-2 r-full-width text-center" >
                        <div class="column-widget h-white">
                            <div class="logo-column p-white">
                                <img class="footer-logo" src="{{asset('assets/imagenes/logos/logo.png')}}" height="150px">
                                <span class="follow-us">Síguenos en redes </span>
                                <ul class="social-icons text-center">
                                    <li><a class="facebook" href="http://facebook.com/futsal502" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="twitter" href="http://twitter.com/futsal502" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="youtube" href="http://youtube.com/futsal502" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
                                    <li><a class="instagram" href="http://instagram.com/futsal502" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Footer Column -->

                    <!-- Footer Column -->
                    <div class="col-sm-4 col-xs-6 r-full-width-2 r-full-width">
                        <div class="column-widget h-white">
                            <h5>Publicidad</h5>
                            <a href="#"><img src="{{asset('assets/imagenes/anuncios/segurosmyc.png')}}" width="250px"></a>
                        </div>
                    </div>
                    <!-- Footer Column -->

                    <!-- Footer Column -->
                    <div class="col-sm-4 col-xs-6 r-full-width-2 r-full-width">
                        <div class="column-widget h-white">
                            <h5>Patrocinadores</h5>
                            <ul id="brand-icons-slider-2" class="brand-icons-slider-2">
                                <li>
                                    <a href="http://www.saludasualcance.net" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/epss.png')}}" alt="EPSS">
                                    </a>
                                    <a href="http://www.medyrad.net" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/medyrad.png')}}" width="80px" style="border-radius: 10px" alt="MEDYRAD">
                                    </a>
                                    <a href="http://www.guatefutbol.com" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/guatefutbol.png')}}" width="80px" style="border-radius: 10px" alt="GUATEFUTBOL.COM">
                                    </a>
                                    <a href="http://www.segurosmyc.net" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/segurosmyc.png')}}" width="80px" style="border-radius: 10px" alt="SEGUROS M&C">
                                    </a>
                                    <a href="https://www.facebook.com/wanderleyfutsal10/" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/wanderley.png')}}" width="80px" alt="10 WANDERLEY" style="border-radius: 10px">
                                    </a>
                                    <a href="#" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/futsal502.png')}}" width="80px" alt="FUTSAL 502" style="border-radius: 10px">
                                    </a>
                                </li>
                                <li>
                                    <a href="http://www.saludasualcance.net" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/epss.png')}}" alt="EPSS">
                                    </a>
                                    <a href="http://www.medyrad.net" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/medyrad.png')}}" width="80px" style="border-radius: 10px" alt="MEDYRAD">
                                    </a>
                                    <a href="http://www.guatefutbol.com" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/guatefutbol.png')}}" width="80px" style="border-radius: 10px" alt="GUATEFUTBOL.COM">
                                    </a>
                                    <a href="http://www.segurosmyc.net" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/segurosmyc.png')}}" width="80px" style="border-radius: 10px" alt="SEGUROS M&C">
                                    </a>
                                    <a href="https://www.facebook.com/wanderleyfutsal10/" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/wanderley.png')}}" width="80px" alt="10 WANDERLEY" style="border-radius: 10px">
                                    </a>
                                    <a href="#" target="_blank">
                                        <img src="{{asset('assets/imagenes/patrocinadores/futsal502.png')}}" width="80px" alt="FUTSAL 502" style="border-radius: 10px">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Footer Column -->

                </div>
            </div>
            <!-- Footer columns -->

        </div>
        <!-- Footer Columns -->

        <!-- Copy Rights -->
        <div class="copy-rights">
            <div class="container">
                <p>© Copyright by <i class="red-color">PuzzlesSoft</i> Todos los derechos reservados (2017).</p>
                <a class="back-to-top scrollup" href="#"><i class="fa fa-angle-up"></i></a>
            </div>
        </div>
        <!-- Copy Rights -->

    </footer> 
    <!-- Footer -->

</div>
<!-- Wrapper -->

<!-- Slide Menu -->
<nav id="menu" class="responive-nav">
    <a class="r-nav-logo" href="#"><img src="{{asset('assets/imagenes/logos/logo_sm.png')}}" width="100px"></a>
    <ul class="respoinve-nav-list">
        <li><a href="{{route('inicio')}}">Inicio</a></li>
        <li><a href="{{route('posiciones',[1,0])}}">Posiciones</a></li>
        <li><a href="{{route('calendario',[1,0])}}">Calendario</a></li>
        <li><a href="{{route('plantilla',[1,0,0])}}">Plantillas</a></li>
    </ul>
</nav>
<!-- Slide Menu -->

<!-- Java Script -->
<script src="{{ asset('assets/publico/js/vendor/jquery.js')}}"></script>
<script src="{{ asset('assets/publico/js/vendor/bootstrap.min.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0NoC56LrW7xzYYeJxc6HPn6LEJgkGdEU"
  type="text/javascript"></script>
<script src="{{ asset('assets/publico/js/gmap3.min.js')}}"></script>
<script src="{{ asset('assets/publico/js/bigslide.js')}}"></script>
<script src="{{ asset('assets/publico/js/slick.js')}}"></script>
<script src="{{ asset('assets/publico/js/waterwheelCarousel.js')}}"></script>
<script src="{{ asset('assets/publico/js/contact-form.js')}}"></script>
<script src="{{ asset('assets/publico/js/countTo.js')}}"></script>
<script src="{{ asset('assets/publico/js/datepicker.js')}}"></script>
<script src="{{ asset('assets/publico/js/rating-star.js')}}"></script>
<script src="{{ asset('assets/publico/js/range-slider.js')}}"></script>
<script src="{{ asset('assets/publico/js/spinner.js')}}"></script>
<script src="{{ asset('assets/publico/js/parallax.js')}}"></script>
<script src="{{ asset('assets/publico/js/countdown.js')}}"></script>
<script src="{{ asset('assets/publico/js/appear.js')}}"></script>
<script src="{{ asset('assets/publico/js/prettyPhoto.js')}}"></script>
<script src="{{ asset('assets/publico/js/wow-min.js')}}"></script>
<script src="{{ asset('assets/publico/js/main.js')}}"></script>
@yield('js')
</body>
</html>