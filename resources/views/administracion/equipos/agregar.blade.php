@extends('layouts.admin')
@section('title') Agregar Equipo @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => 'agregar_equipo', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
	       	{!! Field::text('descripcion_corta', null, ['data-required'=> 'true']) !!}
	       	{!! Field::text('siglas', null, ['data-required'=> 'true']) !!}
			{!! Field::file('logo') !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}   
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary">
            <a href="{{ route('equipos') }}" class="btn btn-danger">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection