<?php

namespace App\App\Entities;

class NotificacionEquipo extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['user_id','equipo_id'];

	protected $table = 'notificacion_equipo';

	public function usuario()
	{
		return $this->belongsTo('App\App\Entities\NotificacionUsuario','user_id');
	}

}