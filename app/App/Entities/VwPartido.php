<?php

namespace App\App\Entities;
use Variable;

class VwPartido extends \Eloquent {

	use UserStamps;

	protected $table = 'vw_partido';

  public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoPartido($this->estado);
	}

  public function getGolesLocalAttribute($goles_local)
	{
		if(!is_null($goles_local))
			return $goles_local;
		return '-';
	}

	public function getGolesVisitaAttribute($goles_visita)
	{
		if(!is_null($goles_visita))
			return $goles_visita;
		return '-';
	}

  public function getLogoEquipoLocalAttribute($logo_equipo_local)
  {
  	return \Storage::disk('public')->url($logo_equipo_local);
  }

  public function getLogoEquipoVisitaAttribute($logo_equipo_visita)
  {
  	return \Storage::disk('public')->url($logo_equipo_visita);
  }

}
