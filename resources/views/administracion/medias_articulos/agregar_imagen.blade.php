@extends('layouts.admin')
@section('title') Agregar Imagen - Articulo {{$articulo->titulo}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => ['agregar_imagen_articulo',$articulo->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::file('imagenes[]', null, ['data-required'=> 'true','multiple']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary">
            <a href="{{ route('medias_articulos',$articulo->id) }}" class="btn btn-danger">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection