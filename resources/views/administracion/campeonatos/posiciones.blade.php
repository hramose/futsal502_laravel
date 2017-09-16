@extends('layouts.admin')
@section('title') Posiciones Campeonato {{$campeonato->descripcion}} @endsection
@section('css')
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<a href="{{route('campeonatos',$campeonato->liga_id)}}" class="btn btn-danger btn-flat">Regresar</a>
		<hr>
		<div class="table-responsive">
			@if(!$campeonato->grupos)
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
		  	@else
			<div class="row">
				@foreach($grupos as $grupo)
					<div class="col-lg-6">
						<h4>{{$grupo['grupo']}}</h4>
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
								@foreach($grupo['posiciones'] as $index => $posicion)
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
				@endforeach
			</div>
		  	@endif
	  	</div>
	</div>
</div>
@endsection
@section('js')
<script>
$(function()
{
	 
});
</script>
@endsection