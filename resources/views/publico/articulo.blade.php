@extends('layouts.publico')
@section('title') {{$articulo->titulo}} @endsection
@section('css')
<link href="{{ asset('assets/publico/plugins/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet"/>
<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />
<!-- METAS FACEBOOK -->
<meta property="og:url" content="{{route('ver_articulo',[$articulo->id, str_slug($articulo->titulo)])}}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{$articulo->titulo}}" />
<meta property="og:description" content="{{$articulo->descripcion_corta}}" />
<meta property="og:image" content="{{$articulo->imagen_portada}}" />
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
						<div class="tags-holder">						
							<ul class="social-icons">
								<li><b>Comparte este articulo</b></li>
							</ul>
						</div>
						<div id="share"></div>
						<hr>
						<div class="comment-holder theme-padding-bottom">
							<h2>{{count($comentarios)}} COMENTARIOS</h2>
							<ul>
							@foreach($comentarios as $comentario)
								<li>
									<div class="comment-detail" style="padding-left: 25px">
										<h5><a href="#">{{$comentario->nombre}}</a></h5>
										<span>{{$comentario->fecha_creacion_letras}}</span>
										<p>{{$comentario->comentario}}</p>
									</div>
								</li>
							@endforeach
							</ul>
						</div>
						<div class="leave-a-reply">
							<h2>Deja tu comentario</h2>
							{!! Form::open(['route' => ['agregar_comentario_articulo',$articulo->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
							<div class="row">
								<div class="col-sm-4"> 
									<div class="form-group">
								    	<input type="text" name="nombre" class="form-control" placeholder="Nombre">
								    	<i class="fa fa-user"></i>
								   	</div>
								   	<button class="btn red-btn full-width">Enviar Comentario</button>
								</div>
								<div class="col-sm-8">
									<div class="form-group">
										<textarea class="form-control style-d" rows="11" id="comment" placeholder="Escribe tu comentario aquí..." name="comentario"></textarea>
										<i class="fa fa-pencil-square-o"></i>
									</div>
								</div>
							</div>
							{!! Form::close() !!}
						</div>					
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
<script type="text/javascript" src="{{ asset('assets/publico/js/echo.js') }}"></script>
<script type="text/javascript">
            $(window).load(function(){

            	//echo.init();

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