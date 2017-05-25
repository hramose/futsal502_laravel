@extends('layouts.admin')
@section('title') Jornadas @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_jornada')}}" class="btn btn-primary">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>FASE</th>
						<th>NUMERO</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($jornadas as $jornada)
					<tr>
						<td>{{$jornada->descripcion}}</td>
						<td>{{$jornada->descripcion_fase}}</td>
						<td>{{$jornada->numero}}</td>
						<td>{{$jornada->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_jornada',$jornada->id)}}" class="btn btn-warning btn-sm fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
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
   			"bSort" : false
   		});
	});
</script>
@endsection