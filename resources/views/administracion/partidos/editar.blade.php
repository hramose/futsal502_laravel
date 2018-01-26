@extends('layouts.admin')
@section('title') Editar Partido -
{{$partido->equipo_local->descripcion}} {{$partido->goles_local}} -
{{$partido->equipo_visita->descripcion}} {{$partido->goles_visita}}
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($partido, ['route' => array('editar_partido', $partido->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
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
