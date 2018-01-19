@extends('layouts.externo')
@section('title') Tabla de Posiciones - {{$campeonato->descripcion}} @stop
@section('css')
<style>
	@media screen and (max-width:767px){
		.tdteam {
			text-align: left;
			padding-left: 5px;
			min-width: 300px !important;
		}
		.table-responsive {
	    overflow-x: auto;
		}
	}
</style>
@endsection
@section('content')
	<div class="container" style="padding: 5px !important; width: 100%;">
		<div class="row">
			<div class="col-lg-12">
				<div class="macth-fixture">
					<h5>{{$campeonato->descripcion}}</h5>
					<div class="row">
						<div class="col-lg-6">
							{!!Field::select('campeonato',$campeonatos,$campeonato->id) !!}
						</div>
					</div>
					<div class="last-matches styel-3">
						<div class="table-responsive">
							@if(!$campeonato->grupos)
							<table class="table table-bordered table-hover">
							    <thead>
							    	<tr class="bg-primary">
						        <th class="text-center" width="30px">POS</th>
										<th class="text-center tdteam">EQUIPO</th>
										<th class="text-center" width="30px">PTS</th>
										<th class="text-center" width="30px">JJ</th>
										<th class="text-center" width="30px">JG</th>
										<th class="text-center" width="30px">JE</th>
										<th class="text-center" width="30px">JP</th>
										<th class="text-center" width="30px">GF</th>
										<th class="text-center" width="30px">GC</th>
										<th class="text-center" width="30px">DIF</th>
							      	</tr>
							    </thead>
							    <tbody class="color">
									@foreach($posiciones as $index => $posicion)
									<tr>
										<td class="text-center">{{$index+1}}</td>
										<td class="tdteam" style="">
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
						  	@else
							<div class="row">
								@foreach($grupos as $grupo)
									<div class="col-lg-12">
										<h4>{{$grupo['grupo']}}</h4>
										<table class="table table-bordered table-hover">
										    <thead>
										    	<tr class="bg-primary">
											        <th class="text-center" width="30px">POS</th>
													<th class="text-center" style="min-width:180px;">EQUIPO</th>
													<th class="text-center" width="30px">PTS</th>
													<th class="text-center" width="30px">JJ</th>
													<th class="text-center" width="30px">JG</th>
													<th class="text-center" width="30px">JE</th>
													<th class="text-center" width="30px">JP</th>
													<th class="text-center" width="30px">GF</th>
													<th class="text-center" width="30px">GC</th>
													<th class="text-center" width="30px">DIF</th>
										      	</tr>
										    </thead>
										    <tbody class="color">
												@foreach($grupo['posiciones'] as $index => $posicion)
												<tr>
													<td class="text-center">{{$index+1}}</td>
													<td style="text-align: left; min-width:300px;">
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
								@endforeach
							</div>
						  	@endif
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

				var $campeonato = $(this).val();
				if($campeonato != ''){
          var url = '{{route("inicio")}}/externo-posiciones/{{$ligaId}}/'+ $campeonato ;
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
