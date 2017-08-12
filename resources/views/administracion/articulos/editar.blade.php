@extends('layouts.admin')
@section('title') Editar Articulo - {{$articulo->titulo}} @endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/admin/plugins/iCheck/all.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/plugins/summernote/summernote.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/plugins/summernote/summernote-bs3.css')}}">
<link href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="box box-primary">
	{!! Form::model($articulo, ['route' => array('editar_articulo', $articulo->id), 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
		<div class="box-body">
			{!! Field::text('titulo', null, ['data-required'=> 'true']) !!}
			{!! Field::file('imagen_portada') !!}
			@if($articulo->imagen_portada)
			<img src="{{$articulo->imagen_portada}}" alt="">
			<br/><br/>
			@endif
			{!! Field::select('categoria_id', $categorias, null, ['data-required'=> 'true']) !!}
			{!! Field::text('descripcion_corta', null, ['data-required'=> 'false']) !!}
			{!! Field::textarea('descripcion', null, ['data-required'=> 'true','id'=>'summernote']) !!}
			{!! Field::text('fecha_publicacion', null, ['data-required'=> 'true','class'=>'fecha']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=>'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('articulos') }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/summernote/summernote.js') }}"></script>
<script>
	$(function(){

		$('.fecha').datepicker({
    		format: 'yyyy-mm-dd',
		    autoclose: true,
		    todayHighlight: true
		});

		$('input[type="checkbox"]').iCheck({
			checkboxClass: 'icheckbox_flat-green'
    	});
    	$('#summernote').summernote({
    		height: 300
    	});

    	$('#form').on('submit', function(){
	    	$('#summernote').val($('#summernote').code());
	    });
	});
</script>
@endsection