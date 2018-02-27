<?php

namespace App\App\Entities;

class NotificacionUsuario extends \Eloquent {

	use UserStamps;

	protected $fillable = ['usuario','estado'];

	protected $table = 'notificacion_usuario';

}
