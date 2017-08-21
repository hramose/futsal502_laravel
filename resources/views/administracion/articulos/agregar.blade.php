@extends('layouts.admin')
@section('title') Agregar Artículo @endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/admin/plugins/iCheck/all.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/plugins/summernote/summernote.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/plugins/summernote/summernote-bs3.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/plugins/datetimepicker/datetimepicker.css')}}" >
@stop
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => 'agregar_articulo', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::text('titulo', null, ['data-required'=> 'true']) !!}
			{!! Field::file('imagen_portada') !!}
			{!! Field::select('categoria_id', $categorias, null, ['data-required'=> 'true']) !!}
			{!! Field::text('descripcion_corta', null, ['data-required'=> 'false']) !!}
			{!! Field::textarea('descripcion', null, ['data-required'=> 'true','id'=>'summernote']) !!}
			{!! Field::text('fecha_publicacion', null, ['data-required'=> 'true','id'=>'fecha']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=>'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('articulos') }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{asset('assets/admin/plugins/moment/moment.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/moment/locale/es.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datetimepicker/datetimepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/summernote/summernote.js') }}"></script>
<script>
	$(function(){

		$('#fecha').datetimepicker({
			locale: 'es',
			format: 'YYYY-MM-DD HH:m'
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