@extends('layouts.admin')
@section('title') Agregar Equipos a Campeonato {{$campeonato->descripcion}} @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
		{!! Form::open(['route' => array('agregar_equipos_campeonato',$campeonato->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="25px"></th>
						<th>EQUIPO</th>
						<th width="100px">GRUPO</th>
					</tr>
				</thead>
				<tbody>
					@foreach($equipos as $equipo)
					<tr>
						<td width="25px">
							<input type="checkbox" id="{{$equipo->id}}" name="equipos[{{$equipo->id}}][seleccionado]">
							<input type="hidden" name="equipos[{{$equipo->id}}][id]" value="{{$equipo->id}}">
						</td>
						<td>{{$equipo->descripcion}}</td>
						<td>
							<select name="equipos[{{$equipo->id}}][grupo]" class="form-control">
								<option value="">Seleccione un Grupo</option>
								@foreach($grupos as $index => $grupo)
									<option value="{{$index}}">{{$grupo}}</option>
								@endforeach
							</select>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<input type="submit" value="Agregar" class="btn btn-primary">
			<a href="{{route('campeonatos_equipos',$campeonato->id)}}" class="btn btn-danger">
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
			             	.attr('name', 'equipos['+id+'][id]')
			             	.val(id)
		       			);
			    	}
			 	} 
			});
   		});
	});
</script>
@stop