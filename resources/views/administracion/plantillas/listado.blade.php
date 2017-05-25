@extends('layouts.admin')

@section('title') Personas de {{$campeonatoEquipo->equipo->descripcion}} en Campeonato {{$campeonatoEquipo->campeonato->descripcion}} @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<a href="{{route('agregar_plantilla', [$campeonatoEquipo->id])}}" class="btn btn-primary"> Agregar Personas a Equipo</a>
		<br/><br/>
		<div class="table-responsive">
		{!! Form::open(['route' => array('eliminar_plantilla',$campeonatoEquipo->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="25px"></th>
						<th>NOMBRE</th>
						<th>ROL</th>
						<th>POSICION</th>
						<th>DORSAL</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($personas as $persona)
					<tr>
						<td width="25px">
							<input type="checkbox" name="personas[{{$persona->id}}][seleccionado]">
							<input type="hidden" name="personas[{{$persona->id}}][id]" value="{{$persona->id}}">
						</td>
						<td>{{$persona->persona->nombre_completo}}</td>
						<td>{{$persona->persona->descripcion_rol}}</td>
						<td>{{$persona->persona->descripcion_posicion}}</td>
						<td>{{$persona->dorsal}}</td>
						<td>{{$persona->persona->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_plantilla',$persona->id)}}" class="btn btn-warning btn-sm fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<a value="Eliminar" class="btn btn-primary" onclick="confirmDialog();">Eliminar</a>
			<a href="{{route('campeonatos_equipos',$campeonatoEquipo->campeonato_id)}}" class="btn btn-danger">
				Regresar
			</a>
		{!! Form::close() !!}
		</div>
	</div>
</div>
<div class="modal fade modal-danger" id="modalEliminarPersonas">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">×</span>
              	</button>
                <h4 class="modal-title">Eliminar Personas</h4>
          	</div>
          	<div class="modal-body">
            	<p>¿Esta seguro de querer eliminar las personas seleccionadas?</p>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
                <a class="btn btn-outline" onclick="eliminarPersonas();">Eliminar</a>
          	</div>
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

	function confirmDialog()
	{
		$('#modalEliminarPersonas').modal('show');
	}

	function eliminarPersonas()
	{
		$('#form').submit();
	}
</script>
@stop