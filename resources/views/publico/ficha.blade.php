@extends('layouts.publico')
@section('title') Ficha - {{$partido->equipo_local->descripcion}} vs {{$partido->equipo_visita->descripcion}} @stop
@section('css')
<link href="{{ asset('assets/publico/css/directo.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('header')
<div class="page-heading-breadcrumbs">
	<div class="container">
		<h2>Ficha de Partido</h2>
		<ul class="breadcrumbs">
			<li><a href="#">Inicio</a></li>
			<li>Ficha de Partido</li>
		</ul>
	</div>
</div>
@stop
@section('slider')
<div class="dir-result" itemscope="" itemtype="#">
	<div class="container">
		<div class="eq-local" itemprop="performer" itemscope="" itemtype="#">
			<a title="" class="nom-equip" href="#" itemprop="url">
				<span class="escudo">
					<img class="img-max-size" src="{{$partido->equipo_local->logo}}" alt="Tolima" title="" itemprop="image">
				</span>
				<span class="nom" itemprop="name">{{$partido->equipo_local->descripcion_corta}}</span>
			</a>
		</div>
		<div class="marcador cf">
			<span class="tanteo-local">{{$partido->goles_local}}</span>
			<div class="cont-tiempo-transcurrido">
				<div class="content-piechart partido-finalizado">
					<span class="s-pa in-circle">{{$partido->estado}}</span>
					<div class="piechart-quart1">
						<div class="int-piechart-quart1" style="transform: rotate(180deg); -ms-transform: rotate(180deg); -webkit-transform: rotate(180deg);"></div>
						</div>
					<div class="piechart-quart2">
						<div class="int-piechart-quart2"></div>
					</div>
					<div class="piechart-quart3">
						<div class="int-piechart-quart3" style="transform: rotate(180deg); -ms-transform: rotate(180deg); -webkit-transform: rotate(180deg);"></div>
					</div>
				</div>
			</div>
			<span class="tanteo-visit">{{$partido->goles_visita}}</span>
		</div>
		<div class="eq-visit" itemprop="performer" itemscope="" itemtype="http://schema.org/SportsTeam">
			<a title="" class="nom-equip" href="#" itemprop="url">
				<span class="escudo">
					<img class="img-max-size" src="{{$partido->equipo_visita->logo}}" alt="Millonarios" title="Millonarios" itemprop="image">
				</span>
				<span class="nom" itemprop="name">{{$partido->equipo_visita->descripcion_corta}}</span>
			</a>
		</div>
	</div>
</div>
<nav class="nav-aux">
	<div class="container">
		<ul class="item-3 nav-items-4">
			<!--<li>
				<a href="{{route('previa',$partido->id)}}">
					<span class="cont-icon-dir">
						<span class="fa fa-futbol-o"></span>
					</span>
					<p>Previa</p>
				</a>
			</li>-->
			<li class="active">
				<a href="{{route('ficha',$partido->id)}}">
					<span class="cont-icon-dir">
						<span class="fa fa-list"></span>
					</span>
					<p>Ficha</p>
				</a>
			</li>
			<li>
				<a href="{{route('en_vivo',$partido->id)}}">
					<span class="cont-icon-dir">
						<span class="fa fa-microphone"></span>
					</span>
					<p>Narración</p>
				</a>
			</li>
		</ul>
	</div>
</nav>
@endsection
@section('content')
	
<div class="theme-padding white-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-9">
				<div class="row">
					<div class="col-lg-12">
						<table>
							<tr>
								<td>Domo: </td>
								<td> {{$partido->domo->descripcion}} </td>
							</tr>
							<tr>
								<td>Fecha: </td>
								<td> {{date('d/m/Y H:i',strtotime($partido->fecha))}} </td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="aside-widget">
					<img src="{{asset('assets/imagenes/anuncios/epss.gif')}}" alt="">
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('js')
<script>

	var segundos = 0;

	$(function(){

	});

    function actualizar(){
    	if(segundos > 0){
    		segundos = segundos - 1;
    		$('#txtActualizar').text(segundos);
    		setTimeout("actualizar()",1000) 
        }
        else{
        	window.location.reload();
        }
    }
</script>
@stop