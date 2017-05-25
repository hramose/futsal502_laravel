@extends('layouts.admin')
@section('title') Ligas @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_liga')}}" class="btn btn-primary">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>ORDEN</th>
						<th>MOSTRAR_APP</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($ligas as $liga)
					<tr>
						<td>{{$liga->descripcion}}</td>
						<td>{{$liga->orden}}</td>
						<td>
							@if($liga->mostrar_app)
								<i class="fa fa-check square bg-green"></i>
							@else
								<i class="fa fa-times square bg-red"></i>
							@endif
						</td>
						<td>{{$liga->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_liga',$liga->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
							<a href="{{route('campeonatos',$liga->id)}}" class="btn btn-info btn-sm btn-flat fa fa-trophy" data-toggle="tooltip" data-placement="top" title="" data-original-title="Campeonatos"></a>
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