@extends('layouts.admin')

@section('title') Editar Equipo @stop

@section('content')
<div class="box box-primary">
	{!! Form::model($equipo, ['route' => array('editar_equipo', $equipo->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
		<div class="box-body">	
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::text('descripcion_corta', null, ['data-required'=> 'true']) !!}
	       	{!! Field::text('siglas', null, ['data-required'=> 'true']) !!}
			{!! Field::file('logo') !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary">
            <a href="{{ route('equipos') }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>

@stop