<?php

namespace App\App\Entities;

class NotificacionUsuario extends \Eloquent {
	
	protected $fillable = ['user','token'];

	protected $table = 'notificacion_usuario';

}