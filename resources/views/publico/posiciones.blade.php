@extends('layouts.publico')
@section('title') Tabla de Posiciones - {{$campeonato->descripcion}} @stop
@section('css')
@stop
@section('header')
<div class="page-heading-breadcrumbs">
	<div class="container">
		<h2>Tabla de Posiciones</h2>
		<ul class="breadcrumbs">
			<li><a href="{{route('inicio')}}">Inicio</a></li>
			<li>Tabla de Posiciones</li>
		</ul>
	</div>
</div>
@stop
@section('content')	
<div class="theme-padding20 white-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-sm-8">
				<div class="macth-fixture">
					<h5>{{$campeonato->descripcion}}</h5>
					<div class="row">
						<div class="col-lg-6">
							{!!Field::select('campeonato',$campeonatos,$campeonato->id) !!}
						</div>
					</div>
					<div class="last-matches styel-3">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
							    <thead>
							    	<tr class="bg-primary">
								        <th class="text-center">POS</th>
										<th class="text-center">EQUIPO</th>
										<th class="text-center">PTS</th>
										<th class="text-center">JJ</th>
										<th class="text-center">JG</th>
										<th class="text-center">JE</th>
										<th class="text-center">JP</th>
										<th class="text-center">GF</th>
										<th class="text-center">GC</th>
										<th class="text-center">DIF</th>
							      	</tr>
							    </thead>
							    <tbody class="color">
									@foreach($posiciones as $index => $posicion)
									<tr>
										<td class="text-center">{{$index+1}}</td>
										<td style="text-align: left"> 
											<span style="width: 50px !important; float: left; text-align: center;">
												<img src="{{$posicion->equipo->logo}}" 
														style="height: 25px; max-width: 50px"> 
											</span>
											<span>
												{{$posicion->equipo->descripcion}}
											</span>
										</td>
										<td class="text-center bg-primary text-white">{{$posicion->PTS}}</td>
										<td class="text-center">{{$posicion->JJ}}</td>
										<td class="text-center">{{$posicion->JG}}</td>
										<td class="text-center">{{$posicion->JE}}</td>
										<td class="text-center">{{$posicion->JP}}</td>
										<td class="text-center">{{$posicion->GF}}</td>
										<td class="text-center">{{$posicion->GC}}</td>
										<td class="text-center">{{$posicion->DIF}}</td>
									</tr>
									@endforeach
								</tbody>
						  	</table>
					  	</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-4">
				<div class="aside-widget">
					<img src="{{asset('assets/imagenes/anuncios/epss.gif')}}" alt="">
				</div>
				<div class="aside-widget">
					<h3><span>Populares</span></h3>
					<div class="Popular-news">
						<ul>
							@foreach($articulosPopulares as $ap)
							<li>
								<img src="{{$ap->imagen_portada}}" width="56px" height="56px">
								<h5><a href="{{route('ver_articulo',[$ap->id, str_slug($ap->titulo)])}}">{{$ap->titulo}}</a></h5>
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
@stop
@section('js')
<script>
	var segundos = 0;

	$(function(){
		$('select').on('change', function () {
          var url = '{{route("inicio")}}/posiciones/{{$ligaId}}/'+ $(this).val();
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });

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