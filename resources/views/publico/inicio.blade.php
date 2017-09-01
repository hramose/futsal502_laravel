@extends('layouts.publico')
@section('title') Futsal 502 @endsection
@section('css')
<link href="{{ asset('assets/publico/css/social.css') }}" rel="stylesheet"/>
<style>
	.articles-box {
		margin: 0 0 10px 0;
	    padding: 0;
	    border: 0;
	    font-size: 100%;
	    font: inherit;
	    vertical-align: top;
	}
	.articles-box .article{
		margin: 0 !important;
	    padding: 0 !important;
	    position: relative;
	}
	a.darken {
	    display: inline-block;
	    background: black;
	    padding: 0;
	}
	.darken img{
		-webkit-transition: all 0.5s linear;
       -moz-transition: all 0.5s linear;
        -ms-transition: all 0.5s linear;
         -o-transition: all 0.5s linear;
            transition: all 0.5s linear;
	}
	.darken:hover img{
		opacity: 0.8;
	}
	.article img{
		width: 100%;
		position: relative;		
	}
	.article div.title-box{
		display: block;
		width: 100%;
		position: absolute;
		bottom: 0;
		background: linear-gradient(to bottom,rgba(217,10,10,0) 0%,rgba(6, 62, 113, 0.58) 14%,#063e71 100%);
		color: white !important;
		padding: 10px;
	}
	.article:hover div.title-box{
		
	}
	.article-title{
		color: white;
		margin: 0;
		padding: 0;
		font-size: 18px
	}
	.article-category{
		color: white;
		margin: 0;
		padding: 5px 10px;
		font-size: 10px;
		background: #063e71;
		top: 5px;
    	position: absolute;
    	font-weight: bold;
	}
	.article-description{
		color: white;
		margin: 0;
		padding: 0;
	}
	.article-date{
		color: white;
		margin: 0;
		padding: 0;
		font-size: 8px;
		float: left;
	}
	.article-views{
		color: white;
		margin: 0;
		padding: 0;
		font-size: 8px;
		float: right;
	}
	.match-detail-content{
		margin-top: 80px;
	}
	@media (max-width: 480px){
		.match-detail-content{
			margin-top: 20px;
		}
	}
</style>
@endsection
@section('content')
<section class="theme-padding-bottom bg-fixed">
	<div class="container">
		<div class="match-detail-content" >
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<div class="row">
						<div class="row articles-box">
						@foreach($articulosRecientes as $ar)
							<div class="col-lg-6 article image-zoom">
							<a href="{{route('ver_articulo',[$ar->id, str_slug($ar->titulo)])}}" class="darken">
								<img src="{{$ar->imagen_portada}}" >
								<span class="article-category">{{$ar->categoria->descripcion}}</span>
								<div class="title-box">
									<h3 class="article-title">{{$ar->titulo}}</h3>
									<span class="article-date">{{$ar->fecha_publicacion_letras}}</span>
									<span class="article-views"><i class="fa fa-eye"></i> {{$ar->vistas}}</span>
									<!--<p class="article-description">
										{{$ar->descripcion_corta}}
									</p>-->
								</div>
							</a>
							</div>
						@endforeach
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
										        <td class="upcoming-fixture-date text-center" style="    padding-bottom: 0;">
										        	<a href="{{route('ficha',$partido->id)}}" style="color:red">
										        	<span>{{date('d/m - H:i', strtotime($partido->fecha))}}</span>
										        	</a>
										        	<span style="top: -15px;">{{$partido->domo->descripcion}}</span>
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
												<h2><a href="{{route('ver_articulo',[$noticia->id,str_slug($noticia->titulo)])}}" style="min-height: 35px;">{{$noticia->titulo}}</a></h2>
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
								<h3><a href="{{route('posiciones',[1,0])}}"><span>POSICIONES</span></a></h3>
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
								    	@if($index<3)
								    	<tr>
									        <td class="text-center">{{$index+1}}</td>
									        <td>{{$pos->equipo->descripcion_corta}}</td>
									        <td width="35px" class="text-center">{{$pos->PTS}}</td>
									        <td width="35px" class="text-center">{{$pos->JJ}} </td>
								      	</tr>
								      	@endif
								      	@endforeach
								      	<tr>
								      		<td colspan="4" class="bg-primary text-center"><a href="{{route('posiciones',[1,0])}}" class="text-white">Ver tabla completa</a></td>
								      	</tr>
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