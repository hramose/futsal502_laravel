<?php

namespace App\App\Entities;
use Variable;

class Domo extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion','direccion','imagen','longitud','latitud','estado'];

	protected $table = 'domo';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getImagenAttribute($imagen)
  {
  	return \Storage::disk('public')->url($imagen);
  }

}
