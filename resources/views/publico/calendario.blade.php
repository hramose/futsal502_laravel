@extends('layouts.publico')
@section('title') Calendario - {{$campeonato->descripcion}} @stop
@section('css')
<link href="{{ asset('assets/public/css/plugins/datatables/datatables.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('header')
<div class="page-heading-breadcrumbs">
	<div class="container">
		<h2>Calendario</h2>
		<ul class="breadcrumbs">
			<li><a href="#">Inicio</a></li>
			<li>Calendario</li>
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
			<div class="col-lg-3 col-sm-4">
				<div class="aside-widget">
					<a href="#"><img src="images/adds-02.jpg" alt=""></a>
				</div>
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
			<div class="col-lg-9 col-sm-8">
				<div class="macth-fixture">
					<h5>{{$campeonato->descripcion}}</h5>
					<div class="row">
						<div class="col-lg-6">
							{!!Field::select('campeonato',$campeonatos,$campeonato->id) !!}
						</div>
					</div>
					<div class="row">
						@foreach($jornadas as $jornada)
						<div class="col-lg-6 col-md-6">
							<h4>{{$jornada['jornada']->descripcion}}</h4>
							<div class="table-responsive" style="border: none;">
								<table class="table table-responsive unbordered">
									@foreach($jornada['partidos'] as $partido)
									<tr>
										<td class="text-right" width="40%">
											{{$partido->equipo_local->descripcion_corta}}
											<img src="{{$partido->equipo_local->logo}}" height="25px" width="25px">
										</td>
										<td class="text-center" style="color: white !important; background-color: #063e71" width="20%">
											<a href="{{route('ficha',$partido->id)}}" class="text-white" style="text-decoration: none; font-weight: bold" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver Ficha">
												@if($partido->estado == 'J')
													{{$partido->goles_local}} - {{$partido->goles_visita}}
												@else
													<span style="font-size: 10px">
													{{date('d-m',strtotime($partido->fecha))}} / 
													{{date('H:i',strtotime($partido->fecha))}}
													</span>
												@endif
											</a>
										</td>
										<td class="text-left" width="40%">
											<img src="{{$partido->equipo_visita->logo}}" height="25px" width="25px">
											{{$partido->equipo_visita->descripcion_corta}}
										</td>
									</tr>
									@endforeach
								</table>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
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
          var url = '{{route("inicio")}}/calendario/{{$ligaId}}/'+ $(this).val();
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