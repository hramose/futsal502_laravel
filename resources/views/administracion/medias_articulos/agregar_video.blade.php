@extends('layouts.admin')
@section('title') Agregar Vídeo - Articulo {{$articulo->titulo}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => ['agregar_video_articulo',$articulo->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
	       	{!! Field::text('ruta', null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary">
            <a href="{{ route('medias_articulos',$articulo->id) }}" class="btn btn-danger">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection