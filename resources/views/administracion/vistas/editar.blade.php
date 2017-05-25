@extends('layouts.admin')
@section('title') Editar Vista - {{$vista->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($vista, ['route' => array('editar_vista', $vista->id), 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('vistas') }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection