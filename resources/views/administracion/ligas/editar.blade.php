@extends('layouts.admin')
@section('title') Editar Liga {{$liga->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($liga, ['route' => array('editar_liga', $liga->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::number('orden', null, ['data-required'=> 'true']) !!}
			{!! Field::checkbox('mostrar_app') !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary">
            <a href="{{ route('ligas') }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection