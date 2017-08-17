@extends('layouts.publico')
@section('title') {{$articulo->titulo}} @endsection
@section('css')
<link href="{{ asset('assets/publico/plugins/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet"/>
<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />
<!-- METAS FACEBOOK -->
<meta expr:content='{{$articulo->titulo}}' property='og:title'/>
<meta expr:content='{{$articulo->imagen_portada}}' property='og:image'/>
<meta expr:content='{{$articulo->descripcion_corta}}' property='og:description'/>
<meta expr:content='{{route('ver_articulo',[$articulo->id, str_slug($articulo->titulo)])}}' property='og:url'/>
@endsection
@section('content')
<div class="theme-padding white-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-7 col-xs-12">
				<div class="blog-detail-holder">
					<div class="author-header">
						<h2> {{$articulo->titulo}} </h2>
						<div class="details-header">
							<span class="blog-category"> {{$articulo->categoria->descripcion}} </span> 
							<span class="blog-author"> Escrito por {{$articulo->autor->username}}</span>
							<span class="pull-right blog-date">
								{{$articulo->fecha_publicacion_letras}} - 
								<i class="fa fa-eye"></i> {{$articulo->vistas}}
							</span>
						</div>
						<div class="share-option pull-right">
							<div id="show-social-icon1" class="on-hover-share">
								<ul class="social-icons">
									<li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
									<li><a class="youtube" href="#"><i class="fa fa-youtube-play"></i></a></li>
									<li><a class="pinterest" href="#"><i class="fa fa-pinterest-p"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="blog-detail">
						<figure>
							<img src="{{$articulo->imagen_portada}}" alt="">
						</figure>
						<article>
							{!! $articulo->descripcion !!}
						</article>
						<article>
							@if(count($imagenes) > 0)
							<h4>IMAGENES</h4>
							<div class="row port m-b-20">
            					<div class="portfolioContainer">
            						@foreach($imagenes as $imagen)
                					<div class="col-sm-6 col-lg-3 col-md-4 webdesign illustrator" style="margin: 10px 0">
                    					<div class="gal-detail thumb">
                        					<a href="{{$imagen->ruta}}" class="image-popup">
                            					<img src="{{$imagen->ruta}}" class="thumb-img">
                        					</a>
                    					</div>
                					</div>
                					@endforeach
                				</div>
							@endif
							@if(count($videos) > 0)
							<h4>VIDEOS</h4>
							@endif
						</article>
					</div>
					<div id="share"></div>
					<div class="tags-holder">						
						<ul class="social-icons pull-right">
							<li>Comparte este articulo</li>							
						</ul>
					</div>							
				</div>
			</div>
			<!-- Blog Content -->

			<!-- Aside -->
			<div class="col-lg-3 col-md-3 col-sm-5 col-xs-12">
				<div class="aside-widget">
					<img src="{{asset('assets/imagenes/anuncios/segurosmyc.png')}}" alt="">
				</div>
				<div class="aside-widget">
					<h3><span>Top Categorías</span></h3>
					<div class="top-categories">
						<ul>
							@foreach($categorias as $categoria)
							<li><a href="{{route('ver_articulos',[0,$categoria->id])}}">{{$categoria->descripcion}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<!-- Aside Widget -->

				<!-- Aside Widget -->
				<div class="aside-widget">
					<h3><span>Populares</span></h3>
					<div class="Popular-news">
						<ul>
							@foreach($articulosPopulares as $ap)
							<li>
								<img src="{{$ap->imagen_portada}}" width="56px" height="56px">
								<h5><a href="{{route('ver_articulo',[$ap->id, str_slug($ap->titulo)])}}">{{$ap->titulo}}</a></h5>
								<span class="red-color"><i class="fa fa-clock-o"></i>
									{{$ap->fecha_publicacion_corta}}
								</span>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
				<!-- Aside Widget -->

			</div>
			<!-- Aside -->

		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>
<script>
        $("#share").jsSocials({
            shares: ["facebook", "twitter", "googleplus"],
            showCount: true,
        });
    </script>
<script type="text/javascript" src="{{ asset('assets/publico/plugins/isotope/dist/isotope.pkgd.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/publico/plugins/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
<script type="text/javascript">
            $(window).load(function(){
                var $container = $('.portfolioContainer');
                $container.isotope({
                    filter: '*',
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });

                $('.portfolioFilter a').click(function(){
                    $('.portfolioFilter .current').removeClass('current');
                    $(this).addClass('current');

                    var selector = $(this).attr('data-filter');
                    $container.isotope({
                        filter: selector,
                        animationOptions: {
                            duration: 750,
                            easing: 'linear',
                            queue: false
                        }
                    });
                    return false;
                });
            });
            $(document).ready(function() {
                $('.image-popup').magnificPopup({
                    type: 'image',
                    closeOnContentClick: true,
                    mainClass: 'mfp-fade',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                    }
                });
            });
        </script>
@endsection