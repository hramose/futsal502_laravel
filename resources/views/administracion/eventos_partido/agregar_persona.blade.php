@extends('layouts.admin')

@section('title') Agregar Evento {{$evento->descripcion}} - {{$equipo->descripcion}} @stop

@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => array('agregar_evento_partido_persona',$partido->id,$evento->id,$equipo->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	<div class="box-body">
		<div class="row">
			<div class="col-lg-4">{!! Field::checkbox('facebook') !!}</div>
		</div>
		<div class="row">
			<div class="col-lg-4">{!! Field::checkbox('twitter') !!}</div>
		</div>
		<div class="row">
			<div class="col-lg-4">{!! Field::number('minuto', null, ['data-required'=>'true']) !!}</div>
		</div>
		<div class="row">
			<div class="col-lg-4">{!! Field::number('segundo', null, ['data-required'=>'true']) !!}</div>
		</div>
		<div class="row">
			<div class="col-lg-4">{!! Field::select('persona_id',$personas, null, ['data-required'=>'true']) !!}</div>
		</div>
		@if($evento->id == 9)
			{!! Field::checkbox('doble_amarilla') !!}
		@endif		
	</div>
	<div class="box-footer">
        <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
        <a href="{{ route('monitorear_partido',[$partido->campeonato->liga_id, $partido->campeonato_id,$partido->jornada_id,$partido->id,$equipo->id]) }}" class="btn btn-danger btn-flat">Cancelar</a>
    </div>
	{!! Form::close() !!}
</div>
@stop
@section('js')

<script>
	
$(function(){
	$('input[name="facebook"').attr('checked','checked');
	$('input[name="twitter"').attr('checked','checked');
})

</script>

@stop