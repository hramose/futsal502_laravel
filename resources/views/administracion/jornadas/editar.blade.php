@extends('layouts.admin')
@section('title') Editar Jornada @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($jornada, ['route' => array('editar_jornada', $jornada->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">	
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::number('numero', null, ['data-required'=> 'true']) !!}
			{!! Field::select('fase', $fases, null, ['data-required'=> 'true']) !!}  
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary">
            <a href="{{ route('jornadas') }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection