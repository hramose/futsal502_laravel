<?php

namespace App\App\Entities;

class CampeonatoEquipo extends \Eloquent {
	
	protected $fillable = ['equipo_id','campeonato_id'];

	protected $table = 'campeonato_equipo';

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

	public function campeonato()
	{
		return $this->belongsTo(Campeonato::class);
	}

}