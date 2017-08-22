@extends('layouts.admin')
@section('title') Articulos @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_articulo')}}" class="btn btn-primary btn-flat">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>TITULO</th>
						<th>AUTOR</th>
						<th>FECHA PUBLICACION</th>
						<th>PUBLICADO</th>
						<th>VISTAS</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($articulos as $articulo)
					<tr>
						<td>{{$articulo->titulo}}</td>
						<td>{{$articulo->autor->username}}</td>
						<td>{{$articulo->fecha_publicacion}}</td>
						<td>{!! $articulo->descripcion_publicado !!}</td>
						<td>{{ $articulo->vistas }}</td>
						<td>
							<a href="{{route('editar_articulo',$articulo->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
							<a href="{{route('medias_articulos',$articulo->id)}}" class="btn btn-primary btn-sm btn-flat fa fa-image" data-toggle="tooltip" data-placement="top" title="" data-original-title="Medias"></a>
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