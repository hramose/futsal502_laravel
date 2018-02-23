@extends('layouts.admin')
@section('title') Agregar Domo @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => 'agregar_domo', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       {!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::text('direccion', null, ['data-required'=> 'true']) !!}
			{!! Field::file('imagen') !!}
			{!! Field::text('latitud', null, ['data-required'=> 'false']) !!}
			{!! Field::text('longitud', null, ['data-required'=> 'false']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary">
            <a href="{{ route('domos') }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection
