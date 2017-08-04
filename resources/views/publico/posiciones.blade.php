@extends('layouts.publico')
@section('title') Tabla de Posiciones - {{$campeonato->descripcion}} @stop
@section('css')
<link href="{{ asset('assets/public/css/plugins/datatables/datatables.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('header')
<div class="page-heading-breadcrumbs">
	<div class="container">
		<h2>Tabla de Posiciones</h2>
		<ul class="breadcrumbs">
			<li><a href="#">Inicio</a></li>
			<li>Tabla de Posiciones</li>
		</ul>
	</div>
</div>
@stop
@section('slider')
<div class="overlay-dark theme-padding parallax-window" data-appear-top-offset="600" data-parallax="scroll" data-image-src="{{asset('assets/imagenes/domoz13.png')}}"></div>
@endsection
@section('content')
	
<div class="theme-padding white-bg">
	<div class="container">
		<div class="row">
			<!-- Aside -->
			<div class="col-lg-3 col-sm-4">
				<!-- Aside Widget -->
				<div class="aside-widget">
					<a href="#"><img src="images/adds-02.jpg" alt=""></a>
				</div>
				<!-- Aside Widget -->
				<!-- Aside Widget -->
				<div class="aside-widget">
					<h3><span>Popular News</span></h3>
					<div class="Popular-news">
						<ul>
							<li>
								<img src="images/popular-news/img-01.jpg" alt="">
								<h5><a href="#">Two touch penalties, imaginary cards</a></h5>
								<span class="red-color"><i class="fa fa-clock-o"></i>22 Feb, 2016</span>
							</li>
							<li>
								<img src="images/popular-news/img-02.jpg" alt="">
								<h5><a href="#">Two touch penalties, imaginary cards</a></h5>
								<span class="red-color"><i class="fa fa-clock-o"></i>22 Feb, 2016</span>
							</li>
							<li>
								<img src="images/popular-news/img-03.jpg" alt="">
								<h5><a href="#">Two touch penalties, imaginary cards</a></h5>
								<span class="red-color"><i class="fa fa-clock-o"></i>22 Feb, 2016</span>
							</li>
							<li>
								<img src="images/popular-news/img-04.jpg" alt="">
								<h5><a href="#">Two touch penalties, imaginary cards</a></h5>
								<span class="red-color"><i class="fa fa-clock-o"></i>22 Feb, 2016</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- Aside Widget -->
			<!-- Match Result Contenet -->
			<div class="col-lg-9 col-sm-8">

				<!-- Piont Table -->
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
							    	<tr>
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
											<img src="{{$posicion->equipo->logo}}" style="height: 25px; width: 25px"> 
												{{$posicion->equipo->descripcion}}
										</td>
										<td class="text-center">{{$posicion->PTS}}</td>
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
				<!-- Piont Table -->
			</div>
			<!-- Match Result Contenet -->
		</div>
			<!-- Aside -->
	</div>
</div>

@stop

@section('js')

<script src="{{ asset('assets/public/js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/public/js/plugins/datatables/datatables-bs3.js') }}" type="text/javascript"></script>
<script>

	var segundos = 0;

	$(function(){		

		$('.table').dataTable({
			"bSort" : false,
			"bPaginate": false,
			"bFilter": false, 
			"bInfo": false,
   			"iDisplayLength" : 25,
		});

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