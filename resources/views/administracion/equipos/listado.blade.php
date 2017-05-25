@extends('layouts.admin')

@section('title') Equipos @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_equipo')}}" class="btn btn-primary">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>LOGO</th>
						<th>DESCRIPCION</th>
						<th>DESCRIPCION CORTA</th>
						<th>SIGLAS</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($equipos as $equipo)
					<tr>
						<td><img src="{{$equipo->logo}}" height="25px"></td>
						<td>{{$equipo->descripcion}}</td>
						<td>{{$equipo->descripcion_corta}}</td>
						<td>{{$equipo->siglas}}</td>
						<td>{{$equipo->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_equipo',$equipo->id)}}" class="btn btn-warning btn-sm fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop

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
@stop