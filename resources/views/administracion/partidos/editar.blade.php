@extends('layouts.admin')
@section('title') Editar Partido -
{{$partido->equipo_local->descripcion}} {{$partido->goles_local}} -
{{$partido->equipo_visita->descripcion}} {{$partido->goles_visita}}
@endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($partido, ['route' => array('editar_partido', $partido->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::text('fecha',date('Y-m-d',strtotime($partido->fecha)),['class'=>'fecha', 'data-required'=>'true'] ) !!}
			<div class="form-group">
				<label for="">Hora:</label>
				<div class="input-group" >
					<div class="bootstrap-timepicker">
						<input name="hora"  type="text" class="form-control hora" value="{{ date('H:i',strtotime($partido->fecha)) }}">
					</div>
					<span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
				</div>
			</div>
			{!! Field::text('goles_local', null, ['data-required'=> 'false']) !!}
			{!! Field::text('goles_visita', null, ['data-required'=> 'false']) !!}
			{!! Field::text('descripcion_penales', null, ['data-required'=> 'false']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'false']) !!}

		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary">
            <a href="{{ route('partidos',$partido->campeonato_id) }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
<script>

$(function()
{
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
@endsection
