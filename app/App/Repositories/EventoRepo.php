<?php

namespace App\App\Repositories;

use App\App\Entities\Evento;

class EventoRepo extends BaseRepo{

	public function getModel()
	{
		return new Evento;
	}

}