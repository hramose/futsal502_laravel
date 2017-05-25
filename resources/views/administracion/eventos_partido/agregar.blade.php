@extends('layouts.admin')

@section('title') Agregar Evento {{$evento->descripcion}} @stop

@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => array('agregar_evento_partido',$partido->id, $evento->id, $equipoId), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">

			<div class="row">
				<div class="col-lg-4">{!! Field::checkbox('facebook') !!}</div>
			</div>
			<div class="row">
				<div class="col-lg-4">{!! Field::checkbox('twitter') !!}</div>
			</div>
			<div class="row">
				<div class="col-lg-4">{!! Field::number('minuto', $minuto, ['data-required'=>'true']) !!}</div>
			</div>
			<div class="row">
				<div class="col-lg-4">{!! Field::number('segundo', $segundo, ['data-required'=>'true']) !!}</div>
			</div>
			@if($evento->id == 10)
			<div class="row">
				<div class="col-lg-4">{!! Field::textarea('comentario', null, ['data-required'=>'true', 'id'=>'comentario']) !!}</div>
			</div>
			<div class="row">
				<div class="col-lg-4">{!! Field::checkbox('publicar_minuto') !!}</div>
			</div>
			@endif
		</div>
		<div class="box-footer">
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('monitorear_partido',[$partido->campeonato->liga_id, $partido->campeonato_id,$partido->jornada_id,$partido->id,$equipoId]) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </div>
	{!! Form::close() !!}
</div>

@stop

@section('js')

<script>
	
$(function(){
	$('input[name="facebook"').attr('checked','checked');
	$('input[name="twitter"').attr('checked','checked');
	$('input[name="publicar_minuto"').attr('checked','checked');


})

</script>

@stop