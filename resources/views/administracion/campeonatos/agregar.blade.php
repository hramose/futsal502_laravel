@extends('layouts.admin')
@section('title') {{$liga->descripcion}} - Agregar Campeonato @endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => ['agregar_campeonato', $liga->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::text('fecha_inicio', null, ['data-required'=> 'true','class'=>'fecha']) !!}
			{!! Field::text('fecha_fin', null, ['data-required'=> 'true','class'=>'fecha']) !!}
			{!! Field::checkbox('mostrar_app') !!}
			{!! Field::checkbox('actual') !!}
			{!! Field::text('hashtag') !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary">
            <a href="{{ route('campeonatos',$liga->id) }}" class="btn btn-danger">Cancelar</a>     
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