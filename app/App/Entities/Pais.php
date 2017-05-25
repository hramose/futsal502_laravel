<?php

namespace App\App\Entities;
use Variable;

class Pais extends \Eloquent {
	
	protected $fillable = ['descripcion','estado'];

	protected $table = 'pais';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

}