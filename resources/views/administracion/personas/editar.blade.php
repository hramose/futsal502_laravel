@extends('layouts.admin')
@section('title') Editar Persona {{$persona->nombre_completo}} @endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($persona, ['route' => array('editar_persona', $persona->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
		<div class="box-body">
			<div class="row">
	    		<div class="col-lg-3">{!! Field::text('primer_nombre', null, ['data-required'=> 'true']) !!}</div>
	    		<div class="col-lg-3">{!! Field::text('segundo_nombre') !!}</div>
	    		<div class="col-lg-3">{!! Field::text('primer_apellido', null, ['data-required'=> 'true']) !!}</div>
	    		<div class="col-lg-3">{!! Field::text('segundo_apellido') !!}</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-3">{!! Field::text('fecha_nacimiento', null, ['data-required'=> 'true','class'=>'fecha']) !!}</div>
	    		<div class="col-lg-3">{!! Field::select('pais_id', $paises, null, ['data-required'=> 'true']) !!}</div>
	    		<div class="col-lg-3">{!! Field::select('rol', $roles, null, ['data-required'=> 'true']) !!}</div>
	    		<div class="col-lg-3">{!! Field::select('posicion', $posiciones) !!}</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-3">{!! Field::file('fotografia') !!}</div>
	    	</div>
			<div class="row">
	    		<div class="col-lg-3">{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}</div>
	    	</div>
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary">
            <a href="{{ route('personas') }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
<script>	
$(function()
{
	$('.fecha').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es'
    });    
});
</script>
@endsection