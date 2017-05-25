<?php

namespace App\App\Repositories;

use App\App\Entities\Jornada;

class JornadaRepo extends BaseRepo{

	public function getModel()
	{
		return new Jornada;
	}

	public function getByFase($fases)
	{
		return Jornada::whereIn('fase',$fases)
						->orderBy('fase')
						->orderBy('numero')
						->get();
	}

}