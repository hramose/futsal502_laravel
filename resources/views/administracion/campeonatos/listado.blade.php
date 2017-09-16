@extends('layouts.admin')
@section('title') Campeonatos de {{$liga->descripcion}} @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_campeonato',$liga->id)}}" class="btn btn-primary">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>FECHA INICIO</th>
						<th>FECHA FIN</th>
						<th>MOSTRAR APP</th>
						<th>ACTUAL</th>
						<th>GRUPOS</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($campeonatos as $campeonato)
					<tr>
						<td>{{$campeonato->descripcion}}</td>
						<td>{{date('d-m-Y', strtotime($campeonato->fecha_inicio))}}</td>
						<td>{{date('d-m-Y', strtotime($campeonato->fecha_fin))}}</td>
						<td>{!! $campeonato->descripcion_mostrar_app !!}</td>
						<td>{!! $campeonato->descripcion_actual !!}</td>
						<td>{!! $campeonato->descripcion_grupos !!}</td>
						<td>{{ $campeonato->descripcion_estado }}</td>
						<td>
							<a href="{{route('editar_campeonato',$campeonato->id)}}" class="btn btn-warning btn-sm fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
							<a href="{{route('campeonatos_equipos',$campeonato->id)}}" class="btn btn-info btn-sm fa fa-users" data-toggle="tooltip" data-placement="top" title="" data-original-title="Equipos"></a>
							<a href="{{route('partidos',$campeonato->id)}}" class="btn btn-default btn-sm fa fa-futbol-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Partidos"></a>
							<a href="{{route('posiciones_campeonato',$campeonato->id)}}" class="btn btn-default btn-sm fa fa-futbol-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Posiciones"></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('.table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@endsection