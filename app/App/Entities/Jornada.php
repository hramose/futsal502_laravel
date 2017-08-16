<?php

namespace App\App\Entities;
use Variable;

class Jornada extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion','fase','numero','estado'];

	protected $table = 'jornada';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getDescripcionFaseAttribute()
	{
		return Variable::getFase($this->fase);
	}

}