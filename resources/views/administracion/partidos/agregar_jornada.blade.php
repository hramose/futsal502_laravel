@extends('layouts.admin')

@section('title') Agregar Jornada @stop

@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/select2/select2.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => array('agregar_partido_jornada', $campeonato->id, $numeroPartidos), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	<div class="box-body">
		<div class="row">
			<div class="col-lg-4">
				{!! Field::select('numero_partidos',[1=>1,2=>2,3=>3,4=>4,5=>5,6=>6], $numeroPartidos,['id'=>'numeroPartidos','data-required'=>'true']) !!}
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				{!! Field::select('jornada_id',$jornadas, null, ['data-required'=>'true']) !!}
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				{!! Field::text('fecha',date('Y-m-d'),['class'=>'fecha', 'data-required'=>'true'] ) !!}
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				
				<div class="table-responsive">
					<table class="table table-responsive">
						
						<tr>
							<th>LOCAL</th>
							<th>VISITA</th>
							<th>DOMO</th>
							<th>ARBITRO</th>
							<th>HORA</th>
						</tr>

						@for ($i = 0; $i < $numeroPartidos; $i++)
				    
						<tr>
							<td>
								<select name="partidos[{{$i}}][local]" class="form-control" data-required="true">
									<option value="">Seleccione</option>
									@foreach($equipos as $equipo)
									<option value="{{$equipo->id}}">{{$equipo->descripcion}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select name="partidos[{{$i}}][visita]" class="form-control" data-required="true">
									<option value="">Seleccione</option>
									@foreach($equipos as $equipo)
									<option value="{{$equipo->id}}">{{$equipo->descripcion}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select name="partidos[{{$i}}][domo]" class="form-control" data-required="false">
									<option value="">Seleccione</option>
									@foreach($domos as $domo)
										<option value="{{$domo->id}}">{{$domo->descripcion}}</option>
									@endforeach
								</select>
							</td>
							<td style="width: 450px">
								<select name="partidos[{{$i}}][arbitro]" class="form-control buscar-select" data-required="false">
									<option value="">Seleccione</option>
									@foreach($arbitros as $arbitro)
									<option value="{{$arbitro->id}}">{{$arbitro->nombre_completo}}</option>
									@endforeach
								</select>
							</td>
							<td style="width: 250px">
								<div class="input-group" >
									<div class="bootstrap-timepicker">
						                <input name="partidos[{{$i}}][hora]"  type="text" class="form-control hora" value="{{ date('0:0') }}">
						            </div>
						    		<span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
						    	</div>
							</td>
						</tr>

						@endfor

					</table>
					<br/><br/><br/><br/>
				</div>
			</div>
		</div>
	</div>
	<div class="box-footer">
        <input type="submit" value="Agregar Jornada" class="btn btn-primary">
        <a href="{{ route('partidos',$campeonato->id) }}" class="btn btn-danger">Cancelar</a>
    </div>
    {!! Form::close() !!}
</div>

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/select2/select2.js')}}"></script>
<script>
	
$(function()
{
	$('#numeroPartidos').on('change',function()
	{
		var numero = $('#numeroPartidos').val();
		if($('#numeroPartidos').val() == '')
			numero = 0;

		var ruta = '{{route("inicio")}}/partidos/agregar-jornada/{{$campeonato->id}}/' + numero;
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

    $('.buscar-select').select2();

});

</script>
@stop