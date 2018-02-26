@extends('layouts.admin')
@section('title') Agregar Liga @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => 'agregar_liga', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::number('orden', null, ['data-required'=> 'true']) !!}
			{!! Field::checkbox('mostrar_app') !!}
			{!! Field::file('imagen_app') !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary">
            <a href="{{ route('ligas') }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection
