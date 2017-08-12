@extends('layouts.publico')
@section('title') Futsal 502 @endsection
@section('css')
<link href="{{ asset('assets/public/css/plugins/datatables/datatables.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('slider')
	<div class="slider-holder">
		<ul id="main-slides" class="main-slides">
			<li>
			    <div id="animated-slider" class="carousel slide carousel-fade">
			        <div class="carousel-inner" role="listbox">
			            <div class="item active">
			            	<img src="{{asset('assets/imagenes/slides/1.jpg')}}" alt="">
			            </div>
			             <div class="item">
			            	<img src="{{asset('assets/imagenes/slides/2.jpg')}}" alt="">
			            </div>
			             <div class="item">
			            	<img src="{{asset('assets/imagenes/slides/3.jpg')}}" alt="">
			            </div>
			        </div>
			        <!-- Wrapper for slides -->

			        <!-- Nan Control -->
			        <!-- <a class="slider-nav next" href="#animated-slider" data-slide="prev"><i class="fa fa-long-arrow-right"></i></a>
			        <a class="slider-nav prev" href="#animated-slider" data-slide="next"><i class="fa fa-long-arrow-left"></i></a> -->
			        <!-- Nan Control -->

			        <!-- Indicators -->
			        <ul class="carousel-indicators">
			            <li data-target="#animated-slider" data-slide-to="0" class="active"></li>
			            <li data-target="#animated-slider" data-slide-to="1"></li>
			            <li data-target="#animated-slider" data-slide-to="2"></li>
			        </ul>
			        <!-- Indicators -->

			    </div>
			</li>

		</ul>

	</div>
	<!-- Slider Holder -->
@endsection
@section('content')
	
<!-- Main Content -->
	<main class="main-content">
		
		<!-- Match Detail -->
		<section class="theme-padding-bottom bg-fixed">
			<div class="container">

				<!-- Add Banners -->
				<div class="add-banners">
					<ul id="add-banners-slider" class="add-banners-slider">
						<li>
							<a href="#"><img src="{{asset('assets/imagenes/anuncios/1.jpg')}}" alt=""></a>
						</li>
						<li>
							<a href="#"><img src="{{asset('assets/imagenes/anuncios/2.png')}}" alt=""></a>
						</li>
						<li>
							<a href="#"><img src="{{asset('assets/imagenes/anuncios/3.jpg')}}" alt=""></a>
						</li>
					</ul>
				</div>
				<!-- Add Banners -->

				<!-- Match Detail Content -->
				<div class="match-detail-content">
					<div class="row">
						<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
							<div class="row">
								<!-- Latest News -->
								<div class="col-xs-12">
									<div class="latest-news-holder">
										<h3><span>Últimas Noticias</span></h3>

										<!-- latest-news Slider -->
										<div class="row no-gutters white-bg">

											<!-- Slider -->
											<div class="col-sm-9">
												<ul id="latest-news-slider" class="latest-news-slider">
													@foreach($articulosRecientes as $ar)
														<li>
															<img src="{{$ar->imagen_portada}}" alt="">
														    <p>
														    	{{$ar->descripcion_corta}}
														    	<a href="#">Leer más...</a>
														    </p>
													    </li>
													@endforeach
												</ul>
											</div>
											<!-- Slider -->

											<!-- Thumnail -->
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
											<!-- Thumnail -->

										</div>
										<!-- latest-news Slider -->

									</div>
								</div>
								<!-- Latest News -->

								<!-- Upcoming Fixture -->
								<div class="col-xs-12">
									<h3><span><i class="red-color">PROXIMOS </i>PARTIDOS</span><a class="view-all pull-right" href="{{route('calendario',[$ligaId,$campeonatoId])}}">Ver todos<i class="fa fa-angle-double-right"></i></a></h3>
									<div class="upcoming-fixture">
										<div class="table-responsive">
											<table class="table table-bordered">
											    <tbody>
											    	@foreach($proximosPartidos as $partido)
												    <tr>
												        <td>
												        	<div class="logo-width-name"><img src="{{$partido->equipo_local->logo}}" height="36px">{{$partido->equipo_local->descripcion_corta}}</div>
												        </td>
												        <td class="upcoming-fixture-date text-center">
												        	<a href="{{route('ficha',$partido->id)}}" style="color:red">
												        	<span>{{date('d/m - H:i', strtotime($partido->fecha))}}</span>
												        	</a>
												        </td>
												        <td>
												        	<div class="logo-width-name text-right">{{$partido->equipo_visita->descripcion_corta}}
												        		<img src="{{$partido->equipo_visita->logo}}" height="36px">
												        	</div>
												        </td>
												    </tr>
												    @endforeach
											    </tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- Upcoming Fixture -->

								

							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<div class="row">

								<!-- Last Match -->
								<div class="col-lg-12 col-md-12 col-sm-7 col-xs-6 r-full-width" style="margin-bottom: 25px">
									<div class="last-matches styel-1">
										<h3><span>POSICIONES</span></h3>
										<table class="table table-bordered table-hover">
										    <thead>
										    	<tr>
											        <th>#</th>
											        <th>Equipo</th>
											        <th>PTS</th>
											        <th>JJ</th>
											        <th>DIF</th>
										      	</tr>
										    </thead>
										    <tbody>
										    	@foreach($posiciones as $index => $pos)
										    	<tr>
											        <td>{{$index+1}}</td>
											        <td>{{$pos->equipo->descripcion_corta}}</td>
											        <td>{{$pos->PTS}}</td>
											        <td>{{$pos->JJ}} </td>
											        <td>{{$pos->DIF}}</td>
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
				<!-- Match Detail Content -->

			</div>
		</section>
		<!-- Match Detail -->
	
@endsection