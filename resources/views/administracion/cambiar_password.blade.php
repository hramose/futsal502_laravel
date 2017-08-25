<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Cambiar Password</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- Bootstrap 3.3.2 -->
		<link href="{{ asset('assets/admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="{{ asset('assets/admin/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- iCheck -->
		<link href="{{ asset('assets/admin/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
  	</head>
  	<body class="login-page">
    	<div class="login-box">
      		<div class="login-logo">
      			<img src="{{asset('assets/imagenes/logos/logo.png')}}" width="200px"><br/>
        		<b>Admininstración</b>
      		</div><!-- /.login-logo -->
      		<div class="login-box-body">
    			<p class="login-box-msg">Cambiar Password</p>
    			{!! Form::open(['route' => ['cambiar_password',$user->id], 'method' => 'PUT', 'role' => 'form', 'class'=>'validate-form']) !!}
	        		@if(Session::has('error'))
		            	<div class="alert alert-danger alert-dismissable">
		              		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		              		<h4>{{Session::get('error')}}</h4>
		           		</div>
		          	@endif
	          		{!! Field::password('password',null,['data-required'=>'true']) !!}
					{!! Field::password('password_confirmation',null,['data-required'=>'true']) !!}
		          	<div class="row">
		            	<div class="col-xs-12">
		              		<button type="submit" class="btn btn-primary btn-block btn-flat">Cambiar</button>
		            	</div><!-- /.col -->
		          	</div>
    			{!! Form::close() !!}
      		</div><!-- /.login-box-body -->
		</div><!-- /.login-box -->

	    <!-- jQuery 2.1.3 -->
	    <script src="{{ asset('assets/admin/plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
	    <!-- Bootstrap 3.3.2 JS -->
	    <script src="{{ asset('assets/admin/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	    <!-- iCheck -->
	    <script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
	    <script>
      		$(function () {
		        $('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' // optional
		        });
      		});
    	</script>
  	</body>
</html>