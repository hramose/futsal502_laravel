@extends('layouts.admin')
@section('title') 
Editar {{$plantilla->persona->nombre_completo}} de {{$plantilla->equipo->descripcion}} 
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($plantilla, ['route' => array('editar_plantilla', $plantilla->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::text('nombre_completo', $plantilla->persona->nombre_completo, ['disabled']) !!}
			{!! Field::text('rol', $plantilla->persona->descripcion_rol, ['disabled']) !!}
			{!! Field::text('posicion', $plantilla->persona->descripcion_posicion, ['disabled']) !!}
			{!! Field::text('dorsal', null, ['data-required'=> 'false']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary">
            <a href="{{ route('plantillas',$plantilla->id) }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection