<?php

namespace App\App\Entities;
use Variable;

class Categoria extends \Eloquent {

	protected $fillable = ['descripcion','estado'];

	protected $table = 'categoria';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

}