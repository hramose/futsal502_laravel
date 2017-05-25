@extends('layouts.admin')
@section('title') 
Editar Jornada - @if($jornada){{$jornada->descripcion}}@endif {{$campeonato->descripcion}} 
@stop
@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
@stop
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => array('editar_partido_jornada',$campeonato->id, $jornadaId), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::select('jornada',$jornadas,$jornadaId,['id'=>'jornada_id']) !!}
			
			@if(isset($partidos))
			<div class="table-responsive">
				<table class="table table-responsive table-striped">
					<thead>
						<tr>
							<th>FECHA</th>
							<th>HORA</th>
							<th>LOCAL</th>
							<th>VISITA</th>
							<th>ARBITRO</th>
							<th>DOMO</th>
						</tr>
					</thead>
					<tbody>
						@foreach($partidos as $partido)
						<tr>
							<td>
								<input type="hidden" name="partidos[{{$partido->id}}][id]" value="{{$partido->id}}">
								<input type="text" name="partidos[{{$partido->id}}][fecha]" 
										value="{{date('Y-m-d',strtotime($partido->fecha))}}" class="form-control fecha" >
							</td>
							<td>
								<div class="input-group" style="width: 250px">
									<div class="bootstrap-timepicker">
			                            <input name="partidos[{{$partido->id}}][hora]"  type="text" class="form-control hora"
			                            		value="{{date('H:i', strtotime($partido->fecha))}}">
			                        </div>
	                        		<span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
	                        	</div>
							</td>
							<td>{{$partido->equipo_local->descripcion}}</td>
							<td>{{$partido->equipo_visita->descripcion}}</td>							
							<td>
								<select name="partidos[{{$partido->id}}][arbitro_central_id]" class="form-control">
									<option value="">Seleccione un arbitro</option>
									@foreach($arbitros as $arbitro)
										@if($arbitro->id == $partido->arbitro_central_id)
											<option value="{{$arbitro->id}}" selected="selected">{{$arbitro->nombre_completo}}</option>
										@else
											<option value="{{$arbitro->id}}">{{$arbitro->nombre_completo}}</option>
										@endif
									@endforeach

								</select>
							</td>
							<td>
								<select name="partidos[{{$partido->id}}][domo_id]" class="form-control">
									<option value="">Seleccione un Domo</option>
									@foreach($domos as $domo)
										@if($domo->id == $partido->domo_id)
											<option value="{{$domo->id}}" selected="selected">{{$domo->descripcion}}</option>
										@else
											<option value="{{$domo->id}}">{{$domo->descripcion}}</option>
										@endif
									@endforeach

								</select>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<br/><br/><br/><br/><br/>
			</div>
			@endif
		</div>
		<div class="box-footer">
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('partidos',$campeonato->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </div>
	{!! Form::close() !!}
</div

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
<script>
	
$(function()
{
	$('#jornada_id').on('change',function()
	{
		var ruta = '{{route("inicio")}}/partidos/editar-jornada/{{$campeonato->id}}/' + $('#jornada_id').val();
		window.location.href = ruta;
	})

	$('.fecha').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es'
    });
    // Time Picker
    $('.hora').timepicker({
    	showMeridian : false
    });

});

</script>
@stop