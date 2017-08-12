<?php

namespace App\App\Entities;

use Variable;

class Partido extends \Eloquent {
	protected $fillable = ['equipo_local_id','equipo_visita_id','goles_local','goles_visita','fecha','arbitro_central_id','jornada_id','campeonato_id','domo_id','estado','descripcion_penales'];

	protected $table = 'partido';

	public function equipo_local()
	{
		return $this->belongsTo(Equipo::class,'equipo_local_id');
	}

	public function equipo_visita()
	{
		return $this->belongsTo(Equipo::class,'equipo_visita_id');
	}

	public function domo()
	{
		return $this->belongsTo(Domo::class);
	}

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoPartido($this->estado);
	}

	public function jornada()
	{
		return $this->belongsTo(Jornada::class);
	}

	public function campeonato()
	{
		return $this->belongsTo(Campeonato::class);
	}

	public function arbitro_cental()
	{
		return $this->belongsTo(Persona::class,'arbitro_central_id');
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

}