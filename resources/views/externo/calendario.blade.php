@extends('layouts.externo')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/publico/css/essentials.css') }}">
@endsection
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="macth-fixture">
					<h5>{{$campeonato->descripcion}}</h5>
					<div class="row">
						<div class="col-lg-6">
							{!!Field::select('campeonato',$campeonatos,$campeonato->id) !!}
						</div>
					</div>
					<div class="row">
						<div class="toggle toggle-accordion">
						@php $i=0; @endphp
						@foreach($jornadas as $jornada)
							<div class="toggle @if($i==0) active @endif"> @php $i++; @endphp
								<label>{{$jornada['jornada']['descripcion']}}</label>
								<div class="toggle-content">
									<div class="table-responsive" style="border: none;">
								<table class="table table-responsive unbordered watermark">
									@foreach($jornada['partidos'] as $partido)
									<tr>
										<td class="text-right" width="40%">
											{{$partido['descripcion_corta_equipo_local']}}
											<img src="{{$partido['logo_equipo_local']}}" height="25px" width="25px">
										</td>
										<td class="text-center" style="color: white !important; background-color: #063e71" width="20%">
											<!--<a href="{{route('ficha',$partido->id)}}" class="text-white" style="text-decoration: none; font-weight: bold" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver Ficha">-->
												@if($partido->estado == 'J' || $partido->estado == 'F')
													<span style="font-size: 20px; font-weight: bold">
														{{$partido->goles_local}} - {{$partido->goles_visita}}
													</span>
												@elseif($partido->estado == 'P')
													<span style="font-size: 12px">
													{{date('d-m',strtotime($partido->fecha))}} /
													{{date('H:i',strtotime($partido->fecha))}}
													</span>
												@elseif($partido->estado == 'R')
													<span style="font-size: 10px">
													Reprogramado
													</span>
												@elseif($partido->estado == 'S')
													<span style="font-size: 10px">
													Suspendido
													</span>
												@endif
											<!--</a>-->
										</td>
										<td class="text-left" width="40%">
											<img src="{{$partido->logo_equipo_visita}}" height="25px" width="25px">
											{{$partido->descripcion_corta_equipo_visita}}
										</td>
									</tr>
									<tr >
										<td colspan="3" class="text-center bg-primary text-white" style="font-size: 12px !important; padding: 3px">{{$partido->domo}}</td>
									</tr>
									@endforeach
								</table>
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
</div>

@stop

@section('js')
<script type="text/javascript" src="{{asset('assets/publico/js/scripts.js')}}"></script>
<script>

	var segundos = 0;

	$(function(){

		$('select').on('change', function () {
			var $campeonato = $(this).val();
			if($campeonato != ''){
        var url = '{{route("inicio")}}/externo-calendario/{{$ligaId}}/'+ $(this).val();
        if (url) { // require a URL
            window.location = url; // redirect
        }
        return false;
			}
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
