@extends('layouts.publico')
@section('title') Futsal 502 @endsection
@section('css')
<link href="{{ asset('assets/publico/css/social.css') }}" rel="stylesheet"/>
@endsection
@section('content')
	<main class="main-content">
		<section class="theme-padding-bottom bg-fixed">
			<div class="container">
				<div class="match-detail-content" style="margin-top: 80px">
					<div class="row">
						<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-xs-12">
									<div class="latest-news-holder">
										<div class="row no-gutters white-bg">
											<div class="col-sm-9">
												<ul id="latest-news-slider" class="latest-news-slider">
													@foreach($articulosRecientes as $ar)
														<li>
															<img src="{{$ar->imagen_portada}}" alt="">
															<span class="blog-title-batch-top">{{$ar->categoria->descripcion}}</span>
														    <p>
														    	{{$ar->descripcion_corta}}
														    	<a href="{{route('ver_articulo',$ar->id)}}">Leer más...</a>
														    </p>
													    </li>
													@endforeach
												</ul>
											</div>
											<div class="col-sm-3">
												<ul id="latest-news-thumb" class="latest-news-thumb">
													@foreach($articulosRecientes as $ar)				
													<li>
														<p>{{$ar->titulo}}</p>
														<span>{{ date('d/m/Y', strtotime($ar->fecha_publicacion)) }}</span>
													</li>
													@endforeach
												</ul>
												<ul class="news-thumb-arrows">
													<li class="prev"><span class="fa fa-angle-up"></span></li>
													<li class="next"><span class="fa fa-angle-down"></span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 ad-horizontal">
									<img src="{{asset('assets/imagenes/anuncios/epss-h.gif')}}">
								</div>
								@if(count($proximosPartidos) > 0)
								<div class="col-xs-12" style="margin-bottom: 30px">
									<h3><span><i class="red-color">PROXIMOS </i>PARTIDOS</span><a class="view-all pull-right" href="{{route('calendario',[$ligaId,$campeonatoId])}}">Ver todos<i class="fa fa-angle-double-right"></i></a></h3>
									<div class="upcoming-fixture">
										<div class="table-responsive">
											<table class="table table-bordered">
											    <tbody>
											    	@foreach($proximosPartidos as $partido)
												    <tr>
												        <td>
												        	<div class="logo-width-name"><img src="{{$partido->equipo_local->logo}}" width="36px">{{$partido->equipo_local->descripcion_corta}}</div>
												        </td>
												        <td class="upcoming-fixture-date text-center">
												        	<a href="{{route('ficha',$partido->id)}}" style="color:red">
												        	<span>{{date('d/m - H:i', strtotime($partido->fecha))}}</span>
												        	</a>
												        </td>
												        <td>
												        	<div class="logo-width-name text-right">{{$partido->equipo_visita->descripcion_corta}}
												        		<img src="{{$partido->equipo_visita->logo}}" width="36px">
												        	</div>
												        </td>
												    </tr>
												    @endforeach
											    </tbody>
											</table>
										</div>
									</div>
								</div>
								@endif
								<div class="col-xs-12">
									<h3><span><i class="red-color">ULTIMAS </i>NOTICIAS</span><a class="view-all pull-right" href="{{route('ver_articulos',[0,0])}}">Ver todas<i class="fa fa-angle-double-right"></i></a></h3>
									<div class="upcoming-fixture">
										<div class="blog-grid-view"  style="margin-top: 20px">
											<div class="row">
												@foreach($ultimasNoticias as $noticia)
												<div class="col-lg-4 col-xs-12">
													<div class="large-post-img image-zoom">
														<img src="{{$noticia->imagen_portada}}" alt="">
														<span class="blog-title-batch">{{$noticia->categoria->descripcion}}</span>
													</div>
													<div class="large-post-detail style-3">
														<h2><a href="{{route('ver_articulo',$noticia->id)}}">{{$noticia->titulo}}</a></h2>
													</div>
													<div class="detail-btm">
														<span>{{date('d/m/Y', strtotime($noticia->fecha_publicacion))}}</span>
													</div>
												</div>
												@endforeach
											</div>
										</div>										
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<div class="aside-widget social-counter skin-2 hidden-xs">
								<a class="item facebook" data-icon="fa fa-facebook" data-text="Likes" href="https://facebook.com/futsal502" target="_blank"><i class="fa fa-facebook"></i><span class="count">{{$followers['facebook']}}</span><em>Me Gusta</em></a>
								<a class="item twitter" data-icon="fa fa-twitter" data-text="Likes" href="https://twitter.com/futsal502"  target="_blank"><i class="fa fa-twitter"></i><span class="count">{{$followers['twitter']}}</span><em>Seguidores</em></a>
								<a class="item instagram" data-icon="fa fa-instagram" data-text="Likes" href="https://instagram.com/futsal502"  target="_blank"><i class="fa fa-instagram"></i><span class="count">{{$followers['instagram']}}</span><em>Seguidores</em></a>
							</div>
							<div class="aside-widget">
								<img src="{{asset('assets/imagenes/anuncios/segurosmyc.png')}}" alt="">
							</div>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-7 col-xs-6 r-full-width" style="margin-bottom: 25px">
									<div class="last-matches styel-1">
										<h3><span>POSICIONES</span></h3>
										<table class="table table-bordered table-hover">
										    <thead>
										    	<tr>
											        <th class="text-center">#</th>
											        <th class="text-center">Equipo</th>
											        <th class="text-center">PTS</th>
											        <th class="text-center">JJ</th>
										      	</tr>
										    </thead>
										    <tbody>
										    	@foreach($posiciones as $index => $pos)
										    	<tr>
											        <td class="text-center">{{$index+1}}</td>
											        <td>{{$pos->equipo->descripcion_corta}}</td>
											        <td width="35px" class="text-center">{{$pos->PTS}}</td>
											        <td width="35px" class="text-center">{{$pos->JJ}} </td>
										      	</tr>
										      	@endforeach
										    </tbody>
									  	</table>
									</div>
								</div>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
@endsection
@section('js')
<script>
	$(function(){
		$('.li-link').each(function(index, li){
			$(li).on('click', function(){
				window.location.href = $(this).attr('data-link');
			});
		});

	});
</script>
@stop