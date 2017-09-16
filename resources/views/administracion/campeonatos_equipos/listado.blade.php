@extends('layouts.admin')

@section('title') Equipos de Campeonato {{$campeonato->descripcion}} @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<a href="{{route('agregar_equipos_campeonato', [$campeonato->id])}}" class="btn btn-primary"> Agregar Equipos</a>
		<a href="{{route('trasladar_equipos_campeonato', [$campeonato->id, 0])}}" class="btn btn-info"> Trasladar Equipos</a>
		<br/><br/>
		<div class="table-responsive">
		{!! Form::open(['route' => array('editar_equipos_campeonato',$campeonato->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="25px"></th>
						<th>EQUIPO</th>
						<th width="100px">GRUPO</th>
						<th></th>			
					</tr>
				</thead>
				<tbody>
					@foreach($equipos as $equipo)
					<tr>
						<td width="25px">
							<input type="checkbox" name="equipos[{{$equipo->id}}][seleccionado]">
							<input type="hidden" name="equipos[{{$equipo->id}}][id]" value="{{$equipo->id}}">
						</td>
						<td>{{$equipo->equipo->descripcion}}</td>
						<td>{{$equipo->descripcion_grupo}}</td>
						<td>
							<a href="{{route('plantillas', $equipo->id)}}" class="btn btn-info btn-sm fa fa-user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Personas"></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<a value="Eliminar" class="btn btn-primary" onclick="confirmDialog();">Eliminar</a>
			<a href="{{route('campeonatos',$campeonato->liga_id)}}" class="btn btn-danger">
				Regresar
			</a>
		{!! Form::close() !!}
		</div>
	</div>
</div>
<div class="modal fade modal-danger" id="modalEliminarEquipos">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">×</span>
              	</button>
                <h4 class="modal-title">Eliminar Equipos</h4>
          	</div>
          	<div class="modal-body">
            	<p>¿Esta seguro de querer eliminar los equipos seleccionados?</p>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
                <a class="btn btn-outline" onclick="eliminarEquipos();">Eliminar</a>
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
			             	.attr('name', 'equipos['+id+'][id]')
			             	.val(id)
		       			);
			    	}
			 	} 
			});
   		});
	});

	function confirmDialog()
	{
		$('#modalEliminarEquipos').modal('show');
	}

	function eliminarEquipos()
	{
		$('#form').submit();
	}
</script>
@stop