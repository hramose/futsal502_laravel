<?php

namespace App\App\Entities;
use Variable;

class Liga extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion','imagen_app','orden','mostrar_app','estado'];

	protected $table = 'liga';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getImagenAppAttribute($imagen_app)
  {
  	return \Storage::disk('public')->url($imagen_app);
  }

}
