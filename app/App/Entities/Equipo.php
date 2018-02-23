<?php

namespace App\App\Entities;
use Variable;

class Equipo extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion','descripcion_corta','siglas','logo','estado'];

	protected $table = 'equipo';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getLogoAttribute($logo)
  {
  	return \Storage::disk('public')->url($logo);
  }

}
