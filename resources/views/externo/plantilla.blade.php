@extends('layouts.externo')
@section('title') Plantillas - {{$campeonato->descripcion}} - @if($equipo) {{$equipo->descripcion}} @endif
@endsection
@section('css')
@endsection
@section('content')
<div class="theme-padding20 white-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="macth-fixture">
					<h5>{{$campeonato->descripcion}}</h5>
					<div class="row">
						<div class="col-lg-6">
							{!!Field::select('campeonato',$campeonatos,$campeonato->id,['id'=>'campeonato']) !!}
						</div>
						<div class="col-lg-6">
							{!!Field::select('equipo',$equipos,$equipoId,['id'=>'equipo']) !!}
						</div>
					</div>
					<div class="row">
						<div class="table-responsive">
							<table class="table table-responsive">
								<thead>
									<tr>
										<td>DORSAL</td>
										<td>NOMBRE</td>
										<td>POSICION</td>
									</tr>
								</thead>
								<tbody>
									@foreach($cuerpoTecnico as $ct)
									<tr>
										<td></td>
										<td>
											<img src="{{$ct->persona->fotografia}}" alt="">
											{{$ct->persona->nombre_completo}}
										</td>
										<td>{{$ct->descripcion_posicion}}</td>
									</tr>
									@endforeach
									@foreach($jugadores as $j)
									<tr>
										<td>{{$j->dorsal}}</td>
										<td>
											<img src="{{$j->persona->fotografia}}" alt="">
											{{$j->persona->nombre_completo}}
										</td>
										<td>{{$j->descripcion_posicion}}</td>
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
@stop
@section('js')
<script>
	var segundos = 0;

	$(function(){
		$('select').on('change', function () {
			var campeonato = $('#campeonato').val();
			if(campeonato == '') campeonato = 0;

			var equipo = $('#equipo').val();
			if(equipo == '') equipo = 0;

          	var url = '{{route("inicio")}}/externo-plantilla/{{$ligaId}}/' + campeonato + '/' + equipo;
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
