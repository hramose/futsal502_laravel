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
						<h3><span><i class="red-color">CUERPO </i>TÉCNICO</span></h3>
						@foreach($cuerpoTecnico as $ct)
						<div class="col-lg-4 col-sm-4 col-xs-6 r-full-width">
							<div class="team-column">
								<img src="{{$ct->persona->fotografia}}" alt="">
								<div class="team-detail">
									<h5><a href="#">{{$ct->persona->nombre_completo}}</a></h5>
									<span class="desination">{{$ct->descripcion_posicion}}</span>
									<div class="detail-inner">
										<ul>
											<li>Pais</li>
											<li>Posición</li>
											<li>Sexo</li>
											<li></li>
										</ul>
										<ul>
											<li>{{$ct->persona->pais->descripcion}}</li>
											<li>{{$ct->descripcion_posicion}}</li>
											<li>{{$ct->persona->descripcion_genero}}</li>
											<li></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					<hr>
					<div class="row">
						<h3><span><i class="red-color">JUGADORES </i></span></h3>
						@foreach($jugadores as $j)
						<div class="col-lg-4 col-sm-4 col-xs-6 r-full-width">
							<div class="team-column">
								<img src="{{$j->persona->fotografia}}" alt="">
								<span class="player-number">{{$j->dorsal}}</span>
								<div class="team-detail">
									<h5><a href="#">{{$j->persona->nombre_completo}}</a></h5>
									<span class="desination">{{$j->descripcion_posicion}}</span>
									<div class="detail-inner">
										<ul>
											<li>Pais</li>
											<li>Posición</li>
											<li>Dorsal</li>
											<li>Sexo</li>
										</ul>
										<ul>
											<li>{{$j->persona->pais->descripcion}}</li>
											<li>{{$j->descripcion_posicion}}</li>
											<li>{{$j->dorsal}}</li>
											<li>{{$j->persona->descripcion_genero}}</li>
										</ul>
									</div>
								</div>
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
