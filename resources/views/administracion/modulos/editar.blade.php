@extends('layouts.admin')
@section('title') Editar Modulo - {{$modulo->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($modulo, ['route' => array('editar_modulo', $modulo->id), 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('modulos') }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection