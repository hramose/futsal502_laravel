@extends('layouts.admin')

@section('title') Editar Alineación - {{$equipo->descripcion}} @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => array('editar_alineacion',$partidoId,$eventoId,$equipoId), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	<div class="box-body">
		<div class="table-responsive">
			{!! Field::select('tecnico_id', $tecnicos,$tecnicoId,['data-required'=>'false']) !!}

			<div class="row">
				<div class="col-lg-4">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>NOMBRE</th>
								<th>ROL</th>
								<th>POSICION</th>
								<th>INICIA</th>
								<th>SUPLENTE</th>
							</tr>
						</thead>
						<tbody>
							@foreach($jugadores as $jugador)
							<tr>
								<td>{{$jugador->nombre_completo}}</td>
								<td>{{$jugador->descripcion_rol}}</td>
								<td>{{$jugador->descripcion_posicion}}</td>
								<td class="text-center">
									@if($jugador->inicia)
										<input type="checkbox" name="jugadores[{{$jugador->id}}][inicia]" checked >
									@else
										<input type="checkbox" name="jugadores[{{$jugador->id}}][inicia]" >
									@endif
								</td>
								<td class="text-center">
									@if($jugador->suplente)
										<input type="checkbox" name="jugadores[{{$jugador->id}}][suplente]" checked>
									@else
										<input type="checkbox" name="jugadores[{{$jugador->id}}][suplente]"  >
									@endif
									<input type="hidden" name="jugadores[{{$jugador->id}}][id]" value="{{$jugador->id}}">
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="box-footer">
		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
		<a href="{{ route('monitorear_partido',[$partido->campeonato->liga_id, $partido->campeonato_id,$partido->jornada_id,$partido->id,$equipoId]) }}" class="btn btn-danger btn-flat">Cancelar</a>
	</div>
	{!! Form::close() !!}
</div>
@stop
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		/*$('table').dataTable({
   			"bSort" : true,
   			"aaSorting" : [[1, 'asc']]
   		});*/

	});
</script>
@stop