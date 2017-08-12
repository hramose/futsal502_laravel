@extends('layouts.admin')
@section('title') Editar Categoria - {{$categoria->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($categoria, ['route' => array('editar_categoria', $categoria->id), 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('categorias') }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection