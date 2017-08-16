<?php

namespace App\App\Entities;

class NotificacionUsuario extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['user','token'];

	protected $table = 'notificacion_usuario';

}