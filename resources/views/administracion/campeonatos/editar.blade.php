@extends('layouts.admin')
@section('title') Editar Campeonato @endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($campeonato, ['route' => array('editar_campeonato', $campeonato->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
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
		    <input type="submit" value="Editar" class="btn btn-primary">
            <a href="{{ route('campeonatos',$campeonato->liga_id) }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js')}}"></script>
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