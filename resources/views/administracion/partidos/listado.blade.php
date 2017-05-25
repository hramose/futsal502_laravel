@extends('layouts.admin')

@section('title') Partidos del Campeonato {{$campeonato->descripcion}}@stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
<style>
	th, td{ text-align: center; }
</style>
@stop

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="row">
			<div class="col-lg-12">
				<a href="{{route('agregar_partido_jornada',[$campeonato->id, 5])}}" class="btn btn-primary">Agregar Jornada</a>
				<a href="{{route('editar_partido_jornada',[$campeonato->id, 0])}}" class="btn btn-primary">Editar Jornada</a>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-4">
				{!! Field::select('jornada',$jornadas,null,['id'=>'jornada']) !!}	
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>FECHA</th>
						<th>HORA</th>
						<th>LOCAL</th>
						<th>RESULTADO</th>
						<th>VISITA</th>
						<th>JORNADA</th>
						<th>DOMO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($partidos as $partido)
					<tr class="{{$partido->jornada_id}}">
						<td>{{date('d-m-Y', strtotime($partido->fecha))}}</td>
						<td>{{date('H:i', strtotime($partido->fecha))}}</td>
						<td>{{$partido->equipo_local->descripcion}}</td>				
						<td>{{$partido->goles_local}} - {{$partido->goles_visita}} </td>
						<td>{{$partido->equipo_visita->descripcion}}</td>
						<td>{{$partido->jornada->descripcion}}</td>
						<td>@if($partido->domo) {{$partido->domo->descripcion}} @endif</td>
						<td>
							<a href="{{route('editar_partido',$partido->id)}}" class="btn btn-warning btn-sm fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<a href="{{route('campeonatos',$campeonato->liga_id)}}" class="btn btn-danger btn-flat">
				Regresar
			</a>
		</div>
	</div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		/*$('table').dataTable({
   			"bSort" : true
   		});*/

   		$('#jornada').on('change',function()
   		{
   			if($(this).val()==''){
   				$('tr').show()	
   			}
   			else{
   				$('tbody tr').hide()
   				$('tr.'+$(this).val()).show();
   			}
   		});

	});
</script>
@stop