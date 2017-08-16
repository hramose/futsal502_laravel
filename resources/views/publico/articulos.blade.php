@extends('layouts.publico')
@section('title') {{$titulo}} @stop
@section('css')
<link href="{{ asset('assets/publico/plugins/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet"/>
@stop
@section('content')
<main class="main-content">
	<div class="theme-padding white-bg">
		<div class="container">
			<div class="row">		
				<div class="col-lg-9 col-md-9 col-sm-8 col-xs-7 r-full-width">
					<div class="blog-list-View theme-padding-bottom">
						<div class="theme-padding-bottom">
							@foreach($articulos as $articulo)
							<div class="row" style="margin-bottom: 25px;">								
								<div class="col-lg-5 col-md-5 col-xs-12">
									<div class="large-post-img image-zoom">
										<img src="{{$articulo->imagen_portada}}" alt="">
										<span class="blog-title-batch">{{$articulo->categoria->descripcion}}</span>
									</div>
								</div>
								<div class="col-lg-7 col-md-7 col-xs-12">
									<div class="large-post-detail style-2">
										<h2 style="margin-bottom: 5px"><a href="{{route('ver_articulo',[$articulo->id, str_slug($articulo->titulo)])}}">{{$articulo->titulo}}</a></h2>
										<span class="blog-category" style=""> {{$articulo->categoria->descripcion}} </span> <span class="blog-author">Escrito por <b>{{$articulo->autor->username}}</b></span>
										<p class="blog-descripcion-breve"> {{$articulo->descripcion_corta}} </p>
										<a class="btn gary-btn" href="{{route('ver_articulo',[$articulo->id,str_slug($articulo->titulo)])}}"><i>+</i>Leer más</a>
									</div>
								</div>
							</div>
							@endforeach
						</div>						
						<div class="pagination-holder">
							{{$articulos->links()}}
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 r-full-width">
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
					<div class="aside-widget">
						<h3><span>Populares</span></h3>
						<div class="Popular-news">
							<ul>
								@foreach($articulosPopulares as $ap)
								<li>
									<img src="{{$ap->imagen_portada}}" width="56px" height="56px">
									<h5><a href="{{route('ver_articulo',[$ap->id,str_slug($ap->titulo)])}}">{{$ap->titulo}}</a></h5>
									<span class="red-color"><i class="fa fa-clock-o"></i>
										{{date('d-m-Y', strtotime($ap->fecha_publicacion))}}
									</span>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@stop