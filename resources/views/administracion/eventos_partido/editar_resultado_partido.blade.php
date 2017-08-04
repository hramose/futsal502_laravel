@extends('layouts.admin')
@section('title') Editar Partido - 
{{$partido->equipo_local->descripcion}} {{$partido->goles_local}} -
{{$partido->equipo_visita->descripcion}} {{$partido->goles_visita}}
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($partido, ['route' => array('editar_resultado_partido', $partido->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">	
			{!! Field::text('goles_local', null, ['data-required'=> 'true']) !!}
			{!! Field::text('goles_visita', null, ['data-required'=> 'true']) !!}
			{!! Field::text('descripcion_penales', null, ['data-required'=> 'false']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary">
            <a href="{{ route('monitorear_partido',[$partido->campeonato->liga_id, $partido->campeonato_id, $partido->jornada_id, $partido->id, $partido->equipo_local_id]) }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection