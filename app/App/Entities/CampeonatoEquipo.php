<?php

namespace App\App\Entities;
use Variable;

class CampeonatoEquipo extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['equipo_id','campeonato_id','grupo'];

	protected $table = 'campeonato_equipo';

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

	public function campeonato()
	{
		return $this->belongsTo(Campeonato::class);
	}

	public function getDescripcionGrupoAttribute()
	{
		return Variable::getGrupo($this->grupo);
	}

}