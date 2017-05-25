@extends('layouts.admin')

@section('title') Personas @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_persona')}}" class="btn btn-primary">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>NOMBRE</th>
						<th>FECHA NACIMIENTO</th>
						<th>PAIS</th>
						<th>ROL</th>
						<th>POSICION</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tfoot class="search">
					<tr>
						<th class="searchField">NOMBRE</th>
						<th class="searchField">FECHA NACIMIENTO</th>
						<th class="searchField">PAIS</th>
						<th class="searchField">ROL</th>
						<th class="searchField">POSICION</th>
						<th class="searchField">ESTADO</th>
						<th></th>
					</tr>
				</tfoot>
				<tbody>
					@foreach($personas as $persona)
					<tr>
						<td>{{$persona->nombre_completo}}</td>
						<td>{{ date('d-m-Y', strtotime($persona->fecha_nacimiento)) }}</td>
						<td>{{$persona->pais->descripcion}}</td>
						<td>{{$persona->descripcion_rol}}</td>
						<td>@if($persona->posicion) {{$persona->descripcion_posicion}} @endif</td>
						<td>{{$persona->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_persona',$persona->id)}}" class="btn btn-warning btn-sm fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
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
	    // Setup - add a text input to each footer cell
	    $('.table tfoot th.searchField').each( function () {
	        var title = $(this).text();
	        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
	    } );
	 
	    // DataTable
	    var table = $('.table').DataTable();
	 
	    // Apply the search
	    table.columns().every( function () {
	        var that = this;
	 
	        $( 'input', this.footer() ).on( 'keyup change', function () {
	            if ( that.search() !== this.value ) {
	                that
	                    .search( this.value )
	                    .draw();
	            }
	        } );
	    } );
	} );
</script>
@stop