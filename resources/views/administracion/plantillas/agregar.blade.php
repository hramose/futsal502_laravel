@extends('layouts.admin')

@section('title') Agregar Personas a {{$campeonatoEquipo->equipo->descripcion}} de Campeonato {{$campeonatoEquipo->campeonato->descripcion}} @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
		{!! Form::open(['route' => array('agregar_plantilla',$campeonatoEquipo->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="25px"></th>
						<th>NOMBRE</th>
						<th>ROL</th>
						<th>POSICION</th>
					</tr>
				</thead>
				<tbody>
					@foreach($personas as $persona)
					<tr>
						<td width="25px">
							<input type="checkbox" id="{{$persona->id}}" name="personas[{{$persona->id}}][seleccionado]">
							<input type="hidden" name="personas[{{$persona->id}}][id]" value="{{$persona->id}}">
						</td>
						<td>{{$persona->nombre_completo}}</td>
						<td>{{$persona->descripcion_rol}}</td>
						<td>{{$persona->descripcion_posicion}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<input type="submit" value="Agregar" class="btn btn-primary">
			<a href="{{route('plantillas',$campeonatoEquipo->id)}}" class="btn btn-danger">
				Regresar
			</a>
		{!! Form::close() !!}
		</div>
	</div>
</div>
@stop
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		var table = $('.table').DataTable({
   			"bSort" : true,
   			"aaSorting" : [[1, 'asc']]
   		});

   		$('#form').on('submit', function(e){
     		var form = this;
			// Iterate over all checkboxes in the table
			table.$('input[type="checkbox"]').each(function(){
			 	// If checkbox doesn't exist in DOM
		 		if(!$.contains(document, this)){
			    	// If checkbox is checked
			    	if(this.checked){
			    		var id = this.id;
			       		// Create a hidden element 
			       		$('#form').append(
			          		$('<input>')
			             	.attr('type', 'hidden')
			             	.attr('name', this.name)
			             	.val(this.value)
		       			);
		       			$('#form').append(
		       				$('<input>')
			             	.attr('type', 'hidden')
			             	.attr('name', 'personas['+id+'][id]')
			             	.val(id)
		       			);
			    	}
			 	} 
			});
   		});
	});
</script>
@stop
