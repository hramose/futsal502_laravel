@extends('layouts.admin')
@section('title') Agregar Perfil @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => 'agregar_perfil', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
	       	{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('perfiles') }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection