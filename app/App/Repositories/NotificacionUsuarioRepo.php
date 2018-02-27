<?php

namespace App\App\Repositories;

use App\App\Entities\NotificacionUsuario;

class NotificacionUsuarioRepo extends BaseRepo{

	public function getModel()
	{
		return new NotificacionUsuario;
	}

	public function getByUsuario($user)
	{
		return NotificacionUsuario::where('usuario',$user)->first();
	}

}
