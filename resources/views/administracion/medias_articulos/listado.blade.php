@extends('layouts.admin')
@section('title') Medias de {{$articulo->titulo}} @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
<link href="{{asset('assets/admin/plugins/custombox/dist/custombox.min.css')}}" rel="stylesheet">
<style>
	.img-wrap {
    	position: relative;
	}
	.img-wrap .close {
	    position: absolute;
	    top: 2px;
	    right: 2px;
	    z-index: 100;
	    opacity: 0.8
	}
</style>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_imagen_articulo',$articulo->id)}}" class="btn btn-primary">Agregar Imagen</a>
			<a href="{{route('agregar_video_articulo',$articulo->id)}}" class="btn btn-primary">Agregar Video</a>
			<hr>
		</div>
		<div class="row">
			@foreach($medias as $media)
				<div class="col-lg-3" style="margin-bottom: 10px">
					@if($media->tipo == 'I')
						<div class="img-wrap">
						    <a onclick="showDeleteModal({{$media->id}})" class="btn btn-danger fa fa-times close"></a>
						    <img src="{{$media->ruta}}" width="100%">
						</div>						
					@elseif($media->tipo == 'V')
						<div class="img-wrap">
						    <a onclick="showDeleteModal({{$media->id}})" class="btn btn-danger fa fa-times close"></a>
						    <iframe src="{{$media->ruta}}" width="100%"></iframe>
						</div>						
					@endif
				</div>
			@endforeach
		</div>
	</div>
</div>
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
  		{!! Form::open(['route' => array('eliminar_media_articulo',0), 'method' => 'DELETE', 'role' => 'form', 'class' => 'validate-form']) !!}
    		<div class="modal-content">
      			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Eliminar Media</h4>
      			</div>
      			<div class="modal-body">
        			<input type="hidden" id="media_articulo_id" name="media_articulo_id">
    				¿Está seguro que desea eliminar esta media del articulo?
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-danger">Eliminar</button>
      			</div>
    		</div><!-- /.modal-content -->
    	{!! Form::close() !!}
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('.table').dataTable({
   			"bSort" : true
   		});
	});

	function showDeleteModal(id)
	{
		$('#media_articulo_id').val(id);
		$('#modalDelete').modal('show');
	}
</script>
@endsection