<?php

namespace App\App\Entities;
use Variable;

class Liga extends \Eloquent {

	protected $fillable = ['descripcion','orden','mostrar_app','estado'];

	protected $table = 'liga';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

}